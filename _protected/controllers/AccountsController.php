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

class AccountsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'backend';
        return $this->render('index');
    }
    public function actionChart()
    {
        $this->layout = 'backend';
        $chart=OrgChart::find()->all();
        return $this->render('chart-of-accounts', [
            'chart' => $chart
        ]);
    }
    public function actionScript()
    {
        /*$stocks=Stock::find()->all();
        $count=0;
        foreach ($stocks as $stock)
        {
            $chart=new OrgChart();
            $chart->main_acc_id=4;
            $chart->level_one_id=6;
            $chart->level_two_id=10;
            $chart->org_id=2;
            $chart->number="4610".$count;
            $chart->level_three=$stock->productName;
            $count++;
            $chart->save();
        }*/
        /*$suppliers=Supplier::find()->all();
        $count=0;
        foreach ($suppliers as $stock)
        {
            $chart=new OrgChart();
            $chart->main_acc_id=2;
            $chart->level_one_id=4;
            $chart->level_two_id=31;
            $chart->org_id=2;
            $chart->number="2431".$count;
            $chart->level_three=$stock->supplierName;
            $count++;
            $chart->save();
        }*/

    }
}