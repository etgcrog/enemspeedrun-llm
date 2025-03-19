import os
import subprocess
import json
import cv2
import pdfplumber
from pdf2image import convert_from_path
from PIL import Image
from ultralytics import YOLO

# 🔹 Caminho do Potrace (ajuste se necessário)
potrace_path = r"C:\Users\etgcr\enemspeedrun-llm\SVGmodel\potrace.exe"

# 🔹 Configuração global
dpi = 72  # Mantendo 1 ponto = 1 pixel
output_folder = "detected_subareas"
output_json_path = os.path.join(output_folder, "subareas_detected.json")
pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"
page_number = 24  # Página para detecção
model_path = "runs/detect/train/weights/best.pt"  # Modelo treinado

# 🔹 Criar pasta de saída, se não existir
os.makedirs(output_folder, exist_ok=True)

# 🔹 1️⃣ Converter PDF para imagem
with pdfplumber.open(pdf_path) as pdf:
    pdf_page = pdf.pages[page_number - 1]
    pdf_width, pdf_height = pdf_page.width, pdf_page.height
    print(f"📄 Tamanho da página no PDF: {pdf_width}x{pdf_height} pontos")

# 🔹 Converter para imagem
images = convert_from_path(pdf_path, first_page=page_number, last_page=page_number, dpi=dpi)
image = images[0]
image_path = os.path.join(output_folder, f"page_{page_number}.png")
image.save(image_path, "PNG")

# 🔹 Verificar tamanho da imagem gerada
image_width, image_height = image.size
print(f"✅ Imagem gerada com tamanho: {image_width}x{image_height} pixels")

# 🔹 2️⃣ Carregar modelo YOLOv8 treinado
model = YOLO(model_path)

results = model(image_path, conf=0.14)


# 🔹 Processar detecções
data = {}

for result in results:
    boxes = result.boxes.xyxy  # Coordenadas detectadas (x1, y1, x2, y2)
    labels = result.boxes.cls  # Classes detectadas
    confs = result.boxes.conf  # Confiança de cada detecção

    for i, (box, label, conf) in enumerate(zip(boxes, labels, confs)):
        x1, y1, x2, y2 = map(int, box)
        label_name = model.names[int(label)]  # Nome da classe detectada

        print(f"🔍 Detectado: {label_name} - Confiança: {conf:.2f} - Coordenadas: ({x1}, {y1}, {x2}, {y2})")

        # 🔹 Recortar e salvar a subárea
        bbox = (x1, y1, x2, y2)
        sub_image_path = os.path.join(output_folder, f"{label_name}_{i}.png")  # Evita sobrescrita
        image.crop(bbox).save(sub_image_path, "PNG")

        print(f"✅ Imagem da subárea '{label_name}' salva: {sub_image_path}")

        # 🔹 Converter a imagem em SVG
        svg_path = sub_image_path.replace(".png", ".svg")
        bmp_image_path = sub_image_path.replace(".png", ".bmp")

        with Image.open(sub_image_path) as img:
            img.save(bmp_image_path, "BMP")

        subprocess.run([potrace_path, bmp_image_path, "-s", "-o", svg_path], check=True)
        os.remove(bmp_image_path)

        print(f"✅ SVG salvo: {svg_path}")

        # 🔹 Adicionar dados ao JSON (garantindo que múltiplos da mesma categoria sejam salvos)
        if label_name not in data:
            data[label_name] = []

        data[label_name].append({
            "bbox": bbox,
            "svg_path": svg_path,
            "conf": float(conf)  # Adiciona confiança ao JSON para análise
        })

# 🔹 Salvar informações no JSON
with open(output_json_path, "w", encoding="utf-8") as json_file:
    json.dump(data, json_file, indent=4, ensure_ascii=False)

print(f"✅ JSON salvo: {output_json_path}")
