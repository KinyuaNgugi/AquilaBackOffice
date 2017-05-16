<?php
use app\models\Partnercodeuse;
use yii\widgets\ActiveForm;
use \app\models\OrgChart;
use yii\grid\GridView;
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?=Yii::$app->homeUrl;?>accounts/index">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Reports</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Debtor Reports</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN DASHBOARD STATS 1-->
        <div class="">
            <div class="partner-tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">Total Debt Report<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">Debt Reports By Client<span class="badge badge-danger"></span></a>
                    </li>
                    <li role="presentation">
                        <a href="#tab3" aria-controls="home" role="tab" data-toggle="tab">Ageing Analysis For Debtors<span class="badge badge-danger"></span></a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab5" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab6" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab7" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab5">
                                <?php echo \app\models\ReportDebtor::buildTotalDebtorsChart(2,null,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab6">
                                <?php echo \app\models\ReportDebtor::buildTotalDebtsTable(2,null,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab7">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab8" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab9" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab10" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab8">
                                <?php echo \miloschuman\highcharts\Highcharts::widget([
                                    'scripts' => [
                                        'highcharts-3d',
                                        'modules/drilldown',
                                        'modules/exporting',
                                        'themes/sand-signika',
                                    ],
                                    'options' => [
                                        "chart" => [
                                            "type" => "pie",
                                            "options3d" => [
                                                "enabled" => true,
                                                "alpha" => 45
                                            ]
                                        ],
                                        "title" => [
                                            "text" => "Browser market shares. January, 2015 to May, 2015"
                                        ],
                                        "subtitle" => [
                                            "text" => "Click the slices to view versions. Source: netmarketshare.com."
                                        ],
                                        "plotOptions" => [
                                            "pie" => [
                                                "innerSize" => 100,
                                                "depth" => 45
                                            ],
                                            "series" => [
                                                "dataLabels" => [
                                                    "enabled" => true,
                                                    "format" => "{point.name}: {point.y:.1f}%"
                                                ]
                                            ]
                                        ],
                                        "series" => [
                                            [
                                                "name" => "Brands",
                                                "colorByPoint" => true,
                                                "data" => [
                                                    [
                                                        "name" => "Microsoft Internet Explorer",
                                                        "y" => 56.33,
                                                        "drilldown" => "Microsoft Internet Explorer"
                                                    ],
                                                    [
                                                        "name" => "Chrome",
                                                        "y" => 24.03,
                                                        "drilldown" => "Chrome"
                                                    ],
                                                    [
                                                        "name" => "Firefox",
                                                        "y" => 10.38,
                                                        "drilldown" => "Firefox"
                                                    ],
                                                    [
                                                        "name" => "Safari",
                                                        "y" => 4.77,
                                                        "drilldown" => "Safari"
                                                    ],
                                                    [
                                                        "name" => "Opera",
                                                        "y" => 0.91,
                                                        "drilldown" => "Opera"
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "drilldown" => [
                                            "series" => [
                                                [
                                                    "name" => "Microsoft Internet Explorer",
                                                    "id" => "Microsoft Internet Explorer",
                                                    "data" => [
                                                        ["v11.0", 24.13],
                                                        ["v8.0", 17.2],
                                                        ["v9.0", 8.11],
                                                        ["v10.0", 5.33],
                                                        ["v6.0", 1.06],
                                                        ["v7.0", 0.5]
                                                    ]
                                                ],
                                                [
                                                    "name" => "Chrome",
                                                    "id" => "Chrome",
                                                    "data" => [
                                                        ["v40.0", 5],
                                                        ["v41.0", 4.32],
                                                        ["v42.0", 3.68],
                                                        ["v39.0", 2.96],
                                                        ["v36.0", 2.53],
                                                        ["v43.0", 1.45],
                                                        ["v31.0", 1.24],
                                                        ["v35.0", 0.85],
                                                        ["v38.0", 0.6],
                                                        ["v32.0", 0.55],
                                                        ["v37.0", 0.38],
                                                        ["v33.0", 0.19],
                                                        ["v34.0", 0.14],
                                                        ["v30.0", 0.14]
                                                    ]
                                                ],
                                                [
                                                    "name" => "Firefox",
                                                    "id" => "Firefox",
                                                    "data" => [
                                                        ["v35", 2.76],
                                                        ["v36", 2.32],
                                                        ["v37", 2.31],
                                                        ["v34", 1.27],
                                                        ["v38", 1.02],
                                                        ["v31", 0.33],
                                                        ["v33", 0.22],
                                                        ["v32", 0.15]
                                                    ]
                                                ],
                                                [
                                                    "name" => "Safari",
                                                    "id" => "Safari",
                                                    "data" => [
                                                        ["v8.0", 2.56],
                                                        ["v7.1", 0.77],
                                                        ["v5.1", 0.42],
                                                        ["v5.0", 0.3],
                                                        ["v6.1", 0.29],
                                                        ["v7.0", 0.26],
                                                        ["v6.2", 0.17]
                                                    ]
                                                ],
                                                [
                                                    "name" => "Opera",
                                                    "id" => "Opera",
                                                    "data" => [
                                                        ["v12.x", 0.34],
                                                        ["v28", 0.24],
                                                        ["v27", 0.17],
                                                        ["v29", 0.16]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]]);?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab9">
                                <?php echo \app\models\ReportCosts::buildCostByProductTable(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab10">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab11" aria-controls="home" role="tab" data-toggle="tab">Chart<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab12" aria-controls="home" role="tab" data-toggle="tab">Table<span class="badge badge-danger"></span></a>
                            </li>
                            <li role="presentation">
                                <a href="#tab13" aria-controls="home" role="tab" data-toggle="tab">Download<span class="badge badge-danger"></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab11">
                                <?php echo \app\models\ReportCosts::buildCostBySupplierChart(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab12">
                                <?php echo \app\models\ReportCosts::buildCostBySupplierTable(2,null,null)?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab13">
                                <button onclick="" type="button" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- END CONTENT BODY -->
</div>