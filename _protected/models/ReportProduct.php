<?php
/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 5/21/17
 * Time: 10:22 AM
 */

namespace app\models;


use DateTime;
use miloschuman\highcharts\Highcharts;
use Yii;

class ReportProduct
{
    function getProductInventory($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $current_assets=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=1 and level_one_id=2 and org_id="'.$id.
            '"and level_two_id= 34')
            ->queryAll();

        $items_and_balances=array();

        foreach ($current_assets as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($item_and_details as $item_and_detail){
                $balance=$balance+($item_and_detail['debit']-$item_and_detail['credit']);
            }
            array_push($items_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $items_and_balances;
    }
    public static function buildProductInventoryChart($id,$start_date = null,$end_date = null)
    {
        $results = self::getProductInventory($id,$start_date,$end_date);
        if ($results)
        {
            $y_data = array();
            $categories = array();
            $count = 0;
            for ($i=0;$i<count($results);$i++)
            {
                if ($results[$i]['bal'] > 0)
                {
                    $count++;
                    $categories[] = $results[$i]['acc'];
                    $y_data[] = intval($results[$i]['bal']);
                }
                if ($count >= 10) break;
            }
            if (count($y_data) == 0)
            {
                echo "No Data Exists";
                return;
            }
            $chart=array(
                'scripts' => [
                    'highcharts-3d',
                    'modules/drilldown',
                    'modules/exporting',
                    'themes/sand-signika',
                ],
                'options' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => 'Product Inventory Report '
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
                        'name' => 'Amount',
                        'colorByPoint' => true,
                        'data' => $y_data
                    ]
                ]
            ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }
    public static function buildProductInventoryTable($id,$start_date = null,$end_date = null)
    {
        $results = self::getProductInventory($id,$start_date,$end_date);
        if ($results)
        {
            $inventory_total = 0;
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $y_data[] = intval($results[$i]['bal']);
                $inventory_total += $results[$i]['bal'];
            }
            $html = "<table class = 'table table-striped table-condensed' ><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Product"."</th>";
            $html .= "<th>"."Inventory Total"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            for($i=0;$i<count($categories);$i++)
            {
                $html .= "<tr>";
                $html .= "<td>".$categories[$i]."</td>";
                $html .= "<td>".number_format($y_data[$i])."</td>";
                $html .= "</tr>";
            }
            $html .= "<tfoot><tr>";
            $html .= "<td colspan='2'>"."Total Inventory => ".number_format($inventory_total)."</td>";
            $html .= "</tr></tfoot>";
            $html .= "</tbody></table>";
            return $html;
        }
        else
            return 'No Data Exists';
    }
    function getIndividualProductTotalSales($id,$start_date,$end_date,$account_id){
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";

        $query = 'select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id. '"and level_two_id=\'34\'';
        if ($account_id != null)
            $query = 'select * from org_chart where id = '. $account_id;

        $current_assets=Yii::$app->db->createCommand($query)->queryAll();

        $items_and_balances=array();
        $count = 0;
        foreach ($current_assets as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($item_and_details as $item_and_detail){
                $balance=$balance+$item_and_detail['credit'];
            }

            if ($balance > 0) $count++;
            if ($count >= 10)
                break;

            if ($balance > 0 || $account_id != null)
                array_push($items_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $items_and_balances;
    }

    function getInventorySoldAndDates($id,$item,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $current_assets=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.
            '"and level_two_id=\'34\' and level_three="'.$item.'"')
            ->queryAll();

        $items_and_dates=array();
        foreach ($current_assets as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select MONTH(date) AS \'month\',YEAR(date) AS \'year\',SUM(credit) AS \'total\' from accounts_postings where account_id="'
                .$item['id'].'"'.$betweenSection.'GROUP BY MONTH(date) ,YEAR(date)')
                ->queryAll();

            $month_number="";
            foreach ($item_and_details as $item_and_detail){
                $dateObj   = DateTime::createFromFormat('!m', $item_and_detail['month']);
                $monthName = $dateObj->format('F');
                if ($month_number=="")
                    array_push($items_and_dates,array('date'=>$monthName.', '.$item_and_detail['year'],'bal'=>$item_and_detail['total']));
                elseif ($item_and_detail['month']-$month_number==1)
                    array_push($items_and_dates,array('date'=>$monthName.', '.$item_and_detail['year'],'bal'=>$item_and_detail['total']));
                else
                {
                    $missing_months=$item_and_detail['month']-$month_number;
                    for($i=0;$i<$missing_months;$i++)
                    {
                        $month_number++;
                        $dateObj   = DateTime::createFromFormat('!m', $month_number);
                        $monthName = $dateObj->format('F');
                        array_push($items_and_dates,array('date'=>$monthName.', '.$item_and_detail['year'],'bal'=>0));
                    }
                }
                $month_number=$item_and_detail['month'];
            }
        }
        return $items_and_dates;
    }
    
