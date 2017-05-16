<?php
namespace app\models;
use Yii;

/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 8/11/16
 * Time: 9:47 AM
 */
class ReportAssets
{
    function getFixedAssets($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date_acquired between ' ". $start_date ."' and '". $end_date."')";
        }
        $fixed_assets=Yii::$app->db->createCommand
        ('select *  from asset  where asset.org_id="'.$id.'"'.$betweenSection)
            ->queryAll();
        return $fixed_assets;
    }
    function getFixedAssetsDepreciation($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date_acquired between ' ". $start_date ."' and '". $end_date."')";
        }
        $fixed_assets=Yii::$app->db->createCommand
        ('select cost,name,(cost-residual_value)/useful_life as \'depreciation\',datediff(curdate(),date_acquired) as \'life\'  from asset  where asset.org_id="'.$id.'"'.$betweenSection)
            ->queryAll();
        $items_and_depreciations=array();
        foreach ($fixed_assets as $asset){
            $years=round(abs($asset['life'])/365);
            $depreciation=$asset['depreciation']*$years;
            array_push($items_and_depreciations,array('name'=>$asset['name'],'dep'=>$depreciation));
        }
        return $items_and_depreciations;
    }
    
    function getCurrentAssets($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }

        $current_assets=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.'"')
            ->queryAll();
        $current_assets_and_balances=array();
        foreach ($current_assets as $current_asset){
            $current_assets_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$current_asset['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($current_assets_and_details as $item){
                $balance=$balance+($item['debit']-$item['credit'])*$item['rate'];
            }
            array_push($current_assets_and_balances,array('l1'=>1,'l2'=>$current_asset['level_two_id'],'acc'=>$current_asset['level_three'],'bal'=>$balance));
        }

        return $current_assets_and_balances;
    }
    
    
    function getBanks($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }

        $banks=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'1\' and org_id="'.$id.'"')
            ->queryAll();
        $banks_and_balances=array();
        foreach ($banks as $bank){
            $banks_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$bank['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($banks_and_details as $item){
                $balance=$balance+($item['debit']-$item['credit'])*$item['rate'];
            }
            array_push($banks_and_balances,array('l1'=>1,'l2'=>$bank['level_two_id'],'acc'=>$bank['level_three'],'bal'=>$balance));
        }

        return $banks_and_balances;
    }
    function getPettyCash($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }

        $banks=Yii::$app->db->createCommand
        ("select * from org_chart where main_acc_id=1 and level_one_id=1 AND level_two_id=1 AND level_two_id =1 AND level_three='petty cash' and org_id=$id")
            ->queryAll();
        $banks_and_balances=array();
        foreach ($banks as $bank){
            $banks_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$bank['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($banks_and_details as $item){
                $balance=$balance+($item['debit']-$item['credit'])*$item['rate'];
            }
            array_push($banks_and_balances,array('l1'=>1,'l2'=>$bank['level_two_id'],'acc'=>$bank['level_three'],'bal'=>$balance));
        }

        return $banks_and_balances;
    }
}