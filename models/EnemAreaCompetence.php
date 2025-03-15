<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enem_area_competence".
 *
 * @property int $id
 * @property int $name
 * @property string $description
 * @property string $enem_area_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property EnemArea $enemArea
 * @property EnemAreaCompetenceSkill[] $enemAreaCompetenceSkills
 */
class EnemAreaCompetence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enem_area_competence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'enem_area_id'], 'required'],
            [['name'], 'default', 'value' => null],
            [['name'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['description'], 'string', 'max' => 3000],
            [['enem_area_id'], 'string', 'max' => 2],
            [['enem_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnemArea::class, 'targetAttribute' => ['enem_area_id' => 'id']],
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
            'description' => 'Description',
            'enem_area_id' => 'Enem Area ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * Gets query for [[EnemArea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemArea()
    {
        return $this->hasOne(EnemArea::class, ['id' => 'enem_area_id']);
    }

    /**
     * Gets query for [[EnemAreaCompetenceSkills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemAreaCompetenceSkills()
    {
        return $this->hasMany(EnemAreaCompetenceSkill::class, ['enem_area_competence_id' => 'id']);
    }
}
