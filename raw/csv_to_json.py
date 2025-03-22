import csv
import json

csv_file_path = r'C:\Users\etgcr\enemspeedrun-llm\raw\2022\ITENS_PROVA_2022.csv'
json_file_path = r'C:\Users\etgcr\enemspeedrun-llm\raw\2022\question_levels.json'

provas_desejadas = {'1179', '1175', '1187', '1183'}

result = [["CO_POSICAO","SG_AREA","TX_GABARITO","CO_HABILIDADE","NU_PARAM_B","CO_PROVA","TP_LINGUA"]]

with open(csv_file_path, encoding='latin1') as csv_file:
    csv_reader = csv.DictReader(csv_file, delimiter=';')

    for row in csv_reader:
        if row['CO_PROVA'] in provas_desejadas and (row['TP_LINGUA'] == '0' or row['TP_LINGUA'] == ''):
            filtered_row = [
                int(row['CO_POSICAO']),
                row['SG_AREA'],
                row['TX_GABARITO'],
                int(row['CO_HABILIDADE']) if row['CO_HABILIDADE'] else None,
                float(row['NU_PARAM_B']) if row['NU_PARAM_B'] else None,
                int(row['CO_PROVA']),
                row['TP_LINGUA'] if row['TP_LINGUA'] else ""
            ]
            result.append(filtered_row)

with open(json_file_path, 'w', encoding='utf-8') as json_file:
    json.dump(result, json_file, ensure_ascii=False, separators=(',', ':'))

print(f'JSON gerado com sucesso em {json_file_path}')
