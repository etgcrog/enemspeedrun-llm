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
        $questions = array_slice(json_decode(file_get_contents(Yii::getAlias('@app') . '/raw/2022/question_levels.json'), true), 1);
        foreach ($questions as $question) {

            $enemQuestion = new EnemQuestion();
            $enemQuestion->attributes = [
                'position' => $question[0],
                'answer' => $question[2],
                'difficulty' => $question[4],
                'exam_code' => $question[5],
                'year' => 2022,
                'language' => ($question[6] === '1') ? 1 : (($question[6] === '0') ? 2 : null),
                'enem_area_competence_skill_id' => Yii::$app->db->createCommand(<<<SQL
                    SELECT DISTINCT enem_area_competence_skill.id
                    FROM 
                        enem_area_competence_skill
                        INNER JOIN enem_area_competence ON enem_area_competence.id = enem_area_competence_skill.enem_area_competence_id
                        INNER JOIN enem_area ON enem_area.id = enem_area_competence.enem_area_id
                    WHERE 
                        enem_area.id = :ENEM_AREA_ID AND                        
                        enem_area_competence_skill.code = :CODE
                    LIMIT 1;
                SQL
                )
                    ->bindValue(':ENEM_AREA_ID', $question[1], PDO::PARAM_STR)
                    ->bindValue(':CODE', $question[3], PDO::PARAM_INT)
                    ->queryScalar()
            ];
            if (!$enemQuestion->save()) {
                throw new \yii\base\ErrorException("Não foi possível adicionar a questão do enem, detalhes: " . json_encode($enemQuestion->getErrors(), JSON_PRETTY_PRINT));
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_031802_add_2022_questions cannot be reverted.\n";

        return false;
    }
    */
}
