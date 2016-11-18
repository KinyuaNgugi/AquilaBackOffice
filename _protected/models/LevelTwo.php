<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level_two".
 *
 * @property integer $id
 * @property integer $level_up_id
 * @property string $level_name
 */
class LevelTwo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level_two';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_up_id'], 'integer'],
            [['level_name'], 'string', 'max' => 30],
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
            'level_name' => 'Level Name',
        ];
    }
}