    public static function buildProductSalesAnalysisChart($id,$start_date = null,$end_date = null,$account_id = null)
    {
        $results = self::getIndividualProductTotalSales($id,$start_date,$end_date,$account_id);
        if ($results)
        {
            $y_data = array();
            $drilldown = array();
            for ($i=0;$i<count($results);$i++)
            {
                if ($results[$i]['bal'] > 0)
                {
                    $categories[] = $results[$i]['acc'];
                    $y_data[] = array('name' => $results[$i]['acc'],'y'=>intval($results[$i]['bal']),'drilldown'=> $results[$i]['acc']);

                    //drilldown
                    $prod_details = self::getInventorySoldAndDates($id,$results[$i]['acc'],$start_date,$end_date);
                    $drilldown_data = array();
                    foreach ($prod_details as $item)
                    {
                        $drilldown_data[] = array('name'=>$item['date'],'y'=>intval($item['bal']));
                    }
                    $drilldown[] = array('name'=>$results[$i]['acc']." Product Sales",'id'=>$results[$i]['acc'],'type'=>'line','data'=>$drilldown_data);
                }
            }
            if (count($y_data) == 0)
            {
                echo "No Data Exists";
                return;
            }
            $chart=array(
                'scripts' => [
                    'highcharts-3d',
                    'modules/drilldown',
                    'modules/exporting',
                    'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column'
                    ],
                    'title' => [
                        'text' => 'Product Sales Analysis Report'
                    ],
                    'xAxis' => [
                        'type' => 'category'
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Sales Amount in KSH'
                        ]
                    ],
                    'series' => [
                        [
                            'name' => 'Product Sales Amount',
                            'colorByPoint' => true,
                            'data' => $y_data
                        ]
                    ],
                    'drilldown' => [
                        'series' => $drilldown
                    ]
                ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }
    public static function buildProductSalesAnalysisTable($id,$start = null,$end = null, $account_id = null)
    {
        $products = self::getIndividualProductTotalSales($id,$start,$end,$account_id);
        if($products != NULL)
        {
            $html = "<table class = 'table table-striped table-condensed'><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Product"."</th>";
            $html .= "<th>"."Date"."</th>";
            $html .= "<th>"."Total Sales Amount"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            foreach($products as $row)
            {
                $product_details = self::getInventorySoldAndDates($id,$row['acc'],$start,$end);
                $temp="";
                foreach ($product_details as $detail)
                {
                    $html .= "<tr>";
                    if ($row['acc'] === $temp)
                        $html .= "<td>"."</td>";
                    else
                        $html .= "<td>".$row['acc']."</td>";
                    $html .= "<td>".$detail['date']."</td>";
                    $html .= "<td>".number_format($detail['bal'])."</td>";
                    $html .= "</tr>";
                    $temp=$row['acc'];
                }
            }
            $html .= "</tbody></table>";
            return $html;
        }
        else
            return 'No Data Exists';
    }
    function getIndividualProductTotalCosts($id,$start_date,$end_date,$account_id){
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";

        $query = 'select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id. '"and level_two_id=\'34\'';
        if ($account_id != null)
            $query = 'select * from org_chart where id = '. $account_id;

        $current_assets=Yii::$app->db->createCommand($query)->queryAll();

        $items_and_balances=array();
        $count = 0;
        foreach ($current_assets as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($item_and_details as $item_and_detail){
                $balance=$balance+$item_and_detail['debit'];
            }

            if ($balance > 0) $count++;
            if ($count >= 10)
                break;

            if ($balance > 0 || $account_id != null)
                array_push($items_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $items_and_balances;
    }
    function getInventoryBoughtAndDates($id,$item,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $current_assets=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.
            '"and level_two_id=\'34\' and level_three="'.$item.'"')
            ->queryAll();

        $items_and_dates=array();
        foreach ($current_assets as $item){
            $item_and_details=Yii::$app->db->createCommand
            ('select MONTH(date) AS \'month\',YEAR(date) AS \'year\',SUM(debit) AS \'total\' from accounts_postings where account_id="'
                .$item['id'].'"'.$betweenSection.'GROUP BY MONTH(date) ,YEAR(date)')
                ->queryAll();

            $month_number="";
            foreach ($item_and_details as $item_and_detail){
                $dateObj   = DateTime::createFromFormat('!m', $item_and_detail['month']);
                $monthName = $dateObj->format('F');
                if ($month_number=="")
                    array_push($items_and_dates,array('date'=>$monthName.', '.$item_and_detail['year'],'bal'=>$item_and_detail['total']));
                elseif ($item_and_detail['month']-$month_number==1)
                    array_push($items_and_dates,array('date'=>$monthName.', '.$item_and_detail['year'],'bal'=>$item_and_detail['total']));
                else
                {
                    $missing_months=$item_and_detail['month']-$month_number;
                    for($i=0;$i<$missing_months;$i++)
                    {
                        $month_number++;
                        $dateObj   = DateTime::createFromFormat('!m', $month_number);
                        $monthName = $dateObj->format('F');
                        array_push($items_and_dates,array('date'=>$monthName.', '.$item_and_detail['year'],'bal'=>0));
                    }
                }
                $month_number=$item_and_detail['month'];
            }
        }
        return $items_and_dates;
    }
    public static function buildProductCostAnalysisChart($id,$start_date = null,$end_date = null,$account_id = null)
    {
        $results = self::getIndividualProductTotalCosts($id,$start_date,$end_date,$account_id);
        if ($results)
        {
            $y_data = array();
            $drilldown = array();
            for ($i=0;$i<count($results);$i++)
            {
                if ($results[$i]['bal'] > 0)
                {
                    $categories[] = $results[$i]['acc'];
                    $y_data[] = array('name' => $results[$i]['acc'],'y'=>intval($results[$i]['bal']),'drilldown'=> $results[$i]['acc']);

                    //drilldown
                    $prod_details = self::getInventoryBoughtAndDates($id,$results[$i]['acc'],$start_date,$end_date);
                    $drilldown_data = array();
                    foreach ($prod_details as $item)
                    {
                        $drilldown_data[] = array('name'=>$item['date'],'y'=>intval($item['bal']));
                    }
                    $drilldown[] = array('name'=>$results[$i]['acc']." Product Costs",'id'=>$results[$i]['acc'],'type'=>'line','data'=>$drilldown_data);
                }
            }
            if (count($y_data) == 0)
            {
                echo "No Data Exists";
                return;
            }
            $chart=array(
                'scripts' => [
                    'highcharts-3d',
                    'modules/drilldown',
                    'modules/exporting',
                    'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column'
                    ],
                    'title' => [
                        'text' => 'Product Costs Analysis Report'
                    ],
                    'xAxis' => [
                        'type' => 'category'
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Cost Amount in KSH'
                        ]
                    ],
                    'series' => [
                        [
                            'name' => 'Product Cost Amount',
                            'colorByPoint' => true,
                            'data' => $y_data
                        ]
                    ],
                    'drilldown' => [
                        'series' => $drilldown
                    ]
                ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }
    public static function buildProductCostAnalysisTable($id,$start = null,$end = null, $account_id = null)
    {
        $products = self::getIndividualProductTotalCosts($id,$start,$end,$account_id);
        if($products != NULL)
        {
            $html = "<table class = 'table table-striped table-condensed'><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Product"."</th>";
            $html .= "<th>"."Date"."</th>";
            $html .= "<th>"."Total Cost Amount"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            foreach($products as $row)
            {
                $product_details = self::getInventoryBoughtAndDates($id,$row['acc'],$start,$end);
                $temp="";
                foreach ($product_details as $detail)
                {
                    $html .= "<tr>";
                    if ($row['acc'] === $temp)
                        $html .= "<td>"."</td>";
                    else
                        $html .= "<td>".$row['acc']."</td>";
                    $html .= "<td>".$detail['date']."</td>";
                    $html .= "<td>".number_format($detail['bal'])."</td>";
                    $html .= "</tr>";
                    $temp=$row['acc'];
                }
            }
            $html .= "</tbody></table>";
            return $html;
        }
        else
            return 'No Data Exists';
    }
    function getTotalInventory($id,$start_date,$end_date){
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
                $balance=$balance+($item_and_detail['debit']-$item_and_detail['credit']);
            }
            array_push($items_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $items_and_balances;
    }
}