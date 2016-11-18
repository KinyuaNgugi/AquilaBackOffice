<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level_one".
 *
 * @property integer $id
 * @property integer $level_up_id
 * @property string $name
 */
class LevelOne extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level_one';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_up_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_up_id' => 'Level Up ID',
            'name' => 'Name',
        ];
    }
}
