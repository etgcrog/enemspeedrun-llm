<?php

use yii\db\Migration;

/**
 * Class m240220_202836_add_account_answers
 */
class m240220_202836_add_account_answers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enem_question_account_answer', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'answer' => $this->string(1)->notNull(),
            'enem_question_id' => $this->bigInteger()->notNull(),
            'account_id' => $this->bigInteger()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);

        $this->addForeignKey('enem_question_account_answer__enem_question_id', 'enem_question_account_answer', 'enem_question_id', 'enem_question', 'id', 'cascade', 'cascade');
        $this->addForeignKey('enem_question_account_answer__account_id', 'enem_question_account_answer', 'account_id', 'account', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240220_202836_add_account_answers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240220_202836_add_account_answers cannot be reverted.\n";

        return false;
    }
    */
}
