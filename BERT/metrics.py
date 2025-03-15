import json
import os
import matplotlib.pyplot as plt

# Encontrar o último checkpoint salvo dentro da pasta `results/`
results_path = r"modelo_bibliografia"
checkpoints = [d for d in os.listdir(results_path) if d.startswith("checkpoint-")]
checkpoints.sort(key=lambda x: int(x.split("-")[-1]))  # Ordena do menor para o maior

# Carregar métricas do último checkpoint
if checkpoints:
    last_checkpoint = os.path.join(results_path, checkpoints[-1], "trainer_state.json")
    print(f"📌 Usando métricas do checkpoint: {last_checkpoint}")
    
    with open(last_checkpoint, "r") as f:
        logs = json.load(f)

    # Pegar métricas registradas
    train_loss = [entry["loss"] for entry in logs["log_history"] if "loss" in entry]
    eval_loss = [entry["eval_loss"] for entry in logs["log_history"] if "eval_loss" in entry]

    # 🔹 Garantir que os tamanhos sejam iguais
    min_len = min(len(train_loss), len(eval_loss))  # Encontra o menor tamanho disponível
    train_loss = train_loss[:min_len]
    eval_loss = eval_loss[:min_len]
    epochs = range(1, min_len + 1)  # Criar lista de épocas com o tamanho correto

    # Plotar gráfico de loss
    plt.figure(figsize=(10,5))
    plt.plot(epochs, train_loss, label="Train Loss", marker="o")
    plt.plot(epochs, eval_loss, label="Eval Loss", marker="s")
    plt.xlabel("Época")
    plt.ylabel("Loss")
    plt.title("Evolução da Loss no Treinamento")
    plt.legend()
    plt.grid(True)
    plt.show()
else:
    print("❌ Nenhum checkpoint encontrado dentro de `results/`.")
