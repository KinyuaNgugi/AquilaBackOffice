<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property integer $id
 * @property string $bank
 * @property string $code
 * @property integer $countryId
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bank', 'code', 'countryId'], 'required'],
            [['countryId'], 'integer'],
            [['bank'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank' => 'Bank',
            'code' => 'Code',
            'countryId' => 'Country ID',
        ];
    }
}
