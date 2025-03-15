<?php

namespace app\models;

use yii\base\ErrorException;
use yii\base\Model;
use yii\db\conditions\AndCondition;
use yii\db\conditions\BetweenCondition;
use yii\db\conditions\OrCondition;
use yii\db\Expression;
use yii\db\Query;
use yii\validators\RangeValidator;

class SearchForm extends Model
{
    public $year = [];
    public $difficulty = [];
    public $area = [];
    public $skill = [];
    public $term = '';

    public function rules()
    {
        return [
            [['term'], 'trim'],
            [['term'], 'string'],
            [['area'], RangeValidator::class, 'range' => self::getAvailableAreas(), 'allowArray' => true],
            [['skill'], 'number', 'integerOnly' => true, 'allowArray' => true],
            [['difficulty'], RangeValidator::class, 'range' => self::getAvailableDifficulties(), 'allowArray' => true],
            [['year'], 'number', 'integerOnly' => true, 'min' => 2016, 'max' => 2040, 'allowArray' => true]
        ];
    }

    /**
     * Obtém objeto de busca.
     * @return \yii\db\Query
     */
    public function search(): Query
    {
        $query = EnemQuestion::find();
        $query->innerJoin('enem_area_competence_skill', 'enem_area_competence_skill.id = enem_question.enem_area_competence_skill_id');
        $query->innerJoin('enem_area_competence', 'enem_area_competence.id = enem_area_competence_skill.enem_area_competence_id');
        $query->innerJoin('enem_area', 'enem_area.id = enem_area_competence.enem_area_id');
        if (!empty($this->term) && $this->validate('term')) {
            $query->andWhere(['ilike', 'enem_question.statement', $this->term]);
        }
        if (!empty($this->area) && $this->validate('area')) {
            $query->andWhere(['in', 'enem_area.id', $this->area]);
        }
        if (!empty($this->skill) && $this->validate('skill')) {
            $query->andWhere(['in', 'enem_area_competence_skill.id', $this->skill]);
        }
        if (!empty($this->difficulty) && $this->validate('difficulty')) {
            $difficulty = $this->difficulty;
            sort($difficulty, SORT_DESC);
            $difficultyNumbers = array_map(function ($label) {
                if ($label === 'very-easy') {
                    return EnemQuestion::DIFFICULTY_VERY_EASY;
                } else if ($label === 'easy') {
                    return EnemQuestion::DIFFICULTY_EASY;
                } else if ($label === 'medium') {
                    return EnemQuestion::DIFFICULTY_MEDIUM;
                } else {
                    return EnemQuestion::DIFFICULTY_HARD;
                }
            }, $difficulty);
            sort($difficultyNumbers, SORT_DESC);

            if (count($difficultyNumbers) > 1) {
                $query->andWhere(
                    new OrCondition(array_map(function ($number, $i) use ($difficultyNumbers) {
                        $isLast = count($difficultyNumbers) - 1 === $i;

                        if (!$isLast) {
                            return new BetweenCondition('enem_question.difficulty', 'BETWEEN', $number, 10);
                        }
                        return new BetweenCondition('enem_question.difficulty', 'BETWEEN', $number, 10);
                    }, $difficultyNumbers))
                );
            } else {
                $query->andWhere(
                    new BetweenCondition('enem_question.difficulty', 'BETWEEN', 0, $difficultyNumbers[0])
                );
            }
        }

        return $query;
    }

    /**
     * Obtém anos disponíveis para consulta.
     * @return array
     */
    public static function getAvailableYears(): array
    {
        return EnemQuestion::find()->select(['year'])
            ->orderBy(['year' => SORT_DESC])
            ->distinct(true)
            ->asArray()
            ->column();
    }

    /**
     * Obtém dificuldade disponíveis em formato textual.
     * @return string[]
     */
    public static function getAvailableDifficulties(): array
    {
        return ['very-easy', 'easy', 'medium', 'hard'];
    }

    /**
     * Obtém label de dificuldade.
     * @param string $difficulty
     * @return string
     */
    public static function getAvailableDifficultyLabel(string $difficulty): string
    {
        $available = ['very-easy' => "Muito fácil", 'easy' => "Fácil", 'medium' => "Médio", 'hard' => "Difícil"];
        return $available[$difficulty];
    }

    /**
     * Obtém areas disponíveis.
     * @return array
     */
    public static function getAvailableAreas(): array
    {
        return EnemArea::find()->select(['name'])
            ->orderBy(['name' => SORT_DESC])
            ->distinct(true)
            ->asArray()
            ->column();
    }

    /**
     * Obtém skills disponíveis para área escolhida.
     * @param string $name
     * @return array
     */
    public static function getAvailableAreaSkills(string $name)
    {
        return EnemAreaCompetenceSkill::find()
            ->select(['code',
                'enem_area_competence_skill.id',
                'enem_area_competence_skill.name',
                'enem_area_competence_skill.description',
                'enem_area_competence.name as competence_name',
                'enem_area_competence.description as competence_description'
            ])
            ->innerJoin('enem_area_competence', 'enem_area_competence.id = enem_area_competence_skill.enem_area_competence_id')
            ->innerJoin('enem_area', 'enem_area.id = enem_area_competence.enem_area_id')
            ->andWhere(['=', 'enem_area.name', $name])
            ->orderBy(['code' => SORT_ASC])
            ->distinct(true)
            ->asArray()
            ->all();
    }
}