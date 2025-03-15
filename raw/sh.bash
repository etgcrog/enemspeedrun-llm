#!/bin/bash

# Define o diretório base onde os arquivos descompactados serão salvos
diretorio_base="/home/edudev/Documents/enemspeedrun/raw"

# Links de download
declare -A YEARS=(
  [2022]="https://download.inep.gov.br/microdados/microdados_enem_2022.zip"
  [2021]="https://download.inep.gov.br/microdados/microdados_enem_2021.zip"
  [2020]="https://download.inep.gov.br/microdados/microdados_enem_2020.zip"
  [2019]="https://download.inep.gov.br/microdados/microdados_enem_2019.zip"
  [2018]="https://download.inep.gov.br/microdados/microdados_enem_2018.zip"
  [2017]="https://download.inep.gov.br/microdados/microdados_enem_2017.zip"
)

# Loop pelos anos e links
for ano in "${!YEARS[@]}"; do
  link="${YEARS[$ano]}"
  echo "Baixando dados do ENEM $ano..."
  
  # Define o diretório destino para o ano atual
  diretorio_destino="$diretorio_base/$ano"
  mkdir -p "$diretorio_destino"
  
  # Baixa o arquivo zip
  wget -P "/home/edudev/" "$link" --no-check-certificate
  
  # Descompacta o arquivo no diretório de destino
  echo "Descompactando arquivo para $diretorio_destino..."
  unzip -o "/home/edudev/microdados_enem_$ano.zip" -d "$diretorio_destino"
  
  echo "Arquivos do ENEM $ano processados."
done

echo "Todos os downloads e extrações foram completados."
