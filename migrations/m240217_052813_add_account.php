<?php

use yii\db\Migration;

/**
 * Class m240217_052813_add_account
 */
class m240217_052813_add_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('account', [
            'id' => $this->bigPrimaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'google_auth_uid' => $this->string(1600)->unique()->defaultValue(null),
            'google_oauth_access_token' => $this->string(1600)->unique()->notNull(),
            'auth_key' => $this->string(60)->defaultValue(null),
            'email' => $this->string(250)->unique()->notNull(),
            'password' => $this->string(40)->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultValue('now()'),
            'updated_date' => $this->timestamp()->notNull()->defaultValue('now()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240217_052813_add_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_052813_add_account cannot be reverted.\n";

        return false;
    }
    */
}
