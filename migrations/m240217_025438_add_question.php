<?php

use yii\db\Migration;

/**
 * Class m240217_025438_add_question
 */
class m240217_025438_add_question extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enem_question', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'title' => $this->string(620)->defaultValue(null),
            'question' => $this->string(10000)->defaultValue(null),
            'alternatives' => 'TEXT[] default null',
            'position' => $this->tinyInteger()->notNull(),
            'enem_area_competence_skill_id' => $this->bigInteger()->notNull(),
            'answer' => $this->string(1)->notNull(),
            'difficulty' => $this->float()->notNull(),
            'exam_code' => $this->integer()->notNull(),
            'year' => $this->tinyInteger()->notNull(),
            'language' => $this->tinyInteger()->defaultValue(null),
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);

        $this->addForeignKey('enem_question__enem_area_competence_skill_id', 'enem_question', 'enem_area_competence_skill_id', 'enem_area_competence_skill', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_025438_add_question cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_025438_add_question cannot be reverted.\n";

        return false;
    }
    */
}
