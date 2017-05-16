<?php
namespace app\models;
use Yii;

/**
 * Created by PhpStorm.
 * User: openworldkin
 * Date: 8/15/16
 * Time: 5:02 PM
 */
class ReportFinancialStatements
{
    function number_unformat($number, $force_number = true, $dec_point = '.', $thousands_sep = ',') {
        if ($force_number) {
            $number = preg_replace('/^[^\d-]+/', '', $number);
        } else if (preg_match('/^[^\d]+/', $number)) {
            return false;
        }
        $type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
        $number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
        settype($number, $type);
        return $number;
    }

    function getOldestDateInAccounts($id){
        $start_date='1970-01-01';
        $start_date_resultset=Yii::$app->db->createCommand
        ('SELECT date FROM accounts_postings WHERE  org_id="'.$id.'"ORDER BY date ASC LIMIT 1')
            ->queryAll();
        foreach ($start_date_resultset as $item){
            $start_date=$item['date'];
        }
        
        return $start_date;
    }
    /*balance sheet*/
    function populateAssets($id,$start_date,$end_date){
        $assetObj=new ReportAssets();
        $fixed_assets=$assetObj->getFixedAssets($id,$start_date,$end_date);
        $current_assets_encoded=$assetObj->getCurrentAssets($id,$start_date,$end_date);
        $banks_encoded=$assetObj->getBanks($id,$start_date,$end_date);
        $depreciations=$assetObj->getFixedAssetsDepreciation($id,$start_date,$end_date);

        $assets_decoded=array();

        //get all fixed assets
        $total_fixed_assets=0;
        foreach ($fixed_assets as $fixed_asset){
            $total_fixed_assets+=$fixed_asset['cost'];
        }

        array_push($assets_decoded,
            array("base"=>"Assets","l1"=>"Fixed Assets",'l2'=>"Long Term Assets",'bal'=>number_format($total_fixed_assets)));

        //get all depreciations
        $total_dep=0;
        foreach ($depreciations as $depreciation){
            $total_dep+=$depreciation['dep'];
        }
        if ($total_dep==0){
            array_push($assets_decoded,
                array("base"=>"Assets","l1"=>"Fixed Assets",'l2'=>"Less Depreciation",'bal'=>number_format($total_dep)));
        }
        else{
            array_push($assets_decoded,
                array("base"=>"Assets","l1"=>"Fixed Assets",'l2'=>"Less Depreciation",'bal'=>number_format(-1*$total_dep)));
        }
        //get banks
        $total_banks=0;
        foreach ($banks_encoded as $bank){
            $total_banks+=$bank['bal'];
        }


        //get all current assets
        $total_inventory=0;
        $total_accounts_receivable=0;
        $total_investments=0;
        $total_others=0;
        foreach ($current_assets_encoded as $item){
            //get inventory
            if ($item['l2']==39) {
                $total_inventory+=$item['bal'];
            }
            //get accounts receivable
            if ($item['l2']==30 ){
                $total_accounts_receivable+=$item['bal'];
            }
            //get other
            if ($item['l2']==3){
                $total_others+=$item['bal'];
            }
            //get other investments
            if ($item['l2']==2){
                $total_investments+=$item['bal'];
            }
        }

        foreach ($banks_encoded as $item){
            if ($item['bal']!=0)
            array_push($assets_decoded,
                array("base"=>"Assets","l1"=>"Current Assets",'l2'=>$item['acc'],'bal'=>number_format($item['bal'])));
        }
        //array_push($assets_decoded,
          //  array("base"=>"Assets","l1"=>"Current Assets",'l2'=>"Bank and Cash",'bal'=>number_format($total_banks)));
        
        array_push($assets_decoded,
            array("base"=>"Assets","l1"=>"Current Assets",'l2'=>"Inventory",'bal'=>number_format($total_inventory)));
        array_push($assets_decoded,
            array("base"=>"Assets","l1"=>"Current Assets",'l2'=>"Accounts Receivable",'bal'=>number_format($total_accounts_receivable)));
        array_push($assets_decoded,
            array("base"=>"Assets","l1"=>"Current Assets",'l2'=>"Investments",'bal'=>number_format($total_investments)));
        array_push($assets_decoded,
            array("base"=>"Assets","l1"=>"Current Assets",'l2'=>"Others",'bal'=>number_format($total_others)));

        //var_dump($assets_decoded);exit;
        return $assets_decoded;
    }
    function getTotalAssets($id,$start_date,$end_date){
        $assets=$this->populateAssets($id,$start_date,$end_date);
        $total_assets=0;
        foreach ($assets as $asset) {
            $total_assets+=$this->number_unformat($asset['bal']);
        }
        return number_format($total_assets);
    }

