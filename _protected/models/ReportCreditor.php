<?php
/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 5/8/17
 * Time: 10:38 AM
 */

namespace app\models;


use DateTime;
use miloschuman\highcharts\Highcharts;
use Yii;

class ReportCreditor
{
    function getTotalCreditors($id,$start_date,$end_date,$period)
    {
        $totals_and_times=array();
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";

        if (empty($period))
            $period="month";
        if($period == "year")
            $query='select sum((credit-debit)) as \'bal\',YEAR (date) as \'year\'from accounts_postings 
                      inner join org_chart on org_chart.id=accounts_postings.account_id
                      where main_acc_id=2 and level_one_id=4 and level_two_id =27 and org_chart.org_id= '
                .$id.$betweenSection. ' GROUP BY YEAR(date) order BY YEAR(date)';
        if ($period == "quarter")
            $query='select sum((credit-debit)) as \'bal\',YEAR(date) as \'year\', QUARTER(date) as \'quarter\' from accounts_postings 
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=2 and level_one_id=4 and level_two_id =27 and org_chart.org_id= '.$id.
                $betweenSection.' GROUP BY YEAR(date), QUARTER(date) order BY YEAR(date), QUARTER(date)';
        if($period == "month")
            $query='select sum((credit-debit)) as \'bal\',YEAR(date) as \'year\', MONTH(date) as \'month\' from accounts_postings
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=2 and level_one_id=4 and level_two_id =27 and org_chart.org_id= '.
                $id. $betweenSection.' GROUP BY YEAR(date), MONTH(date) order BY YEAR(date), MONTH(date)';
        if($period == "week")
            $query='select sum((credit-debit)) as \'bal\',YEAR(date) as \'year\',MONTH(date) as \'month\', 
                      WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 as \'week\' 
                      from accounts_postings inner join org_chart on org_chart.id=accounts_postings.account_id 
                      where main_acc_id=2 and level_one_id=4 and level_two_id =27 and org_chart.org_id=  '.$id.$betweenSection.
                ' GROUP BY YEAR(date),MONTH(date),WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 
                       order by YEAR(date),MONTH(date), WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 asc';
        if($period == "day")
            $query='select sum((credit-debit)) as \'bal\' ,date from accounts_postings
                    inner join org_chart on org_chart.id=accounts_postings.account_id
                    where main_acc_id=2 and level_one_id=4 and level_two_id =27 and org_chart.org_id= '.$id.$betweenSection.
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

    function getCreditBySupplier($id,$start_date,$end_date,$period)
    {
        $betweenSection="";
        if($start_date!=null && $end_date!=null)
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";


        if (empty($period))
            $period="month";
        $accounts_payable=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'2\' and level_one_id=\'4\' and level_two_id =27 and org_id="'.$id.'"')
            ->queryAll();
        $accounts_and_balances=array();
        $accounts_and_balances_agg=array();
        foreach ($accounts_payable as $item)
        {
            if($period == "year")
                $query='select sum((credit-debit)) as \'bal\',YEAR (date) as \'year\'from accounts_postings where account_id= '.$item['id'].$betweenSection.
                    ' GROUP BY YEAR(date) order BY YEAR(date)';
            if ($period == "quarter")
                $query='select sum((credit-debit)) as \'bal\',YEAR(date) as \'year\', QUARTER(date) as \'quarter\' from accounts_postings where account_id= '.$item['id'].
                    $betweenSection.' GROUP BY YEAR(date), QUARTER(date) order BY YEAR(date), QUARTER(date)';
            if($period == "month")
                $query='select sum((credit-debit)) as \'bal\',YEAR(date) as \'year\', MONTH(date) as \'month\' from accounts_postings where account_id= '.
                    $item['id']. $betweenSection.' GROUP BY YEAR(date), MONTH(date) order BY YEAR(date), MONTH(date)';
            if($period == "week")
                $query='select sum((credit-debit)) as \'bal\',YEAR(date) as \'year\',MONTH(date) as \'month\', 
                      WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 as \'week\' 
                      from accounts_postings where account_id= '.$item['id'].$betweenSection.' GROUP BY YEAR(date),MONTH(date),
                       WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 
                       order by YEAR(date),MONTH(date), WEEK(date,5) - WEEK(DATE_SUB(date, INTERVAL DAYOFMONTH(date)-1 DAY),5)+1 asc';
            if($period == "day")
                $query='select sum((credit-debit)) as \'bal\' ,date from accounts_postings where account_id= '.$item['id'].$betweenSection.
                    ' group by date order by date';

            $accounts_and_details=Yii::$app->db->createCommand($query)->queryAll();

            foreach ($accounts_and_details as $detail)
                array_push($accounts_and_balances,array('id'=>$item['id'],'acc'=>$item['level_three'],'bal'=>$detail['bal']));
        }
        foreach ($accounts_payable as $value)
        {
            $total=0;
            foreach ($accounts_and_balances as $account)
            {
                if ($value['id']==$account['id'])
                {
                    $total+=$account['bal'];
                }
            }
            if ($total!=0)
                array_push($accounts_and_balances_agg,array('acc'=>$value['level_three'],'bal'=>$total));
        }

        return $accounts_and_balances_agg;
    }

