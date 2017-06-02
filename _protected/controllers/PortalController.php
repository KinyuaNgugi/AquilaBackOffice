<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Partner;
use app\models\PartnerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\helpers\Json;
use kartik\mpdf\Pdf;

class PortalController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('../site/index');
    }

    public function actionSignup()
    {
        $model = new Partner();
        if ($model->load(Yii::$app->request->post())) 
        {
            $data = Yii::$app->request->post()['Partner'];
            $model->created_at = (string) time();
            $model->updated_at = (string) time();
            $model->password = sha1($data['password']);
            $model->phone = substr($data['phone'], -9);
            $model->save(true);
            $this->ActionCreatesession($model->id);
            if(Yii::$app->session->get('uid'))
            {
                return $this->redirect(['dashboard/welcome', 'id' => $model->id]);
            }
            else
            {
                Yii::$app->session->setFlash('msg','Account not created');
                return $this->render('../site/signup', ['model' => $model,]);
            }
        } 
        else 
        {
            return $this->render('../site/signup', ['model' => $model,]);
        }
    }
    public function actionLogin()
    {
        $model = new User();
        if(Yii::$app->request->post())
        {
            $data = Yii::$app->request->post();
            $password = sha1($data['password']);
            $email = $data['email'];
            $user = User::find()->where(array('email' => $email,'password' => $password))->one();
            if($user)
            {
                $this->actionCreatesession($user->id);
                if(Yii::$app->session->get('uid'))
                {
                    return $this->redirect(['dashboard/products']);
                }
            }
            else
            {
                Yii::$app->session->setFlash('msg','Wrong email or password',true);
                $this->layout = 'user_login';
                return $this->render('../site/login',['model' => $model]);
            }
        }
        else
        {
            $this->layout = 'user_login';
            return $this->render('../site/login',['model' => $model]);
        }
    }
    private function actionCreatesession($user)
    {
        if(is_numeric($user))
        {
            $user = User::findOne($user);
            $user = array('uid' => $user->id,'name' => $user->username,'email' => $user->email/*,'phone' => $user->phone,'level' => $user->level*/);
            foreach($user as $key => $value)
            {
                Yii::$app->session->set($key,$value);
            }
        }
    }
    public function actionAbout()
    {
        return $this->render('../site/about');
    } 
    public function actionForgotpassword()
    {
        $model = new Partner();
        if(Yii::$app->request->post())
        {
            $data = Yii::$app->request->post();
            var_dump($data);
        }
        else
        {
            return $this->render('../site/forgot-password',['model' => $model]);
        }
    }
    public function actionTests3()
    {
        // creating an object
        // $data = ['one', 'two', 'three'];
        // Yii::$app->get('s3bucket')->put('PartnerPortal/example_1.txt', Json::encode($data));
        
        //uploading an object by streaming the contents of a stream
        // $resource = fopen('themes/light/images/logos/logo2.png', 'r+');
        // Yii::$app->get('s3bucket')->put('PartnerPortal/s3object.png', $resource);
       
        // uploading files
        $response = Yii::$app->get('s3bucket')->upload('PartnerPortal/logo'.time().'.png','themes/light/images/logos/logo2.png');
        // var_dump(count($response));
        /** @var \Aws\Result $result */
        // $result = Yii::$app->get('s3bucket')->get('PartnerPortal/file.png');
        // $data = $result['Body'];
        // $url = Yii::$app->get('s3bucket')->getUrl('PartnerPortal/logo1470920997.png');
        // $url = Yii::$app->get('s3bucket')->getCdnUrl('PartnerPortal/logo1470920997.png');     
        // echo "<img src='".$url."'>";
        var_dump($response);
    }
    public function actionTestmail()
    {
        Yii::$app->mailer->compose()
            ->setFrom('raphael.kinoti@openworld.co.ke')
            ->setTo('kinoti.raphs@gmail.com')
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>')
            ->attach('uploads/file.pdf')
            ->send();
    }
    public function actionTestpdf()
    {
        $this->layout = 'mail';
        $profile = Partner::findOne(Yii::$app->session->get('uid'));
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('../mail/welcome_mail',['profile' => $profile]);
        $filename = 'uploads/profile_summary_'.$profile->id.'.pdf';
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_FILE, 
            // set filename
            'filename' => $filename,
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.pdf-profile-picture{width:20%}.pdf-profile-picture img{border-radius:5px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Welcome aboard '.$profile->name],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['OPENWORLD LTD'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);           
        // return the pdf output as per the destination setting
        return $pdf->render(); 
        Yii::$app->mailer->compose()
            ->setFrom('raphael.kinoti@openworld.co.ke')
            ->setTo('kinoti.raphs@gmail.com')
            ->setSubject('Welcome Aboard '.$profile->name)
            ->setTextBody('Plain text content')
            ->setHtmlBody('Congratulations! Your account has been activated successfully. Find attached your account information')
            ->attach($filename)
            ->send(); 
    }
}
