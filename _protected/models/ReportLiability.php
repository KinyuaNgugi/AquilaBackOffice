<?php
namespace app\models;
use Yii;

/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 8/16/16
 * Time: 10:20 AM
 */
class ReportLiability
{
    function getCurrentLiabilities($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }

        $current_liabilities=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'2\' and level_one_id=\'4\' and org_id="'.$id.'"')
            ->queryAll();
        $current_liabilities_and_balances=array();
        foreach ($current_liabilities as $current_liability){
            $current_liabilities_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$current_liability['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($current_liabilities_and_details as $item){
                $balance=$balance+($item['credit']-$item['debit']);
            }
            array_push($current_liabilities_and_balances,array('l2'=>$current_liability['level_two_id'],'acc'=>$current_liability['level_three'],'bal'=>$balance));
        }

        return $current_liabilities_and_balances;
    }
    function getNonCurrentLiabilities($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }

        $noncurrent_liabilities=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'2\' and level_one_id=\'5\' and org_id="'.$id.'"')
            ->queryAll();
        $noncurrent_liabilities_and_balances=array();
        foreach ($noncurrent_liabilities as $noncurrent_liability){
            $noncurrent_liabilities_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$noncurrent_liability['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($noncurrent_liabilities_and_details as $item){
                $balance=$balance+($item['credit']-$item['debit']);
            }
            array_push($noncurrent_liabilities_and_balances,array('l2'=>$noncurrent_liability['level_two_id'],'acc'=>$noncurrent_liability['level_three'],'bal'=>$balance));
        }

        return $noncurrent_liabilities_and_balances;
    }
}