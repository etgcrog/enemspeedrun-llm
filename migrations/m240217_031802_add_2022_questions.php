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
        // Correção aqui, usando text() para LONGTEXT
        $this->alterColumn('{{%enem_question}}', 'statement', $this->text());
        $this->alterColumn('{{%enem_question}}', 'question', $this->text());
        $this->alterColumn('{{%enem_question}}', 'alternatives', $this->text());

        $competencies = json_decode(file_get_contents('C:\\Users\\etgcr\\enemspeedrun-llm\\raw\\2022\\question_levels.json'), true);
        $questionsHumanas = json_decode(file_get_contents('C:\\Users\\etgcr\\enemspeedrun-llm\\raw\\2022\\questoes_enem_2022_humanas.json'), true);
        $questionsExatas = json_decode(file_get_contents('C:\\Users\\etgcr\\enemspeedrun-llm\\raw\\2022\\questoes_enem_2022_exatas.json'), true);

        $questions = array_merge($questionsHumanas, $questionsExatas);

        $questions_map = [];
        foreach ($questions as $q) {
            $questions_map[str_pad((string) intval($q['numero']), 3, '0', STR_PAD_LEFT)] = $q;
        }

        foreach ($competencies as $question) {
            $numero = str_pad((string) intval($question[0]), 3, '0', STR_PAD_LEFT);

            if (!isset($questions_map[$numero])) {
                continue;
            }

            $question_data = $questions_map[$numero];

            // Evita duplicação
            $existing = EnemQuestion::find()
                ->where(['position' => $question[0], 'year' => 2022])
                ->exists();

            if ($existing) {
                continue;
            }

            $alternatives_json = !empty($question_data['alternativas']) ? json_encode($question_data['alternativas'], JSON_UNESCAPED_UNICODE) : json_encode([]);

            $enemQuestion = new EnemQuestion();
            $enemQuestion->attributes = [
                'position' => $question[0],
                'title' => $question_data['titulo'] ?? 'Sem título',
                'statement' => $question_data['enunciado'] ?? 'Sem enunciado',
                'question' => $question_data['pergunta'] ?? 'Sem pergunta',
                'alternatives' => $alternatives_json,
                'answer' => $question[2],
                'bibliography' => $question_data['bibliografia'] ?? '',
                'images' => !empty($question_data['imagens']) ? json_encode($question_data['imagens']) : json_encode([]),
                'difficulty' => isset($question[4]) && is_numeric($question[4]) ? floatval($question[4]) : 0.0,
                'exam_code' => $question[5] ?? 0,
                'year' => 2022,
                'language' => isset($question[6]) && $question[6] !== "" ? intval($question[6]) : null,
                'enem_area_competence_skill_id' => $question[3] ?? null,
            ];

            if (!$enemQuestion->save()) {
                throw new \yii\base\ErrorException("Erro ao inserir questão: " . json_encode($enemQuestion->errors, JSON_PRETTY_PRINT));
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
