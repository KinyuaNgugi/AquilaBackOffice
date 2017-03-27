<?php
/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 11/3/16
 * Time: 12:45 PM
 */

namespace app\controllers;
use app\models\Expense;
use app\models\ExpenseItems;
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
        $post_data_=Yii::$app->request->post();

        $suppliers = Supplier::find()->all();
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
            $buying_price=1;
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
        elseif (isset($data['taxtype']))
        {
            $tax_type=$data['taxtype'];
            $taxes = CountryTaxRates::find()->where(array('tax_rate_name' => $tax_type))->all();
            $rate=0;
            foreach ($taxes as $tax)
                $rate=$tax->rate;
            echo $rate/100;
        }
        elseif (isset($post_data_['product']) && $data['pk']==='new')
        {
            //var_dump($post_data_);exit;
            $invoice_ob=new Expense();
            $invoice_ob->org_id=2;
            $invoice_ob->po_number=$post_data_['inv-number'];
            $invoice_ob->supplier_id=$post_data_['supplier'];
            $invoice_ob->date=$post_data_['date'];
            $invoice_ob->date_due=$post_data_['date-due'];
           if ($invoice_ob->save())
           {
               for ($i=0;$i<count($post_data_['product']);$i++)
               {
                   $invoice_items_ob=new ExpenseItems();
                   $invoice_items_ob->po_id=$invoice_ob->id;
                   $product = Stock::find()->where(array('productName' => $post_data_['product'][$i]))->one();
                   $invoice_items_ob->item_id=$product->stockId;
                   $invoice_items_ob->unit_cost=$post_data_['price'][$i];
                   $tax = CountryTaxRates::find()->where(array('tax_rate_name' => $post_data_['tax-rate'][$i]))->one();
                   $invoice_items_ob->tax_id=$tax->id;
                   $invoice_items_ob->tax_rate=$tax->rate;
                   $invoice_items_ob->qty=$post_data_['qty'][$i];
                   $invoice_items_ob->t_tax=$post_data_['tax'][$i];
                   $invoice_items_ob->total=$post_data_['total'][$i];
                   $invoice_items_ob->save();
               }
               return $this->redirect(['expenses/purchase?pk='.$invoice_ob->id]);
           }
           else
           {
               return $this->redirect(['expenses/purchase?pk=new']);
           }
        }
        elseif (isset($post_data_['product']) && $data['pk']!=='new')
        {
            $invoice_ob=Expense::findOne($data['pk']);
            $invoice_ob->po_number=$post_data_['inv-number'];
            $invoice_ob->supplier_id=$post_data_['supplier'];
            $invoice_ob->date=$post_data_['date'];
            $invoice_ob->date_due=$post_data_['date-due'];
            if ($invoice_ob->save())
            {
                for ($i=0;$i<count($post_data_['product']);$i++)
                {
                    $invoice_items_ob=new ExpenseItems();
                    $invoice_items_ob->po_id=$invoice_ob->id;
                    $product = Stock::find()->where(array('productName' => $post_data_['product'][$i]))->one();
                    $invoice_items_ob->item_id=$product->stockId;
                    $invoice_items_ob->unit_cost=$post_data_['price'][$i];
                    $tax = CountryTaxRates::find()->where(array('tax_rate_name' => $post_data_['tax-rate'][$i]))->one();
                    $invoice_items_ob->tax_id=$tax->id;
                    $invoice_items_ob->tax_rate=$tax->rate;
                    $invoice_items_ob->qty=$post_data_['qty'][$i];
                    $invoice_items_ob->t_tax=$post_data_['tax'][$i];
                    $invoice_items_ob->total=$post_data_['total'][$i];
                    $invoice_items_ob->save();
                }
                return $this->redirect(['expenses/purchase?pk='.$invoice_ob->id]);
            }
        }
        else
        {
            $pk=$data['pk'];
            if ($pk === 'new')
            {
                $invoice = Expense::find()->all();
                $this->layout = 'backend';
                return $this->render('invoice',array('suppliers'=>$suppliers,'pk'=>'new','inv'=>'INV-'.count($invoice)));
            }
            else
            {
                $invoice=Expense::find()->where(array('id'=>$pk))->one();
                $supplier=Supplier::find()->where(array('supplierId'=>$invoice->supplier_id))->one();
                $suppliers=Supplier::find()->all();
                $invoice_items=ExpenseItems::find()->where(array('po_id'=>$pk))->all();
                $this->layout = 'backend';
                return $this->render('invoice',array('supplier'=>$supplier,'suppliers'=>$suppliers,
                    'items'=>$invoice_items,'pk'=>$pk,'inv'=>$invoice->po_number,'invoice'=>$invoice));
            }
        }
    }
    public function actionView()
    {
        $pk = Yii::$app->request->get('id');
        if (isset($pk))
        {
            return $this->redirect(['expenses/purchase?pk='.$pk]);
        }
    }
}