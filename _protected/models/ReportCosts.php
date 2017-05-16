<?php
namespace app\models;
use dosamigos\highcharts\HighCharts;
use Yii;

/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 8/11/16
 * Time: 9:47 AM
 */
class ReportCosts
{
    function getCostByProduct($id,$start_date,$end_date)
    {
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $current_assets=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.
            '"and level_two_id=\'34\'')
            ->queryAll();

        $items_and_balances=array();
        foreach ($current_assets as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($item_and_details as $item_and_detail){
                $balance=$balance+$item_and_detail['debit'];
            }
            array_push($items_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $items_and_balances;
    }
    public static function buildCostByProductChart($id,$start_date = null,$end_date = null)
    {
        $results = self::getCostByProduct($id,$start_date,$end_date);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $y_data[] = $results[$i]['bal'];
            }
            $chart=array('clientOptions' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => 'Cost By Product Report'
                ],
                'xAxis' => [
                    'categories' => $categories
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Amount in KSH'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Costs',
                        'colorByPoint' => true,
                        'data' => $y_data
                    ]
                ]
            ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }
    public static function buildCostByProductTable($id,$start_date,$end_date)
    {
        $results = ReportCosts::getCostByProduct($id,$start_date,$end_date);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $data_sales[] = $results[$i]['bal'];
            }
            $html = "<table class = 'table table-striped table-condensed' ><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Product"."</th>";
            $html .= "<th>"."Cost Amount"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            for($i=0;$i<count($categories);$i++)
            {
                $html .= "<tr>";
                $html .= "<td>".$categories[$i]."</td>";
                $html .= "<td>".number_format($data_sales[$i])."</td>";
                $html .= "</tr>";
            }
            $html .= "</tbody></table>";
            return $html;
        }
        else
            return 'No Data Exists';
    }
    function getCostBySupplier($id,$start_date,$end_date)
    {
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $suppliers=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'2\' and level_one_id=\'4\' and level_two_id=\'27\'and org_id="'.$id.'"')
            ->queryAll();

        $suppliers_and_balances=array();
        foreach ($suppliers as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($item_and_details as $item_and_detail){
                $balance = $balance+$item_and_detail['credit'];
            }
            array_push($suppliers_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $suppliers_and_balances;
    }
    public static function buildCostBySupplierChart($id,$start_date = null,$end_date = null)
    {
        $results = self::getCostBySupplier($id,$start_date,$end_date);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $y_data[] = $results[$i]['bal'];
            }
            $chart=array('clientOptions' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => 'Cost By Supplier Report'
                ],
                'xAxis' => [
                    'categories' => $categories
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Amount in KSH'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Costs',
                        'colorByPoint' => true,
                        'data' => $y_data
                    ]
                ]
            ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }
    public static function buildCostBySupplierTable($id,$start_date,$end_date)
    {
        $results = ReportCosts::getCostBySupplier($id,$start_date,$end_date);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $data_sales[] = $results[$i]['bal'];
            }
            $html = "<table class = 'table table-striped table-condensed' ><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Supplier"."</th>";
            $html .= "<th>"."Cost Amount"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            for($i=0;$i<count($categories);$i++)
            {
                $html .= "<tr>";
                $html .= "<td>".$categories[$i]."</td>";
                $html .= "<td>".number_format($data_sales[$i])."</td>";
                $html .= "</tr>";
            }
            $html .= "</tbody></table>";
            return $html;
        }
        else
            return 'No Data Exists';
    }
}