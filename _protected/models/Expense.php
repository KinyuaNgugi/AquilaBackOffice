<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "expense".
 *
 * @property integer $id
 * @property integer $org_id
 * @property string $po_number
 * @property integer $supplier_id
 * @property string $date
 * @property string $date_due
 * @property string $currency
 * @property string $notes_to_supplier
 * @property string $approved
 * @property double $rate
 */
class Expense extends \yii\db\ActiveRecord
{
    public $total;
    public $tax;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'supplier_id'], 'integer'],
            [['date', 'date_due'], 'safe'],
            [['notes_to_supplier'], 'string'],
            [['rate'], 'number'],
            [['po_number'], 'string', 'max' => 30],
            [['currency'], 'string', 'max' => 10],
            [['approved'], 'string', 'max' => 1],
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
            'po_number' => 'Po Number',
            'supplier_id' => 'Supplier ID',
            'date' => 'Date',
            'date_due' => 'Date Due',
            'currency' => 'Currency',
            'notes_to_supplier' => 'Notes To Supplier',
            'approved' => 'Approved',
            'rate' => 'Rate',
        ];
    }
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['supplierId' => 'supplier_id']);
    }
    public function getExpense_items()
    {
        return $this->hasMany(ExpenseItems::className(), ['po_id' => 'id']);
    }

    public function search($params,$cat,$start_date=null,$end_date=null)
    {
        $between_section = '';
        if ($start_date != null && $end_date != null)
            $between_section=" where (date between ' ". $start_date ."' and '". $end_date."')";

        if ($cat == 'all')
            $query = Expense::findBySql('select expense.id,sum(total) as \'total\',po_number,supplier_id
                        from expense INNER JOIN expense_items ON expense.id=expense_items.po_id
                        WHERE approved=0 GROUP BY expense.id');

        if ($cat =='approved')
            $query = Expense::findBySql('select expense.id,sum(total) as \'total\',po_number,supplier_id
                        from expense INNER JOIN expense_items ON expense.id=expense_items.po_id
                        WHERE approved=1 GROUP BY expense.id');

        if ($cat == 'void')
            $query = Expense::findBySql('select expense.id,sum(total) as \'total\',po_number,supplier_id
                        from expense INNER JOIN expense_items ON expense.id=expense_items.po_id
                        WHERE approved=2 GROUP BY expense.id');

        if ($cat == 'paid')
            $query = Expense::findBySql("select expense.id,sum(total) as \"total\",po_number,supplier_id,
                        sum(t_tax) AS \"tax\",date
                        from expense INNER JOIN expense_items ON expense.id=expense_items.po_id
                        $between_section AND approved=3 GROUP BY expense.id");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate()))
        {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['po_number' => $this->po_number]);
        $query->andFilterWhere(['like', 'supplier', $this->supplier_id]);

        return $dataProvider;
    }
    public function getTotalPaid($start_date=null,$end_date=null)
    {
        $between_section = '';
        if ($start_date != null && $end_date != null)
            $between_section=" where (date between ' ". $start_date ."' and '". $end_date."')";
        $total = 0;
        $expenses = Expense::findBySql("select expense.id,sum(total) as \"total\",po_number,supplier_id,
                        sum(t_tax) AS \"tax\",date
                        from expense INNER JOIN expense_items ON expense.id=expense_items.po_id
                        $between_section AND approved=3 GROUP BY expense.id")->all();
        
        foreach ($expenses as $key)
        {
            $total += $key->total;
        }
        return $total;
    }
    public function getTotalPaidTax($start_date=null,$end_date=null)
    {
        $between_section = '';
        if ($start_date != null && $end_date != null)
            $between_section=" where (date between ' ". $start_date ."' and '". $end_date."')";
        $tax = 0;
        $expenses = Expense::findBySql("select expense.id,sum(total) as \"total\",po_number,supplier_id,
                        sum(t_tax) AS \"tax\",date
                        from expense INNER JOIN expense_items ON expense.id=expense_items.po_id
                        $between_section AND approved=3 GROUP BY expense.id")->all();

        foreach ($expenses as $key)
        {
            $tax += $key->tax;
        }
        return $tax;
    }
}
