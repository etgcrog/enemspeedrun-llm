from diagrams import Cluster, Diagram
from diagrams.gcp.security import Iam as Users
from diagrams.aws.ml import Comprehend, Rekognition, SagemakerTrainingJob
from diagrams.onprem.ci import GithubActions as MLflow
from diagrams.gcp.security import IAP
from diagrams.onprem.compute import Server
from diagrams.onprem.container import Docker
from diagrams.aws.database import RDSPostgresqlInstance, ElasticacheForRedis
from diagrams.programming.language import PHP, Python

graph_attr = {
    "label": "\n\nArquitetura do Sistema de Estudo ENEM",  # Título um pouco mais abaixo
    "labelloc": "t",
    "labeljust": "c",
    "fontsize": "22",
    "pad": "0.6",             # Borda mais fina
    "splines": "spline",
    "nodesep": "0.9",         # Mais colado horizontalmente
    "ranksep": "0.7",         # Mais achatado verticalmente
    "dpi": "600",             # Alta definição
    "bgcolor": "white",
    "fontname": "Helvetica",
    "size": "12,6"            # Altura reduzida
}

with Diagram("", show=False, direction="TB", graph_attr=graph_attr, outformat="png", filename="arquitetura_enem"):
    user = Users("Usuário")

    with Cluster("Frontend (Yii2 - PHP)"):
        views = PHP("Views")
        widgets = PHP("Widgets")
        assets = PHP("Assets")

    with Cluster("Backend (Yii2 - PHP)"):
        controllers = PHP("Controllers")
        models = PHP("Models")
        mail = PHP("Mail")
        config = PHP("Config")
        migration = PHP("Migration Controller")

    with Cluster("Autenticação"):
        auth_google = IAP("Google OAuth 2.0")

    with Cluster("Machine Learning", graph_attr={"margin": "0.1,0.1"}):
        with Cluster("ML Pipeline", direction="LR"):
            manual_labels = Python("OpenCV + Dataset")
            bert_model = Comprehend("BERT - NLP")
            yolo_train = SagemakerTrainingJob("YOLOv8 Train")
            yolo_detect = Rekognition("YOLOv8 Inferência")
        mlflow = MLflow("MLflow Tracking")

    with Cluster("Infraestrutura (Docker + Nginx + DBs)"):
        nginx = Server("Nginx")
        provision = Docker("Vagrant")
        db = RDSPostgresqlInstance("PostgreSQL")
        cache = ElasticacheForRedis("Redis")

    # Conexões principais
    user >> views
    user >> auth_google >> controllers

    views >> controllers
    widgets >> controllers
    assets >> controllers

    controllers >> cache
    controllers >> nginx >> provision

    # Machine Learning Flow
    manual_labels >> bert_model
    manual_labels >> yolo_train >> yolo_detect

    [bert_model, yolo_detect] >> mlflow
    mlflow >> migration >> db
