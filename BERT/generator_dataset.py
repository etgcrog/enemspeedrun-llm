import random

# 📚 Listas de nomes e fontes para gerar bibliografias realistas
autores = [
    "SILVA, J.", "COSTA, M.", "MELO, R.", "ALMEIDA, A.", "SOUSA, T.", "LIMA, C.",
    "CARVALHO, P.", "PEREIRA, L.", "RODRIGUES, V.", "BARBOSA, E.", "NASCIMENTO, F.", "FONSECA, G."
]

titulos = [
    "A evolução das sociedades", "O impacto da tecnologia", "Modernidade e tradição",
    "Pensadores contemporâneos", "História e cultura", "O futuro das nações",
    "Educação e pandemia", "Redes sociais e comportamento", "Filosofia e ciência",
    "A influência da mídia", "Sustentabilidade e meio ambiente", "Ciência e inovação"
]

editoras = [
    "Editora Moderna", "Companhia das Letras", "Record", "Atlas", "Campus",
    "L&PM", "Objetiva", "Rocco", "Senac", "Paz e Terra", "Multifoco", "Cosac & Naify"
]

anos = [str(ano) for ano in range(1980, 2024)]

revistas = [
    "Revista Brasileira de Educação", "Cadernos de Pesquisa", "Estudos Históricos",
    "Revista Ciência e Cultura", "Minas faz Ciências", "Diversitas",
    "Varia Historia", "Saúde e Sociedade", "Pesquisa & Debate",
    "Revista de Ciências Sociais", "Jornal da Universidade", "História e Memória"
]

sites = [
    "https://www.bbc.com", "https://brasil.elpais.com", "https://oglobo.globo.com",
    "https://www.cnnbrasil.com.br", "https://agenciabrasil.ebc.com.br",
    "https://revistaencontro.com.br", "https://www.nexojornal.com.br",
    "https://tab.uol.com.br", "https://www.uol.com.br", "https://www.gov.br",
    "https://pt.wikipedia.org", "https://www.noticias.uol.com.br"
]

datas_acesso = [f"{random.randint(1, 30)} {mes} {random.randint(1900, 2023)}"
                for mes in ["jan.", "fev.", "mar.", "abr.", "mai.", "jun.",
                            "jul.", "ago.", "set.", "out.", "nov.", "dez."]]

# 📂 Gerar bibliografias e textos normais
bibliografias = []
textos_normais = []

for _ in range(2500):  # Gerar 100000 bibliografias
    tipo = random.choice(["livro", "artigo", "site"])

    if tipo == "livro":
        autor = random.choice(autores)
        titulo = random.choice(titulos)
        editora = random.choice(editoras)
        ano = random.choice(anos)
        biblio = f"{autor} {titulo}. {editora}, {ano}."
    
    elif tipo == "artigo":
        autor = random.choice(autores)
        revista = random.choice(revistas)
        ano = random.choice(anos)
        biblio = f"{autor} {revista}, n. {random.randint(1, 99)}, {ano} (adaptado)."
    
    else:  # tipo == "site"
        site = random.choice(sites)
        data = random.choice(datas_acesso)
        biblio = f"Disponível em: {site}. Acesso em: {data}."

    bibliografias.append(f'"{biblio}";"bibliografia"')

# Gerar textos normais (não bibliografias)
textos_exemplos = [
    "A economia global tem enfrentado desafios significativos nos últimos anos.",
    "A história do Brasil é marcada por diversos períodos de transformação.",
    "As novas tecnologias impactam a forma como interagimos no dia a dia.",
    "A preservação do meio ambiente é fundamental para as futuras gerações.",
    "O avanço da inteligência artificial levanta questões éticas importantes.",
    "Os esportes desempenham um papel essencial na vida de muitas pessoas.",
    "A literatura clássica ainda influencia escritores contemporâneos.",
    "O sistema educacional precisa de reformas para atender às novas demandas.",
    "A pandemia trouxe desafios inesperados para a saúde pública mundial.",
    "A revolução digital mudou a maneira como consumimos informação.",
    "Os hábitos de leitura variam de acordo com a cultura de cada país.",
    "A filosofia busca respostas para questões fundamentais da existência humana.",
    "O desenvolvimento urbano deve levar em conta a sustentabilidade.",
    "A ciência tem evoluído rapidamente, trazendo novas descobertas.",
    "A globalização aproximou culturas, mas também gerou desafios sociais."
]

for _ in range(2500):  # Gerar 2500 textos normais
    texto_normal = random.choice(textos_exemplos)
    textos_normais.append(f'"{texto_normal}";"nao_bibliografia"')

# 📂 Salvar no arquivo
dataset_completo = bibliografias + textos_normais
random.shuffle(dataset_completo)  # Embaralhar os dados para balanceamento

dataset_path = "dataset_bibliografia.csv"
with open(dataset_path, "w", encoding="utf-8") as f:
    f.write("\n".join(dataset_completo))