<?php

use yii\db\Migration;

/**
 * Class m240220_211520_add_question_comments
 */
class m240220_211520_add_question_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enem_question_comment', [
            'id' => $this->bigPrimaryKey()->notNull(),
            'text' => $this->string(5000)->notNull(),
            'enem_question_id' => $this->bigInteger()->notNull(),
            'account_id' => $this->bigInteger()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);

        $this->addForeignKey('enem_question_comment__account_id', 'enem_question_comment', 'account_id', 'account', 'id', 'cascade', 'cascade');
        $this->addForeignKey('enem_question_comment__enem_question_id', 'enem_question_comment', 'enem_question_id', 'enem_question', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240220_211520_add_question_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240220_211520_add_question_comments cannot be reverted.\n";

        return false;
    }
    */
}