    public static function buildTotalCreditorsChart($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getTotalCreditors($id,$start_date,$end_date,$period);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['time'];
                $y_data[] = intval($results[$i]['total']);
            }
            $chart=array('options' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => 'Total Creditors Report'
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

    public static function buildCreditBySupplierChart($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getCreditBySupplier($id,$start_date,$end_date,$period);
        if ($results)
        {
            for ($i=0;$i<count($results);$i++)
            {
                $categories[] = $results[$i]['acc'];
                $y_data[] = intval($results[$i]['bal']);
            }
            $chart=array('options' => [
                'chart' => [
                    'type' => 'column'
                ],
                'title' => [
                    'text' => 'Credit By Supplier Report'
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
    
    public static function buildTotalCreditsTable($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getTotalCreditors($id,$start_date,$end_date,$period);
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
            $html .= "<th>"."Supplier"."</th>";
            $html .= "<th>"."Credit Amount"."</th>";
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
    public static function buildCreditBySupplierTable($id,$start_date = null,$end_date = null,$period=null)
    {
        $results = self::getCreditBySupplier($id,$start_date,$end_date,$period);
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
            $html .= "<th>"."Date"."</th>";
            $html .= "<th>"."Credit Amount"."</th>";
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

    function getAccountsPayable($id,$days=null)
    {
        $finObj=new ReportFinancialStatements();
        $oldest_date=$finObj->getOldestDateInAccounts($id);
        $betweenSection="";
        if ($days==30)
            $betweenSection=" and (date between date_sub(curdate(),interval 30 day) and curdate()  )";
        if ($days==60)
            $betweenSection=" and (date between date_sub(curdate(),interval 60 day) and curdate()  )";
        if ($days==90)
            $betweenSection=" and (date between date_sub(curdate(),interval 90 day) and curdate()  )";
        if ($days==120)
            $betweenSection=" and (date between' ".$oldest_date."' and curdate())";
        $current_assets=Yii::$app->db->createCommand
        ('select * from org_chart where main_acc_id=\'2\' and level_one_id=\'4\' and level_two_id=\'27\' and org_id="'.$id.'"')
            ->queryAll();
        $current_assets_and_balances=array();
        foreach ($current_assets as $current_asset){
            $current_assets_and_details=Yii::$app->db->createCommand
            ('select * from accounts_postings where account_id="'.$current_asset['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($current_assets_and_details as $item){
                $balance=$balance+($item['credit']-$item['debit']);
            }
            array_push($current_assets_and_balances,array('acc'=>$current_asset['level_three'],'bal'=>$balance));
        }

        return $current_assets_and_balances;
    }

    function getCreditorsByThirtyDayAgeingAnalysis($id)
    {
        $thirty_days=self::getAccountsPayable($id,30);
        return $thirty_days;
    }
    function getCreditorsBySixtyDayAgeingAnalysis($id)
    {
        $sixty_days_cumulative=self::getAccountsPayable($id,60);
        $debts_for_last_thirty_days=self::getCreditorsByThirtyDayAgeingAnalysis($id);
        $sixty_days=array();
        for ($i=0 ; $i<count($sixty_days_cumulative) ; $i++){
            $balance=$sixty_days_cumulative[$i]['bal']-$debts_for_last_thirty_days[$i]['bal'];
            array_push($sixty_days,array('acc'=>$sixty_days_cumulative[$i]['acc'],'bal'=>$balance));
        }
        return $sixty_days;
    }
    function getCreditorsByNinetyDayAgeingAnalysis($id)
    {
        $ninety_days_cumulative=self::getAccountsPayable($id,90);
        $debts_for_last_sixty_days=self::getCreditorsBySixtyDayAgeingAnalysis($id);
        $debts_for_last_thirty_days=self::getCreditorsByThirtyDayAgeingAnalysis($id);
        $ninety_days=array();
        for ($i=0 ; $i<count($ninety_days_cumulative) ; $i++){
            $balance=$ninety_days_cumulative[$i]['bal']-$debts_for_last_sixty_days[$i]['bal']-$debts_for_last_thirty_days[$i]['bal'];
            array_push($ninety_days,array('acc'=>$ninety_days_cumulative[$i]['acc'],'bal'=>$balance));
        }
        return $ninety_days;
    }
    function getCreditorsByOneTwentyDayAgeingAnalysis($id)
    {
        $one_twenty_days_cumulative=self::getAccountsPayable($id,120);
        $debts_for_last_ninety_days=self::getCreditorsByNinetyDayAgeingAnalysis($id);
        $debts_for_last_sixty_days=self::getCreditorsBySixtyDayAgeingAnalysis($id);
        $debts_for_last_thirty_days=self::getCreditorsByThirtyDayAgeingAnalysis($id);
        $one_twenty_days=array();
        for ($i=0 ; $i<count($one_twenty_days_cumulative) ; $i++){
            $balance=$one_twenty_days_cumulative[$i]['bal']-$debts_for_last_ninety_days[$i]['bal']-$debts_for_last_sixty_days[$i]['bal']-$debts_for_last_thirty_days[$i]['bal'];
            array_push($one_twenty_days,array('acc'=>$one_twenty_days_cumulative[$i]['acc'],'bal'=>$balance));
        }
        return $one_twenty_days;
    }
    public static function buildCreditorAgeingAnalysisChart($id)
    {
        $thirty_debts = self::getCreditorsByThirtyDayAgeingAnalysis($id);
        $sixty_debts = self::getCreditorsBySixtyDayAgeingAnalysis($id);
        $ninety_debts = self::getCreditorsByNinetyDayAgeingAnalysis($id);
        $one_twenty_debts = self::getCreditorsByOneTwentyDayAgeingAnalysis($id);

        if ($thirty_debts || $sixty_debts || $ninety_debts || $one_twenty_debts)
        {
            $thirty_day_debt_total = 0;
            $sixty_day_debt_total = 0;
            $ninety_day_debt_total = 0;
            $one_twenty_day_debt_total = 0;
            foreach ($thirty_debts as $key)
            {
                $thirty_debt_details [] = array($key['acc'],$key['bal']);
                $thirty_day_debt_total += $key['bal'];
            }
            foreach ($sixty_debts as $key)
            {
                $sixty_debt_details [] = array($key['acc'],$key['bal']);
                $sixty_day_debt_total += $key['bal'];
            }
            foreach ($ninety_debts as $key)
            {
                $ninety_debt_details [] = array($key['acc'],$key['bal']);
                $ninety_day_debt_total += $key['bal'];
            }
            foreach ($one_twenty_debts as $key)
            {
                $one_twenty_debt_details [] = array($key['acc'],$key['bal']);
                $one_twenty_day_debt_total += $key['bal'];
            }
            $categories[] = "30 Days";
            $y_data[] = array('name'=>"O to 30 days",'y'=>intval($thirty_day_debt_total),'drilldown'=>"30_day_drill");
            $categories[] = "60 Days";
            $y_data[] = array('name'=>"60 days",'y'=>intval($sixty_day_debt_total),'drilldown'=>"60_day_drill");
            $categories[] = "90 Days";
            $y_data[] = array('name'=>"90 days",'y'=>intval($ninety_day_debt_total),'drilldown'=>"90_day_drill");
            $categories[] = "120 + Days ";
            $y_data[] = array('name'=>"120 + days",'y'=>intval($one_twenty_day_debt_total),'drilldown'=>"120_day_drill");


            $chart=array('scripts' => [
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
                    'text' => 'Supplier Ageing Analysis'
                ],
                'xAxis' => [
                    'type'=> 'category'
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Amount in KSH'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Credit Amount',
                        'colorByPoint' => true,
                        'data' => $y_data,
                    ]
                ],
                'drilldown' => [
                    'series' => [
                        [
                            'id' => '30_day_drill',
                            'name' => 'Thirty Day Old Debt',
                            'data' => $thirty_debt_details
                        ],
                        [
                            'id' => '60_day_drill',
                            'name' => 'Sixty Day Old Debt',
                            'data' => $sixty_debt_details
                        ],
                        [
                            'id' => '90_day_drill',
                            'name' => 'Ninety Day Old Debt',
                            'data' => $ninety_debt_details
                        ],
                        [
                            'id' => '120_day_drill',
                            'name' => '120 + Day Old Debt',
                            'data' => $one_twenty_debt_details
                        ]
                    ]
                ]
            ]);
            echo HighCharts::widget($chart);
        }
        else echo "No Data Exists";
    }

    function preprocessCreditors($id)
    {
        $thirty_debts= self::getCreditorsByThirtyDayAgeingAnalysis($id);
        $sixty_debts= self::getCreditorsBySixtyDayAgeingAnalysis($id);
        $ninety_debts= self::getCreditorsByNinetyDayAgeingAnalysis($id);
        $one_twenty_debts= self::getCreditorsByOneTwentyDayAgeingAnalysis($id);
        $summary_analysis=array();
        for ($i=0;$i<count($thirty_debts);$i++){
            $account=$thirty_debts[$i]['acc'];
            $thirty_debt=$thirty_debts[$i]['bal'];
            $sixty_debt=$sixty_debts[$i]['bal'];
            $ninety_debt=$ninety_debts[$i]['bal'];
            $one_twenty_debt=$one_twenty_debts[$i]['bal'];
            if ($thirty_debt>0 || $sixty_debt>0 || $ninety_debt>0 ||$one_twenty_debt>0)
                array_push($summary_analysis,array('acc'=>$account,'thirty'=>$thirty_debt,'sixty'=>$sixty_debt,'ninety'=>$ninety_debt,'one_twenty'=>$one_twenty_debt));
        }
        return $summary_analysis;
    }
    
    public static function buildAgeingAnalysisByCreditorTable($id)
    {
        $creditors=self::preprocessCreditors($id);

        if($creditors != NULL)
        {
            $html = "<table class = 'table table-striped table-condensed'><thead>";
            //build table header
            $html .= "<tr>";
            $html .= "<th>"."Supplier"."</th>";
            $html .= "<th>"."0 to 30 days"."</th>";
            $html .= "<th>"."60 days"."</th>";
            $html .= "<th>"."90 days"."</th>";
            $html .= "<th>"."120+ days"."</th>";
            $html .= "<th>"."Amount Due"."</th>";
            $html .= "</tr>";

            $html .= "</thead><tbody>";
            //build table body
            $total_credit=0;
            foreach($creditors as $row) {
                $html .= "<tr>";
                $html .= "<td>".$row['acc']."</td>";
                $html .= "<td>".number_format($row['thirty']).".00"."</td>";
                $html .= "<td>".number_format($row['sixty']).".00"."</td>";
                $html .= "<td>".number_format($row['ninety']).".00"."</td>";
                $html .= "<td>".number_format($row['one_twenty']).".00"."</td>";
                $bal=$row['thirty']+$row['sixty']+$row['ninety']+$row['one_twenty'];
                $total_credit+=$bal;
                $html .= "<td>".number_format($bal).".00"."</td>";
                $html .= "</tr>";
            }

            //build table footer
            $html .= "<tfoot>";
            $html .= "<tr>";
            $html .= "<th>"."</th>";
            $html .= "<th>"."</th>";
            $html .= "<th>"."</th>";
            $html .= "<th>"."</th>";
            $html .= "<th>"."Total Credit"."</th>";
            $html .= "<th>".number_format($total_credit).".00"."</th>";
            $html .= "</tr>";
            $html .= "</tbody></table>";
            return $html;
        }
        else
            return 'No Data Exists';
    }
}
