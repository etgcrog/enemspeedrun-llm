from ultralytics import YOLO
import torch

# 🔄 Libera a memória da GPU antes do treino
torch.cuda.empty_cache()

if __name__ == "__main__":
    # 🔸 Começa com modelo médio (equilíbrio entre tempo e qualidade)
    model = YOLO("yolov8m.pt")  # Pode testar também yolov8l.pt se a GPU permitir

    model.train(
        data="dataset/data.yaml",
        epochs=300,
        patience=20,           # ⏱️ Early stopping: para se não melhorar após 20 épocas
        imgsz=832,             # Equilíbrio entre resolução e memória
        batch=4,               # Ajustável conforme a capacidade da GPU
        workers=0,
        device="cuda",

        # 🎯 Ajuste fino das perdas (foco em localização e classes difíceis)
        box=7.0,
        cls=3.0,
        dfl=1.5,

        # 🧠 Data Augmentation inteligente
        hsv_h=0.03,
        hsv_s=0.5,
        hsv_v=0.4,
        flipud=0.1,
        fliplr=0.3,
        mosaic=0.7,
        mixup=0.1,             # Pouco mixup para variedade sem ruído
        scale=0.3,
        translate=0.05,

        # 🚀 Otimizadores e agendamento de LR
        lr0=0.002,             # LR menor para mais estabilidade
        lrf=0.01,
        cos_lr=True,
        warmup_epochs=5,       # Evita picos de perda no início

        # ⚡ GPU otimização
        half=True,

        # 📊 Avaliação detalhada
        val=True,
        save_json=True
    )

    print("✅ Treinamento concluído!")
