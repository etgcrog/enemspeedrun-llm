<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "enem_question".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $statement
 * @property string|null $question
 * @property string|null $alternatives
 * @property int $position
 * @property int|null $enem_area_competence_skill_id
 * @property string $answer
 * @property float $difficulty
 * @property int $exam_code
 * @property int $year
 * @property int|null $language
 * @property string|null $bibliography
 * @property string|null $images
 * @property string $created_date
 * @property string $updated_date
 *
 * @property EnemAreaCompetenceSkill $enemAreaCompetenceSkill
 */
class EnemQuestion extends \yii\db\ActiveRecord
{
    const DIFFICULTY_HARD = 5;
    const DIFFICULTY_MEDIUM = 4;
    const DIFFICULTY_EASY = 2;
    const DIFFICULTY_VERY_EASY = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enem_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alternatives', 'bibliography', 'images'], 'string'],
            [['position', 'answer', 'difficulty', 'exam_code', 'year'], 'required'],
            [['position', 'enem_area_competence_skill_id', 'exam_code', 'year', 'language'], 'integer'],
            [['difficulty'], 'number'],
            [['created_date', 'updated_date'], 'safe'],
            [['title'], 'string', 'max' => 620],
            [['statement'], 'string', 'max' => 10000],
            [['question'], 'string', 'max' => 10000],
            [['answer'], 'string', 'max' => 1],
            [['enem_area_competence_skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnemAreaCompetenceSkill::class, 'targetAttribute' => ['enem_area_competence_skill_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'statement' => 'Statement',
            'question' => 'Question',
            'alternatives' => 'Alternatives',
            'position' => 'Position',
            'enem_area_competence_skill_id' => 'Enem Area Competence Skill ID',
            'answer' => 'Answer',
            'difficulty' => 'Difficulty',
            'exam_code' => 'Exam Code',
            'year' => 'Year',
            'language' => 'Language',
            'bibliography' => 'Bibliography',
            'images' => 'Images',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }

    /**
     * Gets query for [[EnemAreaCompetenceSkill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnemAreaCompetenceSkill()
    {
        return $this->hasOne(EnemAreaCompetenceSkill::class, ['id' => 'enem_area_competence_skill_id']);
    }

    /**
     * Obtém url do pdf.
     * @return string|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getPdfUrl(): ?string
    {
        $map = Yii::$app->cache->getOrSet('exam_pdf_map', function () {
            return json_decode(file_get_contents(Yii::getAlias('@app') . '/raw/map.json'), true);
        }, 3.156e+7);
        
        $key = (string)$this->exam_code;
        if (isset($map[$key])) {
            $path = Yii::getAlias("@app") . "/raw/{$map[$this->exam_code][0]}";
            if (file_exists($path)) {
                return Url::base(true) . '/' . Yii::$app->assetManager->publish($path)[1];
            }
        }
        return null;
    }

    /**
     * Obtém questão pelo id.
     * @param int $id
     * @return self
     * @throws \yii\web\NotFoundHttpException
     */
    public static function getEnemQuestionById($id): self
    {
        $question = self::find()->andWhere(['=', 'id', $id])->one();
        if (!$question instanceof self) {
            throw new NotFoundHttpException("Não foi possível encontrar esta questão.");
        }
        return $question;
    }
}
