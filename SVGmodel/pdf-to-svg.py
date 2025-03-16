import os
import subprocess
import json
from pdf2image import convert_from_path
from PIL import Image
import pdfplumber

# Caminho do Potrace
potrace_path = r"potrace.exe"

# Configuração global
dpi = 72  # Mantendo 1 ponto = 1 pixel
output_folder = "subareas_extraidas"
output_json_path = "subareas_convertidas.json"
input_json_path = "page_1_labeled_data.json"  # 📌 Arquivo JSON com as coordenadas anotadas

# Criar pasta de saída, se não existir
if not os.path.exists(output_folder):
    os.makedirs(output_folder)

# Caminho do PDF e página específica
pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"
page_number = 24  # Página a converter

# 🔹 1️⃣ Obter tamanho exato da página no PDF (em pontos)
with pdfplumber.open(pdf_path) as pdf:
    pdf_page = pdf.pages[page_number - 1]
    pdf_width, pdf_height = pdf_page.width, pdf_page.height
    print(f"📄 Tamanho da página no PDF: {pdf_width}x{pdf_height} pontos")

# 🔹 2️⃣ Converter PDF para imagem (1 ponto = 1 pixel)
images = convert_from_path(pdf_path, first_page=page_number, last_page=page_number, dpi=dpi)
image = images[0]
image_path = os.path.join(output_folder, "page_1.png")
image.save(image_path, "PNG")

# 🔹 3️⃣ Verificar tamanho da imagem gerada
image_width, image_height = image.size
print(f"✅ Imagem gerada com tamanho: {image_width}x{image_height} pixels")

# 🚀 Agora `pdf_width == image_width` e `pdf_height == image_height`, então NÃO precisamos de fator de escala.

def extract_subarea_as_image(image, output_folder, area_name, bbox):
    """
    Recorta uma subárea específica da imagem e a salva como PNG.
    """
    cropped_image = image.crop(bbox)
    output_image_path = os.path.join(output_folder, f"{area_name}.png")
    cropped_image.save(output_image_path, "PNG")
    print(f"✅ Imagem da subárea '{area_name}' salva: {output_image_path}")
    return output_image_path

def convert_image_to_svg(image_path, output_svg_path):
    """
    Converte uma imagem PNG ou BMP em SVG usando Potrace.
    """
    bmp_image_path = image_path.replace(".png", ".bmp")
    with Image.open(image_path) as img:
        img.save(bmp_image_path, "BMP")

    subprocess.run([potrace_path, bmp_image_path, "-s", "-o", output_svg_path], check=True)
    os.remove(bmp_image_path)

    print(f"✅ SVG salvo: {output_svg_path}")
    return output_svg_path

def extract_text_from_area(pdf_path, page_number, bbox):
    """
    Extrai texto de uma subárea do PDF.
    """
    with pdfplumber.open(pdf_path) as pdf:
        page = pdf.pages[page_number - 1]
        text = page.within_bbox(bbox).extract_text()
    return text

# 🔹 4️⃣ 📌 **Carregar coordenadas do JSON**
with open(input_json_path, "r", encoding="utf-8") as json_file:
    areas_pdf = json.load(json_file)

# Processar cada subárea
data = {}
for area in areas_pdf:
    pdf_bbox = area["bbox"]
    label = area["label"]

    # NÃO precisamos converter, pois já garantimos que 1 ponto = 1 pixel!
    image_bbox = pdf_bbox  

    # Extrair a subárea da imagem
    image_path = extract_subarea_as_image(image, output_folder, label, image_bbox)

    # Converter a imagem em SVG
    svg_path = image_path.replace(".png", ".svg")
    convert_image_to_svg(image_path, svg_path)

    # Extrair texto diretamente do PDF
    text = extract_text_from_area(pdf_path, page_number, pdf_bbox)

    # Adicionar dados ao JSON
    data[label] = {
        "text": text,
        "svg_path": svg_path
    }

def save_to_json(output_json_path, data):
    """
    Salva os dados em um arquivo JSON.
    """
    with open(output_json_path, "w", encoding="utf-8") as json_file:
        json.dump(data, json_file, indent=4, ensure_ascii=False)

    print(f"✅ JSON salvo: {output_json_path}")

# Salvar informações no JSON
save_to_json(output_json_path, data)
