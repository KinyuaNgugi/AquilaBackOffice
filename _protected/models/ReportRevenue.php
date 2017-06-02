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
class ReportRevenue
{
    function getTotalRevenue($id,$start_date,$end_date,$period)
    {
        $totals_and_times=array();
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";

        if (empty($period))
            $period="month";
        if($period == "year")
            $query='select sum(credit) as \'bal\',YEAR (date) as \'year\'from accounts_postings 
                      inner join org_chart on org_chart.id=accounts_postings.account_id
                      where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '
                .$id.$betweenSection. ' GROUP BY YEAR(date) order BY YEAR(date)';

        if ($period == "quarter")
            $query='select sum(credit) as \'bal\',YEAR(date) as \'year\', QUARTER(date) as \'quarter\' from accounts_postings 
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '.$id.
                $betweenSection.' GROUP BY YEAR(date), QUARTER(date) order BY YEAR(date), QUARTER(date)';

        if($period == "month")
            $query='select sum(credit) as \'bal\',YEAR(date) as \'year\', MONTH(date) as \'month\' from accounts_postings
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id= '.
                $id. $betweenSection.' GROUP BY YEAR(date), MONTH(date) order BY YEAR(date), MONTH(date)';

        if($period == "week")
            $query='select sum(credit) as \'bal\',YEAR(date) as \'year\',MONTH(date) as \'month\', 
                      WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 as \'week\' 
                      from accounts_postings inner join org_chart on org_chart.id=accounts_postings.account_id 
                      where main_acc_id=\'1\' and level_one_id=\'2\' and level_two_id=34 and org_chart.org_id=  '.$id.$betweenSection.
                ' GROUP BY YEAR(date),MONTH(date),WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 
                       order by YEAR(date),MONTH(date), WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 asc';

        if($period == "day")
            $query='select sum(credit) as \'bal\' ,date from accounts_postings
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
    function getRevenueByProduct($id,$start_date,$end_date)
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
                $balance=$balance+$item_and_detail['credit'];
            }
            array_push($items_and_balances,array('acc'=>$item['level_three'],'bal'=>$balance));
        }
        return $items_and_balances;
    }
    public static function buildRevenueByProductChart($id,$start_date = null,$end_date = null)
    {
        $results = ReportRevenue::getRevenueByProduct($id,$start_date,$end_date);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $y_data_sales[] = $results[$i]['bal'];
            }
            $chart=array('options' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => 'Revenue By Product Report'
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
                        'name' => 'Sales',
                        'colorByPoint' => true,
                        'data' => $y_data_sales
                    ]
                ]
            ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }
    public static function buildRevenueByProductTable($id,$start_date,$end_date)
    {
        $results = ReportRevenue::getRevenueByProduct($id,$start_date,$end_date);
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
            $html .= "<th>"."Sale Amount"."</th>";
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
    public static function buildTotalRevenueChart($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getTotalRevenue($id,$start_date,$end_date,$period);
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
                        'text' => 'Total Revenue Report'
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
    public static function buildTotalRevenueTable($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getTotalRevenue($id,$start_date,$end_date,$period);
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
            $html .= "<th>"."Revenue Amount"."</th>";
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