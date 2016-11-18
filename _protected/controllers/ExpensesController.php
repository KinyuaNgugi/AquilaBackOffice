<?php
/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 11/3/16
 * Time: 12:45 PM
 */

namespace app\controllers;
use yii;

use app\models\CountryTaxRates;
use app\models\Stock;
use app\models\Supplier;

class ExpensesController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = 'backend';
        return $this->render('index');
    }
    public function actionPurchase()
    {
        $data = Yii::$app->request->get();
        if (isset($data['search']))
        {
            $name=$data['search'];
            $products = Stock::find()->where('productName LIKE :substr', array(':substr' => '%'.$name.'%'))->all();
            $result=array();
            foreach ($products as $product)
                array_push($result,$product->productName);
            echo json_encode($result);
        }
        elseif (isset($data['product']))
        {
            $name=$data['product'];
            $products = Stock::find()->where(array('productName' => $name))->all();
            $buying_price=0;
            foreach ($products as $product)
                $buying_price=$product->buyingPricePerUnit;
            echo $buying_price;
        }
        elseif (isset($data['action']))
        {
            $taxes = CountryTaxRates::find()->where(array('supermarket_applicable' => '1'))->all();
            $result=array();
            foreach ($taxes as $tax)
                array_push($result,$tax->tax_rate_name);
            echo json_encode($result);
        }
        else
        {
            $products = Stock::find()->where(array('productCode' => '87303322'))->all();
            $suppliers = Supplier::find()->all();
            $taxes = CountryTaxRates::find()->where(array('supermarket_applicable' => '1'))->all();
            $this->layout = 'backend';
            return $this->render('purchase-order',array('products' => $products,'suppliers'=>$suppliers,'taxes'=>$taxes));
        }
    }
}