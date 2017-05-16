<?php
namespace app\controllers;
use app\models\Bankbranch;
use app\models\Banks;
use app\models\CountryTaxRates;
use app\models\OrgBanks;
use app\models\OrgChart;
use app\models\Stock;
use app\models\Supplier;
use yii;
use app\models\Partner;
use app\models\Paymentschedules;
use app\models\Partnercodeuse;
use app\models\Commision;
use app\models\Withdrawals;
use app\models\Transactions;
use app\models\Payouts;
use app\models\Payments;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\models\UploadForm;
use app\models\IdUploadForm;
use app\models\RegUploadForm;
use yii\web\UploadedFile;
use yii\data\Sort;

class DashboardController extends \yii\web\Controller
{
    public $focus;
    public function beforeAction($action)
    {
        $action = Yii::$app->controller->action->id;
        
        if (!parent::beforeAction($action)) {
            return false;
        }
        // other custom code here
        return true; // or false to not run the action
    }
    public function actionValidate()
    {
        //check if product code is taken
        $product_code = Yii::$app->request->get('prodcode');
        if (!empty($product_code))
        {
            $products = Stock::find()->where(array('productCode' => $product_code))->all();
            echo json_encode(count($products));
        }

        //check if product name is taken
        $product_name = Yii::$app->request->get('prodname');
        if (!empty($product_name))
        {
            $products = Stock::find()->where(array('productName' => $product_name))->all();
            echo json_encode(count($products));
        }
    }
    
    public function actionProducts()
    {
        $this->layout = 'backend';
        
        //save product
        $data=Yii::$app->request->post();
        if (!empty($data))
        {
            $model=new Stock();
            $model->productCode=strtoupper($data['productCode']);
            $model->productName=strtoupper($data['productName']);
            $model->buyingPricePerUnit=$data['buyingPricePerUnit'];
            $model->sellingPricePerUnit=$data['sellingPricePerUnit'];
            $model->supplierId=$data['supplierId'];
            $model->packing=$data['packing'];
            $model->reorderLevel=$data['reorderLevel'];
            $model->vat=$data['vat'];

            
            if ($model->save())
            {
                $chart_model=new OrgChart();
                $chart_model->main_acc_id=1;
                $chart_model->level_one_id=2;
                $chart_model->level_two_id=34;
                $chart_model->level_three=strtoupper($data['productName']);
                $chart_model->number=$model->stockId;
                $chart_model->currency = 'KSH';
                $chart_model->org_id=2;
                if ($chart_model->save())
                {
                    Yii::$app->session->setFlash('feedback' , ['type' => 'success','msg' => 'Product saved']);
                }
            }
            else
            {
                Yii::$app->session->setFlash('feedback', ['type' => 'danger', 'msg' => 'Product Not Saved']);
            }
            return $this->redirect(['dashboard/products']);
        }
        else
        {
            $taxes = CountryTaxRates::find()->where(array('supermarket_applicable' => '1'))->all();
            $suppliers = Supplier::find()->all();

            return $this->render('products', [
                'taxes'=>$taxes,
                'suppliers'=>$suppliers
            ]);
        }
    }
    public function actionBanks()
    {
        $this->layout = 'backend';

        $bank_code = Yii::$app->request->get('bank_code');
        $data=Yii::$app->request->post();
        if ($bank_code)
        {
            $branches = Bankbranch::find()->where(array('bankCode'=>$bank_code))
                ->orderBy(['name' => SORT_ASC])->all();
            $result=array();
            
            //get bank id
            $bank_id = Banks::find()->where(array('code'=>$bank_code))->one()->id;
            
            foreach ($branches as $branch)
                array_push($result,array('id'=>$branch->id,'name'=>$branch->name,'bank_id'=>$bank_id));
            echo json_encode($result);
        }
        //save bank
        elseif (!empty($data))
        {
            $model=new OrgBanks();
            $model->currency = 'KSH';
            $model->bank_id = $data['bank'];
            $model->branch_id = $data['branch'];
            $model->account = $data['account'];

            if ($model->save())
            {
                $chart_model=new OrgChart();
                $chart_model->main_acc_id=1;
                $chart_model->level_one_id=1;
                $chart_model->level_two_id=1;
                $bank_name = Banks::findOne($data['bank'])->bank;
                $branch_name = Bankbranch::findOne($data['branch'])->name;
                $chart_model->level_three=strtoupper($bank_name.'|'.$branch_name.'|'.$data['account']);
                $chart_model->number=$model->id;
                $chart_model->currency = 'KSH';
                $chart_model->org_id=2;
                if ($chart_model->save())
                {
                    Yii::$app->session->setFlash('feedback' , ['type' => 'success','msg' => 'Bank saved']);
                }
            }
            else
            {
                Yii::$app->session->setFlash('feedback' , ['type' => 'danger','msg' => 'Bank Not Saved']);
            }
            return $this->redirect(['dashboard/banks']);
        }
        else
        {
            $banks = Banks::find()->all();

            return $this->render('banks', [
                'banks'=>$banks,
            ]);
        }
    }
    public function actionChart()
    {
        $this->layout = 'backend';
        $chart=OrgChart::find()->all();
        return $this->render('chart-of-accounts', [
            'chart' => $chart
        ]);
    }
    public function actionPostings()
    {
        $this->layout = 'backend';
        return $this->render('postings');
    }
    public function actionFinancialstatements()
    {
        $this->layout = 'backend';
        return $this->render('financial_statements');
    }
    public function actionRevenuereports()
    {
        $this->layout = 'backend';
        return $this->render('revenue_reports');
    }
    public function actionCostreports()
    {
        $this->layout = 'backend';
        return $this->render('cost_reports');
    }
    public function actionDebtorreports()
    {
        $this->layout = 'backend';
        return $this->render('debtor_reports');
    }
    public function actionCreditorreports()
    {
        $this->layout = 'backend';
        return $this->render('creditor_reports');
    }
    public function actionVatreports()
    {
        $this->layout = 'backend';
        return $this->render('vat_reports');
    }
    public function actionWelcome()
    {
    	$this->layout = 'backend';
        if(Yii::$app->session->get('admin'))
        {
            $recent = Partner::find()->where(array('status' => 0))->limit(4)->all();
            $unapproved = Partner::find()->where(array('status' => 0))->all();
            $approved = Partner::find()->where(array('status' => 1))->all();
            return $this->render('admin-welcome',[
                'recent' => $recent,
                'unapproved' =>count($unapproved),
                'approved' => count($approved),
                'partners' => $approved,
                'totaldues' => Payments::totalDues(),
                'totalSales' => Payments::totalSales(),
                'totalCommision' => Payments::totalCommision()
            ]);
        }
        else
        {
            return $this->render('welcome',[
                'completeness' => $this->profileCompleteness(),
                'commision' => Commision::compute(Yii::$app->session->get('uid')),
                'clients' => count(Partnercodeuse::find()->where(array('code' => Yii::$app->session->get('uid')))->orderBy('id DESC')->all())
            ]);
        }
    }
    public function actionLogout()
    {
    	Yii::$app->session->removeAll();
    	return $this->redirect(['portal/index']);
    }

    public function actionCommunication()
    {
        $this->layout = 'backend';
        $partners = Partner::find()->orderBy('id DESC')->all();
        return $this->render('communication',[
            'partners' => $partners]);
    }
    public function actionEvents()
    {
        $this->layout = 'backend';
        return $this->render('events');
    }
    public function actionMerchandise()
    {
        $this->layout = 'backend';
        return $this->render('merchandise');
    }
    public function actionPayments()
    {
        $this->layout = 'backend';
        $page = Yii::$app->request->get('page');
        if(empty($page))
        {
            return $this->render('payments',[
                'requests' => Withdrawals::getrequests(),
                'newrequests' => Withdrawals::getNewrequests(),
                'schedules' => Paymentschedules::find()->all(),
                'payouts' => Payouts::find()->orderBy('id desc')->where(['status' => 1])->all(),
                'failed_payouts' => Payouts::find()->orderBy('id desc')->where(['status' => 0])->all()
                ]);
        }
        else
        {
            $schedule = Yii::$app->request->get('schedule');
            $partners = Partner::find()->where(['status' => 1,'payment_schedule' => $schedule])->all();
            $agents = array();
            foreach($partners as $partner)
            {
                $is_code_used = Partnercodeuse::find()->where(['code' => $partner->id]);
                if($is_code_used)
                {
                    $agents[] = $partner;
                }
            }
            if($page == 'queued')
            {
                 return $this->render('payments',[
                    'page' => 'queued_payouts',
                    'requests' => Withdrawals::find()->where(['queued' => 1])->all()
                    ]);
            }
            else
            {
                return $this->render('payments',[
                    'page' => 'payment_transactions_schedule',
                    'payouts' => $agents
                    ]);
            }
           
        }
    }
    public function actionReports()
    {
        $this->layout = 'backend';
        return $this->render('reports');

    }
    public function actionSettings()
    {
        $this->layout = 'backend';
        return $this->render('settings',[
            'commision' => Commision::find()->all(),
            'schedules' => Paymentschedules::find()->all()
            ]);
    }
    public function actionUsers()
    {
        $this->layout = 'backend';
        return $this->render('users');
    }
    public function actionIncentives()
    {
        $this->layout = 'backend';
        return $this->render('incentives');
    }
    public function actionClients()
    {
        $this->layout = 'backend';
        $clients = Partnercodeuse::find()->where(array('code' => Yii::$app->session->get('uid')))->orderBy('id DESC')->all();
        return $this->render('clients', [
            'clients' => $clients,
            'subscriptions' => Partnercodeuse::getSubscriptions('n')
        ]);
    }
    public function actionProfile()
    {
        $this->layout = 'backend';
        $data = Yii::$app->request->post();
        
        if(empty($data))
        {
            $profile = Partner::find()->where(array('id' => Yii::$app->session->get('uid')))->one();
            return $this->render('profile',[
                'profile' => $profile,
                'image' => new UploadForm(),
                'nationalid' => new IdUploadForm(),
                'breg' => new RegUploadForm(),
                'completeness' => $this->profileCompleteness(),
                'schedules' => Paymentschedules::find()->all(),
                'commision' => Commision::compute($profile->id)
            ]);
        }

        else
        {
            $partner = Partner::findOne(Yii::$app->session->get('uid'));
            if(!empty($data['Partner']['latlng']))
            {
                $latlng = $data['Partner']['latlng'];
                $latlng = str_replace('(', '', str_replace(')', '', $latlng));
                $parts = explode(',', $latlng);
                $lat = $parts[0];
                $lng = $parts[1];
                $partner->lat = $lat;
                $partner->lng = $lng;
                unset($data['Partner']['latlng']);
            }
            else
            {
                unset($data['Partner']['latlng']);
            }

            if(Yii::$app->session->get('pic'))
            {
                $partner->photo = Yii::$app->session->get('pic');
            }

            if(Yii::$app->session->get('national_id'))
            {
                $partner->national_id_copy = Yii::$app->session->get('national_id');
            }

            if(Yii::$app->session->get('b_reg'))
            {
                $partner->business_reg_copy = Yii::$app->session->get('b_reg');
            }
            
            if($partner->load($data) && $partner->save())
            {
                Yii::$app->session->setFlash('feedback',array('msg' => 'Profile information updated successfully','status' => 'success'));
                if($this->profileCompleteness($partner) == 100) 
                {
                    $partner->profile_complete = 1;
                    $partner->save(false);
                }
                return $this->render('profile',[
                    'profile' => $partner,
                    'image' => new UploadForm(),
                    'nationalid' => new IdUploadForm(),
                    'breg' => new RegUploadForm(),
                    'completeness' => $this->profileCompleteness(),
                    'schedules' => Paymentschedules::find()->all(),
                    'commision' => Commision::compute($partner->id)
                ]);
            }
        }
    }
    public function profileCompleteness($key = null)
    {
        if(!$key)
        {
            $key = Partner::findOne(Yii::$app->session->get('uid'));
        }       
        $count = 0;
        $total = 12;
        if($key->name) $count +=1;
        if($key->email) $count +=1;
        if($key->phone) $count +=1;
        if($key->dob) $count +=1;
        if($key->national_id) $count +=1;
        if($key->physical_address) $count +=1;
        if($key->payment_schedule) $count +=1;
        if($key->gender) $count +=1;
        if($key->partner_type) $count +=1;
        if($key->photo || $key->fbid) $count +=1;
        if($key->national_id_copy) $count +=1;
        if($key->partner_type == 'organisation')
        {
            if($key->business_reg_copy) $count +=1;
        }
        else
        {
            $total = 11;
        }
        return number_format(($count / $total) * 100);
    }
    public function actionPartnersales()
    {
        $this->layout = 'backend';
        $partner = Partner::findOne(Yii::$app->session->get('uid'));
        if($partner->c_structure)
        {
            $c_structure = Commision::findOne($partner->c_structure);
        }
        else
        {
            $c_structure = Commision::find()->where(['status' => 1])->one();
        }
        return $this->render('partnerpayments',
            [
             'commision' => Commision::compute($partner->id),
             'c_structure' =>  $c_structure,
             'complete_transactions' => Transactions::getTransactions('COMPLETED'),
             'pending_transactions' => Transactions::getTransactions('PENDING'),
             'invalid_transactions' => Transactions::getTransactions('INVALID')
            ]);
    }
    public function actionPartnerpayouts()
    {
        $this->layout = 'backend';
        $partner = Partner::findOne(Yii::$app->session->get('uid'));
        if($partner->c_structure)
        {
            $c_structure = Commision::findOne($partner->c_structure);
        }
        else
        {
            $c_structure = Commision::find()->where(['status' => 1])->one();
        }
        return $this->render('partnerpayouts',
            [
             'commision' => Commision::compute($partner->id),
             'c_structure' =>  $c_structure,
             'withdrawals' => Withdrawals::find()->where(['partner' => Yii::$app->session->get('uid')])->orderBy('id DESC')->all(),
             'payouts' => Payouts::find()->where(['partner' => $partner->id])->all(),
             'balance' => Payments::getBalance(Yii::$app->session->get('uid')),
             'total_payout' => Payments::getTotal(Yii::$app->session->get('uid'))
            ]
        );
    }
    public function actionSaleskit()
    {
        $this->layout = 'backend';
        return $this->render('saleskit');
    }
    public function actionPartnerevents()
    {
        $this->layout = 'backend';
        return $this->render('partnerevents');
    }
    public function actionShop()
    {
        $this->layout = 'backend';
        return $this->render('shop');
    }
    public function actionPartnerreports()
    {
        $this->layout = 'backend';
        return $this->render('partner-reports');
    }
    public function actionCalculator()
    {
        $this->layout = 'backend';
        return $this->render('commision-calculator');
    }
}
