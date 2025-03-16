import cv2
import json

image_path = r"page_1.png"

# Variáveis globais para armazenar as coordenadas e labels
coordinates = []
labels = ["enunciado", "alternativa_a", "alternativa_b", "alternativa_c", "alternativa_d", "alternativa_e", "pergunta"]
current_label_index = 0

# Função para capturar eventos do mouse
def draw_rectangle(event, x, y, flags, param):
    global coordinates, current_label_index

    if event == cv2.EVENT_LBUTTONDOWN:
        # Iniciar um novo retângulo
        coordinates.append((x, y))
        print(f"Ponto inicial: ({x}, {y})")

    elif event == cv2.EVENT_LBUTTONUP:
        # Finalizar o retângulo
        coordinates.append((x, y))
        print(f"Ponto final: ({x}, {y})")

        # Desenhar o retângulo na imagem redimensionada
        cv2.rectangle(resized_image, coordinates[-2], coordinates[-1], (0, 255, 0), 2)
        cv2.putText(resized_image, labels[current_label_index], (coordinates[-2][0], coordinates[-2][1] - 10),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.9, (0, 255, 0), 2)
        cv2.imshow("Image", resized_image)

        # Salvar as coordenadas e o label
        labeled_blocks.append({
            "bbox": [coordinates[-2][0], coordinates[-2][1], coordinates[-1][0], coordinates[-1][1]],
            "label": labels[current_label_index]
        })

        # Avançar para o próximo label
        current_label_index += 1

        # Verificar se todos os labels foram usados
        if current_label_index >= len(labels):
            print("Todos os labels foram utilizados. Pressione ESC para salvar e sair.")

# Carregar a imagem
image = cv2.imread(image_path)

resized_image = cv2.resize(image, (842, 1190))

# Exibir a imagem redimensionada
cv2.imshow("Image", resized_image)

# Lista para armazenar os blocos rotulados
labeled_blocks = []

# Configurar a função de callback do mouse
cv2.setMouseCallback("Image", draw_rectangle)

# Loop principal
while True:
    # Exibir instruções
    if current_label_index < len(labels):
        print(f"Desenhe o retângulo para: {labels[current_label_index]}")
    else:
        print("Pressione ESC para salvar e sair.")

    # Esperar por uma tecla
    key = cv2.waitKey(1) & 0xFF

    # Verificar se a tecla ESC foi pressionada
    if key == 27:  # 27 é o código da tecla ESC
        break

# Salvar os dados rotulados em um arquivo JSON
with open("page_1_labeled_data.json", "w") as f:
    json.dump(labeled_blocks, f, indent=4)

print("✅ Dados rotulados salvos em page_1_labeled_data.json")

# Fechar a janela do OpenCV
cv2.destroyAllWindows()