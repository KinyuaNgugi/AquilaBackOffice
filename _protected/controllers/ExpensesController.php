<?php
/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 11/3/16
 * Time: 12:45 PM
 */

namespace app\controllers;
use app\models\AccountsPostings;
use app\models\Expense;
use app\models\ExpenseItems;
use app\models\OrgChart;
use app\models\PaymentMethods;
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
    public function actionSuppliers()
    {
        $data = Yii::$app->request->post();
        if ($data)
        {
            $model=new Supplier();
            $model->kraPin = $data['pin'];
            $model->supplierName = $data['name'];
            if ($data['email'])  $model->email = $data['email'];
            $model->methodOfPayment = $data['payment'];
            $model->phoneNumber = $data['phone'];

            if ($model->save())
            {
                $chart_model=new OrgChart();
                $chart_model->main_acc_id=2;
                $chart_model->level_one_id=4;
                $chart_model->level_two_id=27;
                $chart_model->level_three=strtoupper($data['name']);
                $chart_model->number=$model->supplierId;
                $chart_model->currency = 'KSH';
                $chart_model->org_id=2;
                if ($chart_model->save())
                {
                    Yii::$app->session->setFlash('feedback' , ['type' => 'success','msg' => 'Supplier saved']);
                }
            }
            else
            {
                Yii::$app->session->setFlash('feedback' , ['type' => 'danger','msg' => 'Supplier Not Saved']);
            }
            return $this->redirect(['expenses/suppliers']);
        }
        $this->layout = 'backend';
        return $this->render('suppliers',
            ['payment_methods' => PaymentMethods::find()->all()]);
    }
    public function actionPurchase()
    {
        $data = Yii::$app->request->get();
        $post_data_=Yii::$app->request->post();

        $suppliers = Supplier::find()->all();
        //ajax to search for products
        if (isset($data['search']))
        {
            $name=$data['search'];
            $products = Stock::find()->where('productName LIKE :substr', array(':substr' => '%'.$name.'%'))->all();
            $result=array();
            foreach ($products as $product)
                array_push($result,$product->productName);
            echo json_encode($result);
        }
        //ajax to return buying price of product
        elseif (isset($data['product']))
        {
            $name=$data['product'];
            $products = Stock::find()->where(array('productName' => $name))->all();
            $buying_price=1;
            foreach ($products as $product)
                $buying_price=$product->buyingPricePerUnit;
            echo $buying_price;
        }
        //ajax to return tax rates
        elseif (isset($data['action']))
        {
            $taxes = CountryTaxRates::find()->where(array('supermarket_applicable' => '1'))->all();
            $result=array();
            foreach ($taxes as $tax)
                array_push($result,$tax->tax_rate_name);
            echo json_encode($result);
        }
        //ajax to calculate tax amount
        elseif (isset($data['taxtype']))
        {
            $tax_type=$data['taxtype'];
            $taxes = CountryTaxRates::find()->where(array('tax_rate_name' => $tax_type))->all();
            $rate=0;
            foreach ($taxes as $tax)
                $rate=$tax->rate;
            echo $rate/100;
        }
        //save new invoice
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
        //update invoice
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
                $invoice=Expense::findOne($pk);
                $supplier=Supplier::find()->where(array('supplierId'=>$invoice->supplier_id))->one();
                $suppliers=Supplier::find()->all();
                $invoice_items=ExpenseItems::find()->where(array('po_id'=>$pk))->all();
                $this->layout = 'backend';
                return $this->render('invoice',array('supplier'=>$supplier,'suppliers'=>$suppliers,
                    'items'=>$invoice_items,'pk'=>$pk,'invoice'=>$invoice,'inv'=>$invoice->po_number));
            }
        }
    }
    public function actionApprove()
    {
        $pk = Yii::$app->request->get('id');
        if (isset($pk))
        {
            $model = Expense::findOne($pk);
            $model->approved = 1;
            if ($model->save(false))
            {
                //debit all inventories
                $inventories = ExpenseItems::find()->where(array('po_id'=>$model->id))->all();
                $total_po_cost = 0;
                foreach ($inventories as $inventory)
                {
                    $account_to_debit = OrgChart::find()->where(
                        array('number'=>$inventory->item_id,'main_acc_id'=>1,
                            'level_one_id'=>2,'level_two_id'=>34))->one()->id;
                    $debit_post_model = new AccountsPostings();
                    $debit_post_model->account_id = $account_to_debit;
                    $debit_post_model->debit = $inventory->total;
                    $debit_post_model->currency = 'KSH';
                    $debit_post_model->org_id = 2;
                    $debit_post_model->date = date("Y-m-d");
                    $debit_post_model->description = 'Increase inventory from invoice '.$model->po_number;
                    $balance = $inventory->total;
                    $previous_entry_model = AccountsPostings::find()->where(['account_id' => $account_to_debit])->one();
                    if ($previous_entry_model)
                        $balance = $previous_entry_model->balance + $balance;
                    $debit_post_model->balance = $balance;
                    $total_po_cost += $inventory->total;

                    $debit_post_model->save();
                }

                //credit the creditor
                $credit_post_model = new AccountsPostings();
                $account_to_credit = OrgChart::find()->where(
                    array('number'=>$model->supplier_id,'main_acc_id'=>2,
                        'level_one_id'=>4,'level_two_id'=>27))->one()->id;
                $credit_post_model->account_id = $account_to_credit;
                $credit_post_model->credit = $total_po_cost;
                $credit_post_model->currency = 'KSH';
                $credit_post_model->org_id = 2;
                $credit_post_model->date = date("Y-m-d");
                $credit_post_model->description = 'Debt for invoice '.$model->po_number;
                $balance = $total_po_cost;
                $previous_entry_model = AccountsPostings::find()->where(['account_id' => $account_to_credit])->one();
                if ($previous_entry_model)
                    $balance = $previous_entry_model->balance + $balance;
                $credit_post_model->balance = $balance;
                $credit_post_model->save();

                Yii::$app->session->setFlash('feedback' , ['type' => 'success','msg' => 'Invoice approved']);
            }
            else
            {
                Yii::$app->session->setFlash('feedback' , ['type' => 'danger','msg' => 'Invoice not approved']);
            }
            return $this->redirect(['expenses/purchase?pk='.$pk]);
        }
    }
    public function actionPay()
    {
        $data = Yii::$app->request->get();
        if ($data)
        {
            $expense_model = Expense::findOne($data['id']);
            $expense_model->approved = 3;
            if ($expense_model->save(false))
            {
                //credit the bank account
                $credit_post_model = new AccountsPostings();
                $credit_post_model->account_id = $data['account'];
                $credit_post_model->credit = $data['amount'];
                $credit_post_model->currency = 'KSH';
                $credit_post_model->org_id = 2;
                $credit_post_model->date = date("Y-m-d");
                $credit_post_model->description = 'Withdrawal for payment of invoice '.$expense_model->po_number;
                $balance = $data['amount'] * -1;
                $previous_entry_model = AccountsPostings::find()->where(['account_id' => $data['account']])->one();
                if ($previous_entry_model)
                    $balance = $previous_entry_model->balance + $balance;
                $credit_post_model->balance = $balance;

                //debit the accounts payable
                $account_to_debit = OrgChart::find()->where(
                    array('number'=>$expense_model->supplier_id,'main_acc_id'=>2,
                        'level_one_id'=>4,'level_two_id'=>27))->one()->id;
                $debit_post_model = new AccountsPostings();
                $debit_post_model->account_id = $account_to_debit;
                $debit_post_model->debit = $data['amount'];
                $debit_post_model->currency = 'KSH';
                $debit_post_model->org_id = 2;
                $debit_post_model->date = date("Y-m-d");
                $debit_post_model->description = 'Payment for invoice '.$expense_model->po_number;
                $balance = $data['amount'] * -1;
                $previous_entry_model = AccountsPostings::find()->where(['account_id' => $account_to_debit])->one();
                if ($previous_entry_model)
                    $balance = $previous_entry_model->balance + $balance;
                $debit_post_model->balance = $balance;

                if ($credit_post_model->save() && $debit_post_model->save())
                {
                    Yii::$app->session->setFlash('feedback' , ['type' => 'success','msg' => 'Invoice paid']);
                }
                else
                {
                    Yii::$app->session->setFlash('feedback' , ['type' => 'danger','msg' => 'Invoice paid but error posting to accounts']);
                }
            }
            else
            {
                Yii::$app->session->setFlash('feedback' , ['type' => 'danger','msg' => 'Payment not made']);
            }
            return $this->redirect(['expenses/purchase?pk='.$data['id']]);
        }
    }
    public function actionVoid()
    {
        $pk = Yii::$app->request->get('id');
        if (isset($pk))
        {
            $model = Expense::findOne($pk);
            $model->approved = 2;
            if ($model->save(false))
            {
                Yii::$app->session->setFlash('feedback' , ['type' => 'success','msg' => 'Invoice voided']);
                return $this->redirect(['expenses/index#tab2']);
            }
            else
            {
                Yii::$app->session->setFlash('feedback' , ['type' => 'danger','msg' => 'Invoice not voided']);
                return $this->redirect(['expenses/purchase?pk='.$pk]);
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