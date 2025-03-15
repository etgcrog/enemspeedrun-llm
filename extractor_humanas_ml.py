import fitz  # PyMuPDF para extração de texto/imagens
import re
import json
import os
import torch
from transformers import BertTokenizer, BertForSequenceClassification

# 🔹 Carregar modelo treinado
model_path = r"BERT\modelo_bibliografia"
print(f"📥 Carregando modelo de {model_path}...")
tokenizer = BertTokenizer.from_pretrained(model_path)
model = BertForSequenceClassification.from_pretrained(model_path)

device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
model.to(device)
print(f"✅ Modelo carregado e enviado para {device}")

# 🔹 Função para classificar um texto como pergunta ou bibliografia com um limiar de confiança
def classify_text(text, threshold=0.9):
    inputs = tokenizer(text, return_tensors="pt", truncation=True, padding=True, max_length=128).to(device)
    outputs = model(**inputs)
    logits = outputs.logits
    probs = torch.nn.functional.softmax(logits, dim=1)

    predicted_class = torch.argmax(probs, dim=1).item()
    confidence = probs[0][predicted_class].item()

    labels_map = {0: "nao_bibliografia", 1: "bibliografia"}

    if confidence >= threshold:
        return labels_map[predicted_class]
    return "nenhum"

# 📂 Caminho do PDF
pdf_path = r"raw\2022\exams\P1\dia1.pdf"
doc = fitz.open(pdf_path)

# Criar diretório para salvar imagens extraídas
image_output_folder = "imagens_enem"
os.makedirs(image_output_folder, exist_ok=True)

# 🏁 Processar páginas
start_page = 6
end_page = len(doc)

# 🔍 Função para extrair imagens
def extrair_imagens(doc):
    imagens_extraidas = {}
    for page_num in range(start_page, end_page):
        page = doc[page_num]
        imagens = []

        for img_index, img in enumerate(page.get_images(full=True)):
            xref = img[0]
            base_image = doc.extract_image(xref)
            image_bytes = base_image["image"]

            img_filename = f"questao_{page_num+1}_{img_index+1}.png"
            img_path = os.path.join("imagens_enem", img_filename)
            img_full_path = os.path.abspath(img_path)

            with open(img_full_path, "wb") as img_file:
                img_file.write(image_bytes)

            imagens.append(img_full_path)

        if imagens:
            imagens_extraidas[page_num] = imagens
    return imagens_extraidas

imagens_extraidas = extrair_imagens(doc)

questoes = []
questao_atual = None
bibliografias = []
secao_atual = "enunciado"

for page_num in range(start_page, end_page):
    page = doc[page_num]
    text = page.get_text("text")
    linhas = text.split("\n")
    imagens_pagina = imagens_extraidas.get(page_num, [])
    imagem_inserida = False

    for linha in linhas:
        linha_strip = linha.strip()
        if not linha_strip:
            continue

        match_questao = re.search(r"Questão (\d+) -", linha_strip)
        match_alternativa = re.match(r"^[A-E]$", linha_strip)
        classificacao = classify_text(linha_strip)

        if match_questao:
            if questao_atual:
                questao_atual["bibliografia"] = "\n".join(bibliografias) if bibliografias else None
                for alt in questao_atual["alternativas"]:
                    questao_atual["alternativas"][alt] = questao_atual["alternativas"][alt].rstrip(" /,.")
                questoes.append(questao_atual)

            questao_atual = {"numero": match_questao.group(1), "titulo": "", "enunciado": "", "pergunta": "", "alternativas": {}, "bibliografia": None, "imagens": imagens_pagina}
            bibliografias = []
            secao_atual = "enunciado"
            imagem_inserida = False
            continue

        if classificacao == "bibliografia":
            bibliografias.append(linha_strip)
            secao_atual = "bibliografia"
            continue

        if match_alternativa:
            secao_atual = "alternativas"
            questao_atual["alternativas"][linha_strip] = ""
            continue

        if secao_atual == "bibliografia" and classificacao != "bibliografia":
            secao_atual = "pergunta"

        if secao_atual == "enunciado" or ('TEXTO' in linha_strip and secao_atual != "alternativas"):
            if questao_atual is not None:
                if (linha_strip.startswith('TEXTO II') or linha_strip.startswith('TEXTO I')) and imagens_pagina and not imagem_inserida:
                    questao_atual["enunciado"] += linha_strip + " [imagem] "
                    imagem_inserida = True
                else:
                    questao_atual["enunciado"] += linha_strip + " "
            secao_atual = "enunciado"
        elif secao_atual == "pergunta":
            questao_atual["pergunta"] += linha_strip + " "

        if secao_atual == "alternativas":
            ultima_alternativa = list(questao_atual["alternativas"].keys())[-1]
            questao_atual["alternativas"][ultima_alternativa] += linha_strip.strip() + " "

if questao_atual:
    questao_atual["bibliografia"] = "\n".join(bibliografias) if bibliografias else None
    for alt in questao_atual["alternativas"]:
        questao_atual["alternativas"][alt] = questao_atual["alternativas"][alt].rstrip(" /,.")
    questoes.append(questao_atual)

json_file_path = r"C:\Users\etgcr\Documents\enemspeedrun\questoes_enem_2022_ML.json"
with open(json_file_path, "w", encoding="utf-8") as json_file:
    json.dump(questoes, json_file, indent=4, ensure_ascii=False)

print(f"\n✅ Extração concluída! JSON salvo em: {json_file_path}")