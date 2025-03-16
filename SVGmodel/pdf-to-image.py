import pdfplumber
from pdf2image import convert_from_path

# Caminho do PDF
pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"
page_number = 24  # Página a ser convertida

# 🔹 1️⃣ Obter tamanho exato da página em pontos usando pdfplumber
with pdfplumber.open(pdf_path) as pdf:
    pdf_page = pdf.pages[page_number - 1]
    pdf_width, pdf_height = pdf_page.width, pdf_page.height
    print(f"📄 Tamanho da página no PDF (pontos): {pdf_width}x{pdf_height}")

# 🔹 2️⃣ Converter PDF para imagem garantindo que cada ponto seja um pixel (dpi ajustado)
dpi = 72  # Definir DPI para garantir 1 ponto = 1 pixel
images = convert_from_path(pdf_path, first_page=page_number, last_page=page_number, dpi=dpi)

# Salvar a imagem gerada
image = images[0]
image_path = "page_1.png"
image.save(image_path, "PNG")

# 🔹 3️⃣ Verificar o tamanho real da imagem gerada
image_width, image_height = image.size
print(f"✅ Imagem gerada com tamanho: {image_width}x{image_height} pixels")
