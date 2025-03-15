<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enem_area".
 *
 * @property string $id
 * @property string $name
 * @property string $created_date
 * @property string $updated_date
 *
 * @property EnemAreaCompetence[] $enemAreaCompetences
 */
class EnemArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enem_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * Gets query for [[EnemAreaCompetences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemAreaCompetences()
    {
        return $this->hasMany(EnemAreaCompetence::class, ['enem_area_id' => 'id']);
    }
}
