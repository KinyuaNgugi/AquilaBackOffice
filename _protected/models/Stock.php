<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "stock".
 *
 * @property integer $stockId
 * @property integer $buyingPricePerUnit
 * @property integer $packing
 * @property string $productCode
 * @property string $productName
 * @property integer $reorderLevel
 * @property integer $sellingPricePerUnit
 * @property integer $supplierId
 * @property integer $unitsInStock
 * @property integer $vat
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'buyingPricePerUnit', 'productCode', 'productName', 'reorderLevel', 'sellingPricePerUnit', 'supplierId', 'vat'], 'required'],
            [['stockId', 'buyingPricePerUnit', 'packing', 'reorderLevel', 'sellingPricePerUnit', 'supplierId', 'unitsInStock', 'vat'], 'integer'],
            [['productCode', 'productName'], 'string', 'max' => 255],
            [['productCode'], 'unique'],
            [['productName'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stockId' => 'Stock ID',
            'buyingPricePerUnit' => 'Buying Price Per Unit',
            'packing' => 'Packing',
            'productCode' => 'Product Code',
            'productName' => 'Product Name',
            'reorderLevel' => 'Reorder Level',
            'sellingPricePerUnit' => 'Selling Price Per Unit',
            'supplierId' => 'Supplier ID',
            'unitsInStock' => 'Units In Stock',
            'vat' => 'Vat',
        ];
    }
    public function search($params,$cat)
    {
        if ($cat == 'all')
            $query = Stock::find();

        if ($cat == 'vat')
            $query = Stock::find()->where(array('vat' => 1));
        
        if ($cat == 'exempt')
            $query = Stock::find()->where(array('vat' => 2));

        if ($cat == 'reorder')
            $query = Stock::findBySql("Select * from stock WHERE unitsInStock<reorderLevel");

        if ($cat == 'all')
        {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);
        }
        else
        {
            $dataProvider = new ActiveDataProvider([
                'query' => $query
            ]);
        }


        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) 
        {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'productCode', $this->productCode])
            ->andFilterWhere(['like', 'productName', $this->productName]);

        return $dataProvider;
    }
}
