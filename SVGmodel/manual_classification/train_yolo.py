from ultralytics import YOLO

if __name__ == "__main__":
    model = YOLO("yolov8m.pt")

    model.train(
        data="dataset/data.yaml",
        epochs=100,
        imgsz=1190,
        batch=4,
        workers=0,
        device="cuda",
        
        hsv_h=0.05,   # Variação de matiz
        hsv_s=0.7,    # Variação de saturação
        hsv_v=0.4,    # Variação de brilho
        flipud=0.5,   # Inverte verticalmente
        fliplr=0.5,   # Inverte horizontalmente
        mosaic=1.0,   # Ativa Mosaic Augmentation
        mixup=0.2,    # Combina imagens aleatórias para criar novos exemplos
        scale=0.5,    # Permite variação de tamanho
        translate=0.1 # Adiciona deslocamento aleatório
    )


    print("✅ Treinamento concluído!")
