<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "org_chart".
 *
 * @property integer $id
 * @property integer $org_id
 * @property integer $number
 * @property integer $main_acc_id
 * @property integer $level_one_id
 * @property integer $level_two_id
 * @property string $level_three
 * @property string $currency
 * @property string $type
 */
class OrgChart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_chart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'number', 'main_acc_id', 'level_one_id', 'level_two_id'], 'integer'],
            [['level_three'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 5],
            [['type'], 'string', 'max' => 1],
            [['level_three'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'org_id' => 'Org ID',
            'number' => 'Number',
            'main_acc_id' => 'Main Acc ID',
            'level_one_id' => 'Level One ID',
            'level_two_id' => 'Level Two ID',
            'level_three' => 'Level Three',
            'currency' => 'Currency',
            'type' => 'Type',
        ];
    }
}
