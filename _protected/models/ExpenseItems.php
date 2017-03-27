<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense_items".
 *
 * @property integer $id
 * @property integer $po_id
 * @property integer $item_id
 * @property double $unit_cost
 * @property integer $tax_id
 * @property double $tax_rate
 * @property integer $qty
 * @property double $t_tax
 * @property double $total
 */
class ExpenseItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['po_id', 'item_id', 'tax_id', 'qty'], 'integer'],
            [['unit_cost', 'tax_rate', 't_tax', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_id' => 'Po ID',
            'item_id' => 'Item ID',
            'unit_cost' => 'Unit Cost',
            'tax_id' => 'Tax ID',
            'tax_rate' => 'Tax Rate',
            'qty' => 'Qty',
            't_tax' => 'T Tax',
            'total' => 'Total',
        ];
    }
}
