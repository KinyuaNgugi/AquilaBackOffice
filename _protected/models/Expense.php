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

    public function search($params,$cat)
    {
        if ($cat==='all')
            $query = Expense::find()->with('supplier')->where(array('approved' => 0));

        if ($cat==='approved')
            $query = Expense::find()->with('supplier')->where(array('approved' => 1));

        if ($cat==='void')
            $query = Expense::find()->with('supplier')->where(array('approved' => 3));
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
}
