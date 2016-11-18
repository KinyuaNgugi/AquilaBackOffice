<?php
/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 11/3/16
 * Time: 11:25 AM
 */

namespace app\controllers;


use app\models\OrgChart;
use app\models\Stock;
use app\models\Supplier;

class HrmController extends \yii\web\Controller
{
    public function actionEmployees()
    {
        $this->layout = 'backend';
        $chart=OrgChart::find()->all();
        return $this->render('employees', [
            'chart' => $chart
        ]);
    }
}