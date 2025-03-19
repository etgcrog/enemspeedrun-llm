import os
import json
import subprocess
from pdf2image import convert_from_path
from PIL import Image
import pdfplumber

# 🔹 Caminho do Potrace
potrace_path = r"C:\Users\etgcr\enemspeedrun-llm\SVGmodel\potrace.exe"

# 🔹 Configuração global
dpi = 72  # Mantendo 1 ponto = 1 pixel
output_folder = "subareas_extraidas"
output_json_path = "subareas_convertidas.json"
input_json_path = r"C:\Users\etgcr\enemspeedrun-llm\SVGmodel\manual_classification\dataset\classified_data.json"
pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"

# 🔹 Criar pasta de saída, se não existir
os.makedirs(output_folder, exist_ok=True)

# 🔹 Carregar JSON com coordenadas anotadas
with open(input_json_path, "r", encoding="utf-8") as json_file:
    annotated_data = json.load(json_file)

# 🔹 Processar todas as páginas do JSON
output_data = {}

# 🔹 1️⃣ Abrir o PDF para pegar todas as páginas
with pdfplumber.open(pdf_path) as pdf:
    for page_key, areas in annotated_data.items():
        # Extrair número da página
        page_number = int(page_key.replace("page_", ""))
        
        # Verificar se a página existe no PDF
        if page_number > len(pdf.pages):
            print(f"⚠️ Página {page_number} não existe no PDF, pulando...")
            continue

        print(f"\n📄 Processando Página {page_number}...")

        # 🔹 2️⃣ Obter tamanho exato da página
        pdf_page = pdf.pages[page_number - 1]
        pdf_width, pdf_height = pdf_page.width, pdf_page.height
        print(f"✅ Tamanho da página {page_number}: {pdf_width}x{pdf_height} pontos")

        # 🔹 3️⃣ Converter página do PDF para imagem
        images = convert_from_path(pdf_path, first_page=page_number, last_page=page_number, dpi=dpi)
        image = images[0]
        page_image_path = os.path.join(output_folder, f"page_{page_number}.png")
        image.save(page_image_path, "PNG")
        print(f"✅ Imagem da página {page_number} salva: {page_image_path}")

        # 🔹 4️⃣ Processar cada anotação na página
        page_data = []

        for area in areas:
            bbox = area["bbox"]
            label = area["label"]

            print(f"🔍 Extraindo '{label}' da página {page_number}: {bbox}")

            # 🔹 Recortar a subárea e salvar como PNG
            cropped_image = image.crop(bbox)
            sub_image_path = os.path.join(output_folder, f"page_{page_number}_{label}.png")
            cropped_image.save(sub_image_path, "PNG")
            print(f"✅ Imagem da subárea '{label}' salva: {sub_image_path}")

            # 🔹 Converter para SVG usando Potrace
            svg_path = sub_image_path.replace(".png", ".svg")
            bmp_image_path = sub_image_path.replace(".png", ".bmp")

            with Image.open(sub_image_path) as img:
                img.save(bmp_image_path, "BMP")

            subprocess.run([potrace_path, bmp_image_path, "-s", "-o", svg_path], check=True)
            os.remove(bmp_image_path)

            print(f"✅ SVG salvo: {svg_path}")

            # 🔹 Extrair texto da subárea no PDF
            text = pdf_page.within_bbox(bbox).extract_text()

            # 🔹 Adicionar os dados ao JSON
            page_data.append({
                "label": label,
                "bbox": bbox,
                "text": text.strip() if text else "",
                "svg_path": svg_path
            })

        output_data[page_key] = page_data

# 🔹 Salvar todas as informações no JSON final
with open(output_json_path, "w", encoding="utf-8") as json_file:
    json.dump(output_data, json_file, indent=4, ensure_ascii=False)

print(f"\n✅ JSON salvo: {output_json_path}")
