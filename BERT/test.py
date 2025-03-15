from transformers import BertTokenizer, BertForSequenceClassification
import torch

# Carregar modelo treinado
model_path = "modelo_enem"
tokenizer = BertTokenizer.from_pretrained(model_path)

device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
print(device)

model = BertForSequenceClassification.from_pretrained(model_path).to(device)

def classify_text(text):
    """Classifica um texto como pergunta ou bibliografia"""
    inputs = tokenizer(text, return_tensors="pt", truncation=True, padding=True, max_length=128).to(device)
    outputs = model(**inputs)
    logits = outputs.logits
    predicted_class = torch.argmax(logits, dim=1).item()
    
    labels_map = {0: "pergunta", 1: "bibliografia"}
    return labels_map[predicted_class]

# Teste com novas perguntas
test_text = "Qual foi a influência do Iluminismo na Revolução Francesa?"
print(f"Classificação: {classify_text(test_text)}")

test_text = "ARENDT, H. A condição humana. Rio de Janeiro: Forense Universitária, 2004"
print(f"Classificação: {classify_text(test_text)}")

