import pdfplumber

pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"
page_number = 24

# Verificar tamanho da página no PDFPlumber
with pdfplumber.open(pdf_path) as pdf:
    pdf_page = pdf.pages[page_number - 1]
    pdf_width = pdf_page.width
    pdf_height = pdf_page.height

print(f"📄 Tamanho da página no PDFPlumber: {pdf_width}x{pdf_height} pontos")
