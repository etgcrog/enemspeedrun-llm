<?php

use yii\db\Migration;

/**
 * Class m240217_021425_create_area_competence
 */
class m240217_021425_create_area_competence extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enem_area_competence', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'name' => $this->tinyInteger()->notNull(),
            'description' => $this->string(3000)->notNull(),
            'enem_area_id' => 'string(2) not null',
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);

        $this->addForeignKey('enem_area_competence__enem_area_id', 'enem_area_competence', 'enem_area_id', 'enem_area', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_021425_create_area_competence cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_021425_create_area_competence cannot be reverted.\n";

        return false;
    }
    */
}
