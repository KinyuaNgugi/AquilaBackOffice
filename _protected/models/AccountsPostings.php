<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "accounts_postings".
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
 * @property double $balance
 */
class AccountsPostings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts_postings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'account_id'], 'integer'],
            [['credit', 'debit', 'rate', 'balance'], 'number'],
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
            'balance' => 'Balance',
        ];
    }
    public static function getPostingsByAccount($id)
    {
        $query = self::find()->where(['account_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
    public static function getTotalDebit($id)
    {
        return self::find()->where(['account_id' => $id])->sum('debit');
    }
    public static function getTotalCredit($id)
    {
        return self::find()->where(['account_id' => $id])->sum('credit');
    }
}
