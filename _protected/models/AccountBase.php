<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account_base".
 *
 * @property integer $id
 * @property string $account_base_name
 */
class AccountBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_base';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_base_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_base_name' => 'Account Base Name',
        ];
    }
}
