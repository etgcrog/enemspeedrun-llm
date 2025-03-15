<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enem_question_account_answer".
 *
 * @property int $id
 * @property string $answer
 * @property int $enem_question_id
 * @property int $account_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property Account $account
 * @property EnemQuestion $enemQuestion
 */
class EnemQuestionAccountAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enem_question_account_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer', 'enem_question_id', 'account_id'], 'required'],
            [['enem_question_id', 'account_id'], 'default', 'value' => null],
            [['enem_question_id', 'account_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['answer'], 'string', 'max' => 1],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['account_id' => 'id']],
            [['enem_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnemQuestion::class, 'targetAttribute' => ['enem_question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer' => 'Answer',
            'enem_question_id' => 'Enem Question ID',
            'account_id' => 'Account ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['id' => 'account_id']);
    }

    /**
     * Gets query for [[EnemQuestion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemQuestion()
    {
        return $this->hasOne(EnemQuestion::class, ['id' => 'enem_question_id']);
    }
}