    function populateLiabilities($id,$start_date,$end_date){
        $liabilityObj=new ReportLiability();
        $current_liablities_encoded=$liabilityObj->getCurrentLiabilities($id,$start_date,$end_date);
        $noncurrent_liablities_encoded=$liabilityObj->getNonCurrentLiabilities($id,$start_date,$end_date);

        $liabilities_decoded=array();

        $total_accounts_payable=0;
        $total_current_bank_debts=0;
        $total_current_debts=0;
        foreach ($current_liablities_encoded as $item){
            //get accounts payable
            if ($item['l2']==31) {
                $total_accounts_payable+=$item['bal'];
            }
            //get current bank debts
            if ($item['l2']==6 ){
                $total_current_bank_debts+=$item['bal'];
            }
            //get current debts
            if ($item['l2']==7){
                $total_current_debts+=$item['bal'];
            }
        }
        array_push($liabilities_decoded,
            array("base"=>"Liabilities","l1"=>"Current Liabilities",'l2'=>"Accounts Payable",'bal'=>number_format($total_accounts_payable)));
        array_push($liabilities_decoded,
            array("base"=>"Liabilities","l1"=>"Current Liabilities",'l2'=>"Current Debt",'bal'=>number_format($total_current_debts)));
        array_push($liabilities_decoded,
            array("base"=>"Liabilities","l1"=>"Current Liabilities",'l2'=>"Current Bank Debt",'bal'=>number_format($total_current_bank_debts)));

        $total_long_term_debts=0;
        foreach ($noncurrent_liablities_encoded as $item){
            //get long term debts
            if ($item['l2']==8) {
                $total_long_term_debts+=$item['bal'];
            }
        }
        array_push($liabilities_decoded,
            array("base"=>"Liabilities","l1"=>"Long Term Liabilities",'l2'=>"Long Term Debt",'bal'=>number_format($total_long_term_debts)));

        return $liabilities_decoded;
    }
    function getTotalLiabilities($id,$start_date,$end_date){
        $liabilities=$this->populateLiabilities($id,$start_date,$end_date);
        $total_liabilities=0;
        foreach ($liabilities as $liability) {
            $total_liabilities+=$this->number_unformat($liability['bal']);
        }
        return number_format($total_liabilities);
    }
    function getEquity($id,$start_date,$end_date){
        $total_liabilities=$this->number_unformat($this->getTotalLiabilities($id,$start_date,$end_date));
        $total_assets=$this->number_unformat($this->getTotalAssets($id,$start_date,$end_date));
        $equity=$total_assets-$total_liabilities;
        return number_format($equity);
    }
    /*balance sheet end*/

    /*income statement begin*/
    function getSalesRevenue($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $current_assets=Yii::app()->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.
            '"and level_two_id=\'39\'')
            ->queryAll();

