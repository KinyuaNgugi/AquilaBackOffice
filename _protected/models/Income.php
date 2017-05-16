<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "income".
 *
 * @property integer $rid
 * @property string $receiptNumber
 * @property string $runDate
 * @property string $actualDate
 * @property integer $zedClear
 * @property integer $paid
 * @property integer $client_id
 */
class Income extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rid', 'receiptNumber', 'runDate', 'actualDate', 'paid'], 'required'],
            [['rid', 'zedClear', 'paid', 'client_id'], 'integer'],
            [['runDate', 'actualDate'], 'safe'],
            [['receiptNumber'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => 'Rid',
            'receiptNumber' => 'Receipt Number',
            'runDate' => 'Run Date',
            'actualDate' => 'Actual Date',
            'zedClear' => 'Zed Clear',
            'paid' => 'Paid',
            'client_id' => 'Client ID',
        ];
    }
    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }
    public function getIncome_items()
    {
        return $this->hasMany(IncomeItems::className(), ['receipt_id' => 'rid']);
    }

    public function search($params,$cat)
    {
        if ($cat == 'all')
            $query = Income::findBySql('select income.rid,sum(total) as \'total\',receiptNumber,client_id,
                        sum(t_tax) AS \'tax\',actualDate
                        from income INNER JOIN income_items ON income.rid = income_items.receipt_id
                        GROUP BY income.rid');

        if ($cat == 'paid')
            $query = Income::findBySql('select income.rid,sum(total) as \'total\',receiptNumber,client_id,
                        sum(t_tax) AS \'tax\',actualDate
                        from income INNER JOIN income_items ON income.rid = income_items.receipt_id
                        WHERE paid=1 GROUP BY income.rid');
        if ($cat == 'credit')
            $query = Income::findBySql('select income.rid,sum(total) as \'total\',receiptNumber,client_id,
                        sum(t_tax) AS \'tax\',actualDate
                        from income INNER JOIN income_items ON income.rid = income_items.receipt_id
                        WHERE paid=0 GROUP BY income.rid');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['receiptNumber' => $this->receiptNumber]);

        return $dataProvider;
    }
}
