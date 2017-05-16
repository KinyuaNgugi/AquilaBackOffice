<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "income_items".
 *
 * @property integer $saleId
 * @property integer $unitsSold
 * @property integer $receipt_id
 * @property string $dateOfSale
 * @property integer $userId
 * @property integer $tillId
 * @property integer $stockId
 * @property string $runDate
 * @property integer $zedClear
 * @property double $profit
 * @property double $t_tax
 * @property double $unit_cost
 * @property double $total
 */
class IncomeItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unitsSold', 'dateOfSale', 'userId', 'tillId', 'runDate', 'profit', 't_tax', 'unit_cost', 'total'], 'required'],
            [['unitsSold', 'receipt_id', 'userId', 'tillId', 'stockId', 'zedClear'], 'integer'],
            [['dateOfSale', 'runDate'], 'safe'],
            [['profit', 't_tax', 'unit_cost', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'saleId' => 'Sale ID',
            'unitsSold' => 'Units Sold',
            'receipt_id' => 'Receipt ID',
            'dateOfSale' => 'Date Of Sale',
            'userId' => 'User ID',
            'tillId' => 'Till ID',
            'stockId' => 'Stock ID',
            'runDate' => 'Run Date',
            'zedClear' => 'Zed Clear',
            'profit' => 'Profit',
            't_tax' => 'T Tax',
            'unit_cost' => 'Unit Cost',
            'total' => 'Total',
        ];
    }
}
