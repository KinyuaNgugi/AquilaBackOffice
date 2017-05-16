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
class ReportRevenue
{
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
            $chart=array('clientOptions' => [
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
}