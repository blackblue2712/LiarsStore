<aside class="right-side">
    <section class="content-header">
        <h1>
            Analytics
            <small>sales revenue - month</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Analytics</li>
        </ol>
    </section>
    <?php
    //TOTAL
        
        if(!empty($this->allTotalAmount)){
            $total = 0;
            foreach($this->allTotalAmount as $key => $value){
                $arr_tmp = json_decode($value["prices"]);
                foreach($arr_tmp as $keyP => $valueP){
                    $total += $valueP/1000000;
                }
            }
        }
        //DAY
        $totalDay = 0;
        $percentTotalPerDay = 0;
        $today      = date('Y-m-d', time()) ;
        $strToday   = date('d-m', time()) ;
        foreach($this->allTotalAmount as $key => $value){
            $dayInDb    = date("Y-m-d", strtotime($value["date"]));
            if($today == $dayInDb){
                $arr_tmp = json_decode($value["prices"]);
                foreach($arr_tmp as $keyP => $valueP){
                    $totalDay += $valueP/1000000;
                }
            }
        }
        $percentTotalPerDay = $totalDay*100/$total;
        $percentTotalPerDay = round($percentTotalPerDay, 2);

        //WEEK
        $totalWeek = 0;
        $startdate      = strtotime("Monday");
        if($startdate > time()) $startdate -= 86400*7;
        $strStartdate   = date("d-m", $startdate);
        $enddate        = strtotime("Sunday");
        $strEnddate     = date("d-m", $enddate+86399);
        foreach($this->allTotalAmount as $key => $value){
            $dayInDb        = strtotime($value["date"]);
            if($dayInDb >= $startdate && $dayInDb <= ($enddate+86399)){
                $arr_tmp = json_decode($value["prices"]);
                foreach($arr_tmp as $keyP => $valueP){
                    $totalWeek += $valueP/1000000;
                }
            }
        }
        $percentTotalPerWeek = $totalWeek*100/$total;
        $percentTotalPerWeek = round($percentTotalPerWeek, 2);

        //MONTH
        $totalMonth     = 0;
        $monthCurrent   = date("m", time());
        $yearCurrent    = date("Y", time());
        $dayMaxInMonth  = cal_days_in_month(CAL_GREGORIAN, $monthCurrent, $yearCurrent);
        $startDayInMonth= mktime(0, 0, 0, $monthCurrent, 1, $yearCurrent);
        $endtDayInMonth = mktime(0, 0, 0, $monthCurrent, $dayMaxInMonth, $yearCurrent) + 86399;
        foreach($this->allTotalAmount as $key => $value){
            $dayInDb        = strtotime($value["date"]);
            if($dayInDb >= $startDayInMonth && $dayInDb <= ($endtDayInMonth)){
                $arr_tmp = json_decode($value["prices"]);
                foreach($arr_tmp as $keyP => $valueP){
                    $totalMonth += $valueP/1000000;
                }
            }
        }
        $percentTotalPerMonth = $totalMonth*100/$total;
        $percentTotalPerMonth = round($percentTotalPerMonth, 2);

        //ALL MONTH
        $totalMonth1    = 0;
        $totalMonth2    = 0;
        $totalMonth3    = 0;
        $totalMonth4    = 0;
        $totalMonth5    = 0;
        $totalMonth6    = 0;
        $totalMonth7    = 0;
        $totalMonth8    = 0;
        $totalMonth9    = 0;
        $totalMonth10   = 0;
        $totalMonth11   = 0;
        $totalMonth12   = 0;
        $percentTotalPerMonth1 = 0;
        $percentTotalPerMonth2 = 0;
        $percentTotalPerMonth3 = 0;
        $percentTotalPerMonth4 = 0;
        $percentTotalPerMonth5 = 0;
        $percentTotalPerMonth6 = 0;
        $percentTotalPerMonth7 = 0;
        $percentTotalPerMonth8 = 0;
        $percentTotalPerMonth9 = 0;
        $percentTotalPerMonth10 = 0;
        $percentTotalPerMonth11 = 0;
        $percentTotalPerMonth12 = 0;
        foreach($this->allTotalAmount as $key => $value){
            $dayInDb        = strtotime($value["date"]);
            if( date("Y", $dayInDb) == $yearCurrent ){
                $arr_tmp = json_decode($value["prices"]);
                switch( date("m", $dayInDb) ){
                    case 01: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth1 += $valueP/1000000;
                        }
                        $percentTotalPerMonth1 = $totalMonth1*100/$total;
                        $percentTotalPerMonth1 = round($percentTotalPerMonth1, 2);
                    break;
                    case 02: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth2 += $valueP/1000000;
                        }
                        $percentTotalPerMonth2 = $totalMonth2*100/$total;
                        $percentTotalPerMonth2 = round($percentTotalPerMonth2, 2);
                    break;
                    case 03: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth3 += $valueP/1000000;
                        }
                        $percentTotalPerMonth3 = $totalMonth3*100/$total;
                        $percentTotalPerMonth3 = round($percentTotalPerMonth3, 2);
                    break;
                    case 04: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth4 += $valueP/1000000;
                        }
                        $percentTotalPerMonth4 = $totalMonth4*100/$total;
                        $percentTotalPerMonth4 = round($percentTotalPerMonth4, 2);
                    break;
                    case 05: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth5 += $valueP/1000000;
                        }
                        $percentTotalPerMonth5 = $totalMonth5*100/$total;
                        $percentTotalPerMonth5 = round($percentTotalPerMonth5, 2);
                    break;
                    case 06: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth6 += $valueP/1000000;
                        }
                        $percentTotalPerMonth6 = $totalMonth6*100/$total;
                        $percentTotalPerMonth6 = round($percentTotalPerMonth6, 2);
                    break;
                    case 07: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth7 += $valueP/1000000;
                        }
                        $percentTotalPerMonth7 = $totalMonth7*100/$total;
                        $percentTotalPerMonth7 = round($percentTotalPerMonth7, 2);
                    break;
                    case 8:
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth8 += $valueP/1000000;
                        }
                        $percentTotalPerMonth8 = $totalMonth8*100/$total;
                        $percentTotalPerMonth8 = round($percentTotalPerMonth8, 2);
                    break;
                    case 9: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth9 += $valueP/1000000;
                        }
                        $percentTotalPerMonth9 = $totalMonth9*100/$total;
                        $percentTotalPerMonth9 = round($percentTotalPerMonth9, 2);
                    break;
                    case 10: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth10 += $valueP/1000000;
                        }
                        $percentTotalPerMonth10 = $totalMonth1*100/$total;
                        $percentTotalPerMonth10 = round($percentTotalPerMonth10, 2);
                    break;
                    case 11: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth11 += $valueP/1000000;
                        }
                        $percentTotalPerMonth11 = $totalMonth11*100/$total;
                        $percentTotalPerMonth11 = round($percentTotalPerMonth11, 2);
                    break;
                    case 12: 
                        foreach($arr_tmp as $keyP => $valueP){
                            $totalMonth12 += $valueP/1000000;
                        }
                        $percentTotalPerMonth12 = $totalMonth12*100/$total;
                        $percentTotalPerMonth12 = round($percentTotalPerMonth12, 2);
                    break;
                }
            }
            
        }

    ?>
    <div class="col-md-12" style="margin-top: 30px;">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div id="chartContainer" style="height: 600px; width: 100%;"></div>
        </div>
    </div>
    

</aside>
<script type="text/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "dark2",
            title:{
                text: "Sales Revenue"              
            },
            axisY: {
                prefix      : "%",
            },
            data: [              
            {
                // Change type to "doughnut", "line", "splineArea", etc.
                type: "line",
                percentFormatString: "#0.##",
                toolTipContent: "{y} (%)",
                
                dataPoints: [
                    { label: "Total", y: 100, indexLabel: "<?php echo round($total,2) ?>M"},
                    { label: "Jan", y: <?php echo $percentTotalPerMonth1 ?>, indexLabel: "<?php echo round($totalMonth1,2) ?>M"},
                    { label: "Feb", y: <?php echo $percentTotalPerMonth2 ?>, indexLabel: "<?php echo round($totalMonth2,2) ?>M"},
                    { label: "Mar", y: <?php echo $percentTotalPerMonth3 ?>, indexLabel: "<?php echo round($totalMonth3,2) ?>M"},
                    { label: "Apr", y: <?php echo $percentTotalPerMonth4 ?>, indexLabel: "<?php echo round($totalMonth4,2) ?>M"},
                    { label: "May", y: <?php echo $percentTotalPerMonth5 ?>, indexLabel: "<?php echo round($totalMonth5,2) ?>M"},
                    { label: "Jun", y: <?php echo $percentTotalPerMonth6 ?>, indexLabel: "<?php echo round($totalMonth6,2) ?>M"},
                    { label: "Jul", y: <?php echo $percentTotalPerMonth7 ?>, indexLabel: "<?php echo round($totalMonth7,2) ?>M"},
                    { label: "Aug", y: <?php echo $percentTotalPerMonth8 ?>, indexLabel: "<?php echo round($totalMonth8,2) ?>M"},
                    { label: "Sep", y: <?php echo $percentTotalPerMonth9 ?>, indexLabel: "<?php echo round($totalMonth9,2) ?>M"},
                    { label: "Oct", y: <?php echo $percentTotalPerMonth10 ?>, indexLabel: "<?php echo round($totalMonth10,2) ?>M"},
                    { label: "Nov", y: <?php echo $percentTotalPerMonth11 ?>, indexLabel: "<?php echo round($totalMonth11,2) ?>M"},
                    { label: "Dec", y: <?php echo $percentTotalPerMonth12 ?>, indexLabel: "<?php echo round($totalMonth12,2) ?>M"},
                ]
            },
            ]
        });
        chart.render();
    }
</script>