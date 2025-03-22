import os
import json
import cv2
import pdfplumber
from pdf2image import convert_from_path

# 🔹 Configuração Global
pdf_path = r"C:\Users\etgcr\enemspeedrun-llm\raw\2022\exams\P2\dia2.pdf"
output_folder = "dataset"
images_folder = os.path.join(output_folder, "images")
labels_folder = os.path.join(output_folder, "labels")
output_json_path = os.path.join(output_folder, "classified_data.json")

start_page = 7  # Página inicial
num_pages = 57  # Número de páginas a classificar
dpi = 72  # 1 ponto = 1 pixel

# Criar diretórios de saída
os.makedirs(images_folder, exist_ok=True)
os.makedirs(labels_folder, exist_ok=True)

# Carregar o PDF para verificar o tamanho das páginas
with pdfplumber.open(pdf_path) as pdf:
    pdf_width, pdf_height = pdf.pages[0].width, pdf.pages[0].height
    print(f"📄 Tamanho da página no PDF: {pdf_width}x{pdf_height} pontos")

# Mapeamento de labels para classes YOLO
LABELS = {
    "enunciado": 0,
    "pergunta": 1,
    "alternativa_a": 2,
    "alternativa_b": 3,
    "alternativa_c": 4,
    "alternativa_d": 5,
    "alternativa_e": 6
}

# Lista para armazenar os dados classificados de todas as páginas
all_pages_data = {}

# 🔹 **Loop para processar múltiplas páginas**
for page_num in range(start_page, start_page + num_pages):
    print(f"\n🔹 Processando Página {page_num}...")

    # Converter a página do PDF para imagem
    images = convert_from_path(pdf_path, first_page=page_num, last_page=page_num, dpi=dpi)
    image = images[0]
    
    # Salvar a imagem da página
    image_filename = f"page_{page_num}.jpg"
    image_path = os.path.join(images_folder, image_filename)
    image.save(image_path, "JPEG")
    
    print(f"✅ Imagem da Página {page_num} salva como {image_path}")

    # Variáveis globais para armazenar as coordenadas e labels
    coordinates = []
    labels = list(LABELS.keys())  # Pegamos os labels na ordem definida acima
    current_label_index = 0
    labeled_blocks = []

    # Carregar a imagem para OpenCV
    image_cv = cv2.imread(image_path)
    image_copy = image_cv.copy()  # 📌 Trabalhar com uma cópia para atualizar os retângulos

    # 🚀 🔹 **Função para capturar eventos do mouse no OpenCV**
    def draw_rectangle(event, x, y, flags, param):
        global coordinates, current_label_index, image_copy

        if event == cv2.EVENT_LBUTTONDOWN:
            coordinates.append((x, y))
            print(f"Ponto inicial: ({x}, {y})")

        elif event == cv2.EVENT_LBUTTONUP:
            coordinates.append((x, y))
            print(f"Ponto final: ({x}, {y})")

            # 📌 **Desenhar retângulo na imagem cópia**
            cv2.rectangle(image_copy, coordinates[-2], coordinates[-1], (0, 255, 0), 2)
            cv2.putText(image_copy, labels[current_label_index], (coordinates[-2][0], coordinates[-2][1] - 10),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.9, (0, 255, 0), 2)
            
            # Exibir novamente a imagem com os retângulos desenhados
            cv2.imshow(f"Page {page_num}", image_copy)

            # Coordenadas normalizadas para YOLO (valores entre 0 e 1)
            x_min, y_min = coordinates[-2]
            x_max, y_max = coordinates[-1]
            image_width, image_height = image_cv.shape[1], image_cv.shape[0]

            x_center = ((x_min + x_max) / 2) / image_width
            y_center = ((y_min + y_max) / 2) / image_height
            width = (x_max - x_min) / image_width
            height = (y_max - y_min) / image_height

            # Salvar as coordenadas e o label
            labeled_blocks.append({
                "bbox": [x_min, y_min, x_max, y_max],
                "label": labels[current_label_index]
            })

            # Salvar formato YOLO no arquivo de labels
            label_filename = f"page_{page_num}.txt"
            label_path = os.path.join(labels_folder, label_filename)
            with open(label_path, "a") as f:
                f.write(f"{LABELS[labels[current_label_index]]} {x_center:.6f} {y_center:.6f} {width:.6f} {height:.6f}\n")

            print(f"✅ Label '{labels[current_label_index]}' salvo no formato YOLO.")

            # Avançar para o próximo label
            current_label_index += 1

            # Verificar se todos os labels foram usados
            if current_label_index >= len(labels):
                print("✅ Todos os labels foram utilizados. Pressione ESC para salvar e sair.")

    # Exibir a imagem e configurar callback do mouse
    cv2.imshow(f"Page {page_num}", image_copy)
    cv2.setMouseCallback(f"Page {page_num}", draw_rectangle)

    # Loop para interação do usuário no OpenCV
    while True:
        if current_label_index < len(labels):
            print(f"Desenhe o retângulo para: {labels[current_label_index]}")
        else:
            print("Pressione ESC para salvar e ir para a próxima página.")

        key = cv2.waitKey(1) & 0xFF
        if key == 27:  # Pressionar ESC para sair e ir para a próxima página
            break

    # Fechar a janela OpenCV para garantir que a próxima página carregue corretamente
    cv2.destroyAllWindows()

    # Armazenar os dados da página no JSON
    all_pages_data[f"page_{page_num}"] = labeled_blocks

    # Salvar dados classificados no JSON
    with open(output_json_path, "w", encoding="utf-8") as f:
        json.dump(all_pages_data, f, indent=4, ensure_ascii=False)

    print(f"✅ Dados da Página {page_num} salvos em {output_json_path}")

print("\n🎯 Classificação concluída para todas as páginas!")
