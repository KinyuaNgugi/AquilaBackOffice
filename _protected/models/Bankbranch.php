<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bankbranch".
 *
 * @property string $code
 * @property string $name
 * @property string $bankCode
 * @property integer $id
 */
class Bankbranch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bankbranch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'bankCode'], 'required'],
            [['code', 'bankCode'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'bankCode' => 'Bank Code',
            'id' => 'ID',
        ];
    }
}
