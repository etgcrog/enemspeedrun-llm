<?php

use yii\db\Migration;

/**
 * Class m240217_024923_create_area_skill
 */
class m240217_024923_create_area_skill extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enem_area_competence_skill', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->string('3')->notNull(),
            'description' => $this->string(3000)->notNull(),
            'code' => $this->tinyInteger()->notNull(),
            'enem_area_competence_id' => $this->bigInteger()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);
        $this->addForeignKey('enem_area_competence_skill__enem_area_competence_id', 'enem_area_competence_skill', 'enem_area_competence_id', 'enem_area_competence', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_024923_create_area_skill cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_024923_create_area_skill cannot be reverted.\n";

        return false;
    }
    */
}