        $all_revenues=array();
        foreach ($current_assets as $item){
            $item_and_details=Yii::app()->db->createCommand
            ('select * from accounts where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            foreach ($item_and_details as $item_and_detail){
                array_push($all_revenues,array('bal'=>$item_and_detail['credit']*$item_and_detail['rate']));
            }
        }
        return $all_revenues;
    }
    function getOtherRevenues($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $income_accounts=Yii::app()->db->createCommand
        ('select * from org_chart where main_acc_id=\'4\' and org_id="'.$id.'"')
            ->queryAll();
        $incomes_and_categories=array();
        foreach ($income_accounts as $income_account){
            $incomes=Yii::app()->db->createCommand
            ('select * from accounts where account_id="'.$income_account['id'].'"'.$betweenSection)
                ->queryAll();
            $balance=0;
            foreach ($incomes as $income){
                if ($income['rate']==null)
                    $rate=1;
                else
                    $rate=$income['rate'];
                if ($income['debit']==null)
                    $balance=$balance+($income['credit']*$rate);
                if ($income['credit']==null)
                    $balance=$balance-($income['debit']*$rate);
                else
                    $balance=($income['credit']-$income['debit'])*$rate;
                array_push($incomes_and_categories,array('level_one_id'=>$income_account['level_one_id'],'bal'=>$balance));
            }
        }
        return $incomes_and_categories;
    }
    function populateRevenue($id,$start_date,$end_date){
        $sales_revenues=$this->getSalesRevenue($id,$start_date,$end_date);
        $other_revenues=$this->getOtherRevenues($id,$start_date,$end_date);
        $revenues=array();

        $total_sales_revenue=0;
        foreach ($sales_revenues as $revenue){
            $total_sales_revenue+=$revenue['bal'];
        }
        array_push($revenues,array('base'=>'Revenue','l2'=>'Sales revenue','bal'=>number_format($total_sales_revenue)));

        $total_other_sales=0;
        $total_commissions=0;
        $total_fees_and_charges=0;
        $total_investments=0;
        $total_non_profit=0;
        $total_other_income=0;
        $total_professional_services=0;
        $total_agriculture=0;
        foreach ($other_revenues as $revenue){
            /*if ($revenue['level_one_id']==6){
                $total_other_sales+=$revenue['bal'];
            }*/
            if ($revenue['level_one_id']==7){
                $total_commissions+=$revenue['bal'];
            }
            if ($revenue['level_one_id']==8){
                $total_fees_and_charges+=$revenue['bal'];
            }
            if ($revenue['level_one_id']==9){
                $total_investments+=$revenue['bal'];
            }
            if ($revenue['level_one_id']==10){
                $total_non_profit+=$revenue['bal'];
            }
            if ($revenue['level_one_id']==11){
                $total_other_income+=$revenue['bal'];
            }
            if ($revenue['level_one_id']==12){
                $total_professional_services+=$revenue['bal'];
            }
            if ($revenue['level_one_id']==17){
                $total_agriculture+=$revenue['bal'];
            }
        }
        //array_push($revenues,array('base'=>'','l2'=>'Additional Sales','bal'=>number_format($total_other_sales)));
        array_push($revenues,array('base'=>'','l2'=>'Commissions','bal'=>number_format($total_commissions)));
        array_push($revenues,array('base'=>'','l2'=>'Fees and Charges','bal'=>number_format($total_fees_and_charges)));
        array_push($revenues,array('base'=>'','l2'=>'Investments','bal'=>number_format($total_investments)));
        array_push($revenues,array('base'=>'','l2'=>'Non Profit Income','bal'=>number_format($total_non_profit)));
        array_push($revenues,array('base'=>'','l2'=>'Other Incomes','bal'=>number_format($total_other_income)));
        array_push($revenues,array('base'=>'','l2'=>'Professional Services','bal'=>number_format($total_professional_services)));
        array_push($revenues,array('base'=>'','l2'=>'Agricultural Income','bal'=>number_format($total_agriculture)));

        return $revenues;

    }
    function getTotalRevenue($id,$start_date,$end_date){
        $revenues=$this->populateRevenue($id,$start_date,$end_date);
        $tot=0;
        foreach ($revenues as $revenue){
            $tot+=$this->number_unformat($revenue['bal']);
        }

        return number_format($tot);
    }
    function getCostOfGoodsSold($id,$start_date,$end_date){
        $betweenSection="";
        if($start_date!=null && $end_date!=null){
            $betweenSection=" and (date between ' ". $start_date ."' and '". $end_date."')";
        }
        $current_assets=Yii::app()->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.
            '"and level_two_id=\'39\'')
            ->queryAll();

        $all_purchases=0;
        foreach ($current_assets as $item){
            $item_and_details=Yii::app()->db->createCommand
            ('select * from accounts where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();
            foreach ($item_and_details as $item_and_detail){
                $all_purchases+=$item_and_detail['debit']*$item_and_detail['rate'];
            }
        }
        return $all_purchases;
    }

    function getOpeningInventory($id,$start_date){
        $betweenSection=" and (date between ' ". $this->getOldestDateInAccounts($id) ."' and '". $start_date."')";
        $current_assets=Yii::app()->db->createCommand
        ('select * from org_chart where main_acc_id=\'1\' and level_one_id=\'2\' and org_id="'.$id.
            '"and level_two_id=\'39\'')
            ->queryAll();

        $opening_inventory=0;
        foreach ($current_assets as $item){
            $item_and_details=Yii::app()->db->createCommand
            ('select * from accounts where account_id="'.$item['id'].'"'.$betweenSection)
                ->queryAll();

            foreach ($item_and_details as $item_and_detail){
                $opening_inventory+=($item_and_detail['debit']-$item_and_detail['credit'])*$item_and_detail['rate'];
            }
        }
        return $opening_inventory;
    }
    function getClosingStock($id,$start_date,$end_date){
        $inventoryObj=new ReportInventory();
        $stocks=$inventoryObj->getTotalInventory($id,$start_date,$end_date);
        $total_inventory=0;
        foreach ($stocks as $stock){
            //get total inventory
            $total_inventory+=$stock['bal'];
        }
        return $total_inventory;
    }
    function populateCostOfGoods($id,$start_date,$end_date){
        $purchases=$this->getCostOfGoodsSold($id,$start_date,$end_date);
        $closing_stock=$this->getClosingStock($id,$start_date,$end_date);
        $opening_inventory=$this->getOpeningInventory($id,$start_date);

        $cost_of_goods_sold=array();
        array_push($cost_of_goods_sold,
            array("base"=>"Cost Of Goods Sold","l1"=>"Opening Inventory",'bal'=>number_format($opening_inventory)));
        array_push($cost_of_goods_sold,
            array("base"=>"","l1"=>"Add Purchases",'bal'=>number_format($purchases)));
        array_push($cost_of_goods_sold,
            array("base"=>"","l1"=>"Less Closing Stock",'bal'=>number_format($closing_stock)));


        return $cost_of_goods_sold;
    }
    function getTotalCostOfGoodsSold($id,$start_date,$end_date){
        $results=$this->populateCostOfGoods($id,$start_date,$end_date);
        $total_cost_of_goods_sold=0;
        $total_cost_of_goods_sold+=($this->number_unformat($results[0]['bal'])
                +$this->number_unformat($results[1]['bal']))-
            $this->number_unformat($results[2]['bal']);

        return number_format($total_cost_of_goods_sold);
    }
    function getGrossProfit($id,$start_date,$end_date){
        $revenue=$this->number_unformat($this->getTotalRevenue($id,$start_date,$end_date));
        $expenses=$this->number_unformat($this->getTotalCostOfGoodsSold($id,$start_date,$end_date));
        $gross_profit=$revenue-$expenses;
        return number_format($gross_profit);
    }
    function populateExpenses($id,$start_date,$end_date)
    {
        $expenseObj=new ReportCostAccounting();
        $assetObj = new ReportAssets();
        $expenses=$expenseObj->getExpensesByCategory($id,$start_date,$end_date);
        $expenses_and_balances=array();
        $count=0;
        foreach ($expenses as $expense){
            if ($expense['bal']!=0){
                if ($count==0)
                    array_push($expenses_and_balances,array('base'=>"Expenses",'acc'=>$expense['acc'],'bal'=>number_format($expense['bal'])));
                else
                    array_push($expenses_and_balances,array('base'=>"",'acc'=>$expense['acc'],'bal'=>number_format($expense['bal'])));
                $count++;
            }

        }
        $petty_cash_expenses = $assetObj->getPettyCash($id,$start_date,$end_date);
        foreach ($petty_cash_expenses as $expense)
        {
            array_push($expenses_and_balances,array('base'=>"",'acc'=>$expense['acc'],'bal'=>number_format($expense['bal'])));
        }

        return $expenses_and_balances;
    }
    function getTotalExpenses($id,$start_date,$end_date){
        $expenses=$this->populateExpenses($id,$start_date,$end_date);
        $total_expenses=0;
        foreach ($expenses as $expense){
            $total_expenses+=$this->number_unformat($expense['bal']);
        }
        return number_format($total_expenses);
    }
    function getNetProfit($id,$start_date,$end_date){
        $gross_profit=$this->number_unformat($this->getGrossProfit($id,$start_date,$end_date));
        $expenses=$this->number_unformat($this->getTotalExpenses($id,$start_date,$end_date));
        $net_profit=$gross_profit-$expenses;
        return number_format($net_profit);
    }
    /*end of income statement*/
    /*start of cash flow*/
    function populateCashFlowFromOperations($id,$start_date,$end_date){
        $net_income=$this->getNetProfit($id,$start_date,$end_date);

        $assetObj=new ReportAssets();
        $depreciations=$assetObj->getFixedAssetsDepreciation($id,$start_date,$end_date);
        $depreciations_prv=$assetObj->getFixedAssetsDepreciation($id,$this->getOldestDateInAccounts($id),$start_date);


        $current_assets_encoded=$assetObj->getCurrentAssets($id,$start_date,$end_date);
        $current_assets_encoded_prv=$assetObj->getCurrentAssets($id,$this->getOldestDateInAccounts($id),$start_date);

        $liabilityObj=new ReportLiability();
        $current_liablities_encoded=$liabilityObj->getCurrentLiabilities($id,$start_date,$end_date);
        $current_liablities_encoded_prv=$liabilityObj->getCurrentLiabilities($id,$this->getOldestDateInAccounts($id),$start_date);

        //get depreciation
        //depreciation for specified period
        $depreciation_now=0;
        foreach ($depreciations as $depreciation){
            $depreciation_now+=$depreciation['dep'];
        }
        //depreciation for previous period
        $depreciation_then=0;
        foreach ($depreciations_prv as $depreciation){
            $depreciation_then+=$depreciation['dep'];
        }

        //get accounts receivable,inventory for specified period
        $accounts_receivable_now=0;
        $inventory_now=0;
        $others_now=0;
        foreach ($current_assets_encoded as $item){
            //get A/R
            if ($item['l2']==30 ){
                $accounts_receivable_now+=$item['bal'];
            }
            //get inventory
            if ($item['l2']==39) {
                $inventory_now+=$item['bal'];
            }
            if ($item['l2']==3){
                $others_now+=$item['bal'];
            }
        }
        //get accounts receivable,inventory for previous period
        $accounts_receivable_then=0;
        $inventory_then=0;
        $others_then=0;
        foreach ($current_assets_encoded_prv as $item){
            //get A/R
            if ($item['l2']==30 ){
                $accounts_receivable_then+=$item['bal'];
            }
            //get inventory
            if ($item['l2']==39) {
                $inventory_then+=$item['bal'];
            }
            if ($item['l2']==3){
                $others_then+=$item['bal'];
            }
        }

        //get accounts payable for specified period
        $accounts_payable_now=0;
        foreach ($current_liablities_encoded as $item){
            //get accounts payable
            if ($item['l2']==31) {
                $accounts_payable_now+=$item['bal'];
            }
        }

        //get accounts payable for previous period
        $accounts_payable_then=0;
        foreach ($current_liablities_encoded_prv as $item){
            //get accounts payable
            if ($item['l2']==31) {
                $accounts_payable_then+=$item['bal'];
            }
        }
        $dep_increase=$depreciation_now-$depreciation_then;
        $ar_increase=$accounts_receivable_then-$accounts_receivable_now;
        $inv_decrease=$inventory_then-$inventory_now;
        $ap_decrease=$accounts_payable_then-$accounts_payable_now;
        $sales_tax=$others_then-$others_now;

        $cashflow_po_costs=array();
        array_push($cashflow_po_costs,array('l1'=>"Cash Flow From Operations",'l2'=>"Net Income",'bal'=>$net_income));
        array_push($cashflow_po_costs,array('l1'=>"",'l2'=>"Depreciation",'bal'=>number_format($dep_increase)));
        array_push($cashflow_po_costs,array('l1'=>"",'l2'=>"Accounts Receivable Increase",'bal'=>number_format($ar_increase)));
        array_push($cashflow_po_costs,array('l1'=>"",'l2'=>"Inventory Decrease",'bal'=>number_format($inv_decrease)));
        array_push($cashflow_po_costs,array('l1'=>"",'l2'=>"Accounts Payable Decrease",'bal'=>number_format($ap_decrease)));
        //array_push($cashflow_po_costs,array('l1'=>"",'l2'=>"Sales Tax Receivable",'bal'=>$sales_tax));
        return $cashflow_po_costs;
    }
    function getNetCashFlowFromOperations($id,$start_date,$end_date){
        $results=$this->populateCashFlowFromOperations($id,$start_date,$end_date);
        $total=0;
        foreach ($results as $result){
            $total+=$this->number_unformat($result['bal']);
        }
        return number_format($total);
    }
    function populateCashFlowFromInvestments($id,$start_date,$end_date){
        $assetObj=new ReportAssets();
        $fixed_assets_pr=$assetObj->getFixedAssets($id,$this->getOldestDateInAccounts($id),$start_date);
        $depreciation_fixed_assets_pr=$assetObj->getFixedAssetsDepreciation($id,$this->getOldestDateInAccounts($id),$start_date);

        $total_fixed_assets_pr=0;
        foreach ($fixed_assets_pr as $item){
            $total_fixed_assets_pr+=$item['cost'];
        }
        $total_depreciation_fixed_assets_pr=0;
        foreach ($depreciation_fixed_assets_pr as $item){
            $total_depreciation_fixed_assets_pr+=$item['dep'];
        }
        $net_fixed_asset_pr=$total_fixed_assets_pr-$total_depreciation_fixed_assets_pr;

        $fixed_assets=$assetObj->getFixedAssets($id,$start_date,$end_date);
        $depreciation_fixed_assets=$assetObj->getFixedAssetsDepreciation($id,$start_date,$end_date);

        $total_fixed_assets=0;
        foreach ($fixed_assets as $item){
            $total_fixed_assets+=$item['cost'];
        }
        $total_depreciation_fixed_assets=0;
        foreach ($depreciation_fixed_assets as $item){
            $total_depreciation_fixed_assets+=$item['dep'];
        }
        $net_fixed_asset=$total_fixed_assets-$total_depreciation_fixed_assets;

        $cash_flow_from_investing=$net_fixed_asset_pr-$net_fixed_asset;
        $cash_flow_from_investing_array=array();

        array_push($cash_flow_from_investing_array,array('l1'=>"Cash Flow From Investments",'l2'=>"Equipment/Fixed Asset Purchase",'bal'=>number_format($cash_flow_from_investing)));

        return $cash_flow_from_investing_array;
    }
    function getNetCashFlowFromInvestments($id,$start_date,$end_date){
        $results=$this->populateCashFlowFromInvestments($id,$start_date,$end_date);
        $tot=0;
        foreach ($results as $result){
            $tot=$this->number_unformat($result['bal']);
        }
        return number_format($tot);
    }
    function populateCashFlowFromFinancing($id,$start_date,$end_date){
        $liabilityObj=new ReportLiability();
        $current_liablities_encoded=$liabilityObj->getCurrentLiabilities($id,$start_date,$end_date);
        $current_liablities_encoded_pr=$liabilityObj->getCurrentLiabilities($id,$this->getOldestDateInAccounts($id),$start_date);

        //get finances from current period
        $total_current_bank_debts=0;
        $total_current_debts=0;
        foreach ($current_liablities_encoded as $item){
            //get current bank debts
            if ($item['l2']==6 ){
                $total_current_bank_debts+=$item['bal'];
            }
            //get current debts
            if ($item['l2']==7){
                $total_current_debts+=$item['bal'];
            }
        }

        //get finances from previous period
        $total_current_bank_debts_pr=0;
        $total_current_debts_pr=0;
        foreach ($current_liablities_encoded_pr as $item){
            //get current bank debts
            if ($item['l2']==6 ){
                $total_current_bank_debts_pr+=$item['bal'];
            }
            //get current debts
            if ($item['l2']==7){
                $total_current_debts_pr+=$item['bal'];
            }
        }
        $net_bank_debt=$total_current_bank_debts_pr-$total_current_bank_debts;
        $net_other_debt=$total_current_debts_pr-$total_current_debts;
        $cash_flow_from_financing_array=array();
        array_push($cash_flow_from_financing_array,array('l1'=>"Cash Flow From Financing",'l2'=>"Bank Loans",'bal'=>number_format($net_bank_debt)));
        array_push($cash_flow_from_financing_array,array('l1'=>"",'l2'=>"Other Loans",'bal'=>number_format($net_other_debt)));

        return $cash_flow_from_financing_array;
    }
    function getNetCashFlowFromFinancing($id,$start_date,$end_date){
        $results=$this->populateCashFlowFromFinancing($id,$start_date,$end_date);
        $tot=0;
        foreach ($results as $result){
            $tot+=$this->number_unformat($result['bal']);
        }
        return number_format($tot);
    }
    function getNetIncreaseDecreaseInCash($id,$start_date,$end_date){
        $ops=$this->number_unformat($this->getNetCashFlowFromOperations($id,$start_date,$end_date));
        $invs=$this->number_unformat($this->getNetCashFlowFromInvestments($id,$start_date,$end_date));
        $fins=$this->number_unformat($this->getNetCashFlowFromFinancing($id,$start_date,$end_date));

        $net_cash=$ops+$invs+$fins;
        return number_format($net_cash);
    }
    function getCashForPreviousPeriod($id,$start_date){
        $assetObj=new ReportAssets();
        $banks_encoded=$assetObj->getBanks($id,$this->getOldestDateInAccounts($id),$start_date);
        //get banks
        $total_banks=0;
        foreach ($banks_encoded as $bank){
            $total_banks+=$bank['bal'];
        }
        return number_format($total_banks);
    }
    function getCashForPeriod($id,$start_date,$end_date){
        $cash_previous_period=$this->getCashForPreviousPeriod($id,$start_date);
        $variance=$this->getNetIncreaseDecreaseInCash($id,$start_date,$end_date);
        $cash=$this->number_unformat($variance)+$this->number_unformat($cash_previous_period);
        return number_format($cash);

    }
}