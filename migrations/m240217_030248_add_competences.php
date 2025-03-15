<?php

use yii\db\Migration;

/**
 * Class m240217_030248_add_2022_questions
 */
class m240217_030248_add_competences extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $competences = json_decode(file_get_contents(Yii::getAlias('@app') . '/raw/competences.json'), true);
        foreach ($competences['LC']['areas'] as $i => $area) {
            $areaName = $i + 1;
            $this->insert('enem_area_competence', [
                'name' => $areaName,
                'description' => trim(preg_replace('/Competência de área \d+ -/', '', $area['description'])),
                'enem_area_id' => 'LC'
            ]);
            foreach ($area['skills'] as $skill) {
                $this->insert('enem_area_competence_skill', [
                    'name' => $skill['name'],
                    'description' => $skill['description'],
                    'code' => intval(str_replace('H', '', $skill['name'])),
                    'enem_area_competence_id' => Yii::$app->db->createCommand(<<<SQL
                        SELECT DISTINCT enem_area_competence.id
                        FROM enem_area_competence
                        WHERE 1=1
                        ORDER BY enem_area_competence.id DESC
                        LIMIT 1
                    SQL
                    )->queryScalar()
                ]);
            }
        }

        foreach ($competences['MT']['areas'] as $i => $area) {
            $areaName = $i + 1;
            $this->insert('enem_area_competence', [
                'name' => $areaName,
                'description' => $area['description'],
                'enem_area_id' => 'MT'
            ]);
            foreach ($area['skills'] as $j => $skill) {
                $this->insert('enem_area_competence_skill', [
                    'name' => $skill['name'],
                    'description' => $skill['description'],
                    'code' => intval(str_replace('H', '', $skill['name'])),
                    'enem_area_competence_id' => Yii::$app->db->createCommand(<<<SQL
                        SELECT DISTINCT enem_area_competence.id
                        FROM enem_area_competence
                        WHERE 1=1
                        ORDER BY enem_area_competence.id DESC
                        LIMIT 1
                    SQL
                    )->queryScalar()
                ]);
            }
        }

        foreach ($competences['CN']['areas'] as $i => $area) {
            $areaName = $i + 1;
            $this->insert('enem_area_competence', [
                'name' => $areaName,
                'description' => $area['description'],
                'enem_area_id' => 'CN'
            ]);
            foreach ($area['skills'] as $j => $skill) {
                $this->insert('enem_area_competence_skill', [
                    'name' => $skill['name'],
                    'description' => $skill['description'],
                    'code' => intval(str_replace('H', '', $skill['name'])),
                    'enem_area_competence_id' => Yii::$app->db->createCommand(<<<SQL
                        SELECT DISTINCT enem_area_competence.id
                        FROM enem_area_competence
                        WHERE 1=1
                        ORDER BY enem_area_competence.id DESC
                        LIMIT 1
                    SQL
                    )->queryScalar()
                ]);
            }
        }

        foreach ($competences['CH']['areas'] as $i => $area) {
            $areaName = $i + 1;
            $this->insert('enem_area_competence', [
                'name' => $areaName,
                'description' => $area['description'],
                'enem_area_id' => 'CH'
            ]);
            foreach ($area['skills'] as $j => $skill) {
                $this->insert('enem_area_competence_skill', [
                    'name' => $skill['name'],
                    'description' => $skill['description'],
                    'code' => intval(str_replace('H', '', $skill['name'])),
                    'enem_area_competence_id' => Yii::$app->db->createCommand(<<<SQL
                        SELECT DISTINCT enem_area_competence.id
                        FROM enem_area_competence
                        WHERE 1=1
                        ORDER BY enem_area_competence.id DESC
                        LIMIT 1
                    SQL
                    )->queryScalar()
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_030248_add_2022_questions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_030248_add_2022_questions cannot be reverted.\n";

        return false;
    }
    */
}
