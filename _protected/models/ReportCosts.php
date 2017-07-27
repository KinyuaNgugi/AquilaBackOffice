<?php
namespace app\models;
use DateTime;
use miloschuman\highcharts\Highcharts;
use Yii;

/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 8/11/16
 * Time: 9:47 AM
 */
class ReportCosts
{
    function getTotalsCosts($id,$start_date,$end_date,$period)
    {
        $totals_and_times=array();
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";

        if (empty($period))
            $period="month";
        if($period == "year")
            $query='select sum(debit) as \'bal\',YEAR (date) as \'year\'from accounts_postings 
                      inner join org_chart on org_chart.id=accounts_postings.account_id
                      where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '
                .$id.$betweenSection. ' GROUP BY YEAR(date) order BY YEAR(date)';

        if ($period == "quarter")
            $query='select sum(debit) as \'bal\',YEAR(date) as \'year\', QUARTER(date) as \'quarter\' from accounts_postings 
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '.$id.
                $betweenSection.' GROUP BY YEAR(date), QUARTER(date) order BY YEAR(date), QUARTER(date)';

        if($period == "month")
            $query='select sum(debit) as \'bal\',YEAR(date) as \'year\', MONTH(date) as \'month\' from accounts_postings
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '.
                $id. $betweenSection.' GROUP BY YEAR(date), MONTH(date) order BY YEAR(date), MONTH(date)';

        if($period == "week")
            $query='select sum(debit) as \'bal\',YEAR(date) as \'year\',MONTH(date) as \'month\', 
                      WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 as \'week\' 
                      from accounts_postings inner join org_chart on org_chart.id=accounts_postings.account_id 
                      where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id=  '.$id.$betweenSection.
                ' GROUP BY YEAR(date),MONTH(date),WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 
                       order by YEAR(date),MONTH(date), WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 asc';

        if($period == "day")
            $query='select sum(debit) as \'bal\' ,date from accounts_postings
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '.$id.$betweenSection.
                ' group by date order by date';

        $accounts_and_details=Yii::$app->db->createCommand($query)->queryAll();
        foreach ($accounts_and_details as $detail)
        {
            $time="";
            if($period == "year")
                $time=$detail['year'];
            if ($period == "quarter")
                $time="quarter ".$detail['quarter'].", ".$detail['year'];
            if($period == "month")
            {
                $monthNum  = $detail['month'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $time=$monthName.", ".$detail['year'];
            }
            if ($period == "week")
            {
                $monthNum  = $detail['month'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $time="week ".$detail['week'].", ".$monthName." ".$detail['year'];
            }
            if ($period == "day")
            {
                $period="day";
                $converted_date=date("d/m/Y ", strtotime($detail['date']));
                $time=$converted_date;
            }

            array_push($totals_and_times,array('time'=>$time,'total'=>$detail['bal']));
        }
        return $totals_and_times;
    }

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
            $chart=array('options' => [
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
    public static function buildTotalCostsChart($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getTotalsCosts($id,$start_date,$end_date,$period);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['time'];
                $y_data[] = intval($results[$i]['total']);
            }
            $chart=array('scripts' =>
                [
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
                    'text' => 'Total Costs Report'
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
    public static function buildTotalCostsTable($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getTotalsCosts($id,$start_date,$end_date,$period);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['time'];
                $data_sales[] = $results[$i]['total'];
            }
            $html = "<table class = 'table table-striped table-condensed' ><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Date"."</th>";
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

    function getIndividualSupplierCosts($id,$start_date,$end_date,$account_id){
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";

        $query = 'select * from org_chart where main_acc_id=2 and level_one_id=4 and org_id="'.$id. '"and level_two_id=27';
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
    function getSupplierExpensesByDate($id,$item,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $supplier_costs=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=2 and level_one_id=4 and org_id="'.$id.
            '"and level_two_id=27 and level_three="'.$item.'"')
            ->queryAll();

        $items_and_dates=array();
        foreach ($supplier_costs as $item){
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
    public static function buildSupplierAnalysisChart($id,$start_date = null,$end_date = null,$account_id = null)
    {
        $results = self::getIndividualSupplierCosts($id,$start_date,$end_date,$account_id);
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
                    $prod_details = self::getSupplierExpensesByDate($id,$results[$i]['acc'],$start_date,$end_date);
                    $drilldown_data = array();
                    foreach ($prod_details as $item)
                    {
                        $drilldown_data[] = array('name'=>$item['date'],'y'=>intval($item['bal']));
                    }
                    $drilldown[] = array('name'=>$results[$i]['acc']." Costs",'id'=>$results[$i]['acc'],'type'=>'line','data'=>$drilldown_data);
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
                        'text' => 'Supplier Analysis Report'
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
                            'name' => 'Supplier Cost Amount',
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
    public static function buildSupplierCostAnalysisTable($id,$start = null,$end = null, $account_id = null)
    {
        $products = self::getIndividualSupplierCosts($id,$start,$end,$account_id);
        if($products != NULL)
        {
            $html = "<table class = 'table table-striped table-condensed'><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Supplier"."</th>";
            $html .= "<th>"."Date"."</th>";
            $html .= "<th>"."Total Cost Amount"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            foreach($products as $row)
            {
                $product_details = self::getSupplierExpensesByDate($id,$row['acc'],$start,$end);
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
    function getExpensesByCategory($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $expenses=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=3 and org_id="'.$id.'"')
            ->queryAll();
        $expenses_and_balances=array();
        foreach ($expenses as $expense){
            $expenses_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$expense['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            if ($expenses_and_details!=null){
                foreach ($expenses_and_details as $item){
                    if ($item['debit']==0)
                        $balance=$balance+($item['credit']);
                    if ($item['credit']==0)
                        $balance=$balance-($item['debit']);
                    else
                        $balance=$balance+(($item['credit']-$item['debit']));
                }
                array_push($expenses_and_balances,array('l1'=>$expense['level_one_id'],'l2'=>$expense['level_two_id'],'acc'=>$expense['level_three'],'bal'=>abs($balance)));
            }
        }
        return $expenses_and_balances;
    }
}