<?php

use yii\db\Migration;

/**
 * Class m240217_015937_createarea
 */
class m240217_015937_create_area extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enem_area', [
            'id' => 'string(2) unique primary key',
            'name' => $this->string(100)->unique()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);

        $this->insert('enem_area', [
            'id' => 'CN',
            'name' => 'Ciências da Natureza'
        ]);

        $this->insert('enem_area', [
            'id' => 'CH',
            'name' => 'Ciências Humanas'
        ]);

        $this->insert('enem_area', [
            'id' => 'LC',
            'name' => 'Linguagens e Códigos'
        ]);

        $this->insert('enem_area', [
            'id' => 'MT',
            'name' => 'Matemática e suas Tecnologias'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_015937_createarea cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_015937_createarea cannot be reverted.\n";

        return false;
    }
    */
}
