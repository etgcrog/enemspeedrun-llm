import os
import json
import cv2
import re
import fitz
import base64
from pdf2image import convert_from_path
from ultralytics import YOLO

# Configurações
dpi = 150
output_folder = "detected_subareas"
output_json_path = os.path.join(output_folder, "subareas_detected.json")
pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"
model_path = "runs/detect/train/weights/best.pt"

# Cria pasta de saída
os.makedirs(output_folder, exist_ok=True)

# Carrega modelo YOLO
model = YOLO(model_path)

# Abre PDF
doc = fitz.open(pdf_path)

# Lista para armazenar dados de todas as questões
all_questoes_data = []

# Loop em todas as páginas
for page_num in range(6, len(doc)):
    page = doc[page_num]
    text = page.get_text("text")
    linhas = text.split("\n")
    numero_questao = next(
        (match.group(1).zfill(2) for linha in linhas if (match := re.search(r"Questão (\d+) -", linha.strip()))),
        str(page_num + 1).zfill(2)
    )

    # Converte página do PDF em imagem na memória
    images = convert_from_path(pdf_path, first_page=page_num + 1, last_page=page_num + 1, dpi=dpi)
    image = images[0]

    questao_data = {
        "numero": numero_questao,
        "titulo": "",
        "enunciado": "",
        "pergunta": "",
        "alternativas": {},
        "bibliografia": "",
        "imagens": []
    }

    results = model(image, conf=0.5, iou=0.5)

    for result in results:
        boxes = result.boxes.xyxy
        labels = result.boxes.cls
        confs = result.boxes.conf

        for box, label, conf in zip(boxes, labels, confs):
            if conf < 0.5:
                continue

            x1, y1, x2, y2 = map(int, box)
            label_name = model.names[int(label)]

            # Recorta a imagem na memória
            cropped_img = image.crop((x1, y1, x2, y2))

            # Transforma imagem em base64 PNG diretamente na memória
            import io
            from PIL import Image
            buffered = io.BytesIO()
            cropped_img.save(buffered, format="PNG")
            img_base64 = base64.b64encode(buffered.getvalue()).decode()

            # Salva no JSON (imagem como base64)
            if label_name.lower() == "enunciado":
                questao_data["enunciado"] = img_base64
            elif label_name.lower() == "pergunta":
                questao_data["pergunta"] = img_base64
            elif label_name.startswith("alternativa_"):
                letra_alternativa = label_name.split("_")[-1].upper()
                if letra_alternativa in ["A", "B", "C", "D", "E"]:
                    questao_data["alternativas"][letra_alternativa] = img_base64
            elif label_name.lower() == "bibliografia":
                questao_data["bibliografia"] = img_base64
            elif label_name.lower() == "imagem":
                questao_data["imagens"].append(img_base64)

    all_questoes_data.append(questao_data)

# Salvar JSON com todas as questões
with open(output_json_path, "w", encoding="utf-8") as json_file:
    json.dump(all_questoes_data, json_file, indent=4, ensure_ascii=False)

print(f"✅ JSON salvo em: {output_json_path}")
