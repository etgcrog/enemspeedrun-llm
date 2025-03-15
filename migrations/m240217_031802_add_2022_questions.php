<?php

use app\models\EnemQuestion;
use yii\db\Migration;

/**
 * Class m240217_031802_add_2022_questions
 */
class m240217_031802_add_2022_questions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $competencies = json_decode(file_get_contents('C:\\Users\\etgcr\\enemspeedrun-llm\\raw\\2022\\question_levels.json'), true);
        $questions = json_decode(file_get_contents('C:\\Users\\etgcr\\enemspeedrun-llm\\raw\\2022\\questoes_enem_2022_ML.json'), true);

        $questions_map = [];
        foreach ($questions as $q) {
            $questions_map[$q['numero']] = $q;
        }

        foreach ($competencies as $question) {
            $numero = (string)$question[0]; // CO_POSICAO

            if (!isset($questions_map[$numero])) {
                continue;
            }

            $question_data = $questions_map[$numero];

            $existing = EnemQuestion::find()
                ->where(['position' => $question[0], 'year' => 2022])
                ->exists();

            if ($existing) {
                continue;
            }

            $alternatives_json = !empty($question_data['alternativas']) && is_array($question_data['alternativas'])
                ? json_encode($question_data['alternativas'], JSON_UNESCAPED_UNICODE)
                : null;

            $enemQuestion = new EnemQuestion();
            $enemQuestion->attributes = [
                'position' => $question[0],
                'title' => $question_data['titulo'],
                'statement' => $question_data['enunciado'],
                'question' => $question_data['pergunta'],
                'alternatives' => $alternatives_json,
                'answer' => $question[2],
                'bibliography' => $question_data['bibliografia'] ?? null,
                'images' => !empty($question_data['imagens']) ? json_encode($question_data['imagens']) : null,
                'difficulty' => $question[4],
                'exam_code' => $question[5],
                'year' => 2022,
                'language' => isset($question[6]) ? intval($question[6]) : null,
                'enem_area_competence_skill_id' => $question[3] ?? null,
            ];

            if (!$enemQuestion->save()) {
                throw new \yii\base\ErrorException("Erro ao inserir questão: " . json_encode($enemQuestion->errors));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_031802_add_2022_questions cannot be reverted.\n";
        return false;
    }
}