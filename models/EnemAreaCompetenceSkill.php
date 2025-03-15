<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enem_area_competence_skill".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $code
 * @property int $enem_area_competence_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property EnemAreaCompetence $enemAreaCompetence
 * @property EnemQuestion[] $enemQuestions
 */
class EnemAreaCompetenceSkill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enem_area_competence_skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'code', 'enem_area_competence_id'], 'required'],
            [['code', 'enem_area_competence_id'], 'default', 'value' => null],
            [['code', 'enem_area_competence_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['name'], 'string', 'max' => 3],
            [['description'], 'string', 'max' => 3000],
            [['enem_area_competence_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnemAreaCompetence::class, 'targetAttribute' => ['enem_area_competence_id' => 'id']],
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
            'code' => 'Code',
            'enem_area_competence_id' => 'Enem Area Competence ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * Gets query for [[EnemAreaCompetence]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemAreaCompetence()
    {
        return $this->hasOne(EnemAreaCompetence::class, ['id' => 'enem_area_competence_id']);
    }

    /**
     * Gets query for [[EnemQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemQuestions()
    {
        return $this->hasMany(EnemQuestion::class, ['enem_area_competence_skill_id' => 'id']);
    }

    /**
     * Obtém informações completas da habilidade.
     * @param int $skillId
     * @return array
     */
    public static function getSkillInformation(int $skillId): array
    {
        $query = self::find()
            ->innerJoin('enem_area_competence', 'enem_area_competence.id = enem_area_competence_skill.enem_area_competence_id')
            ->innerJoin('enem_area', 'enem_area.id = enem_area_competence.enem_area_id')
            ->andWhere(['=', 'enem_area_competence_skill.id', $skillId])
            ->asArray();

        return [
            'skill' => $query->select('enem_area_competence_skill.*')->one(),
            'area' => $query->select('enem_area.*')->one(),
            'competence' => $query->select('enem_area_competence.*')->one()
        ];
    }
}
