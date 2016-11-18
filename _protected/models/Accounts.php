<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property integer $org_id
 * @property integer $account_id
 * @property double $credit
 * @property double $debit
 * @property string $currency
 * @property double $rate
 * @property string $description
 * @property string $date
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'account_id'], 'integer'],
            [['credit', 'debit', 'rate'], 'number'],
            [['date'], 'safe'],
            [['currency'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 100],
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
            'account_id' => 'Account ID',
            'credit' => 'Credit',
            'debit' => 'Debit',
            'currency' => 'Currency',
            'rate' => 'Rate',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }
}
