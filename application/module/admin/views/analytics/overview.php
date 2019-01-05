<aside class="right-side">
    <section class="content-header">
        <h1>
            Analytics
            <small>sales revenue</small>
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
            theme: "light1",
            title:{
                text: "Sales Revenue"              
            },
            axisY: {
                prefix      : "%",
            },
            data: [              
            {
                // Change type to "doughnut", "line", "splineArea", etc.
                type: "splineArea",
                percentFormatString: "#0.##",
                toolTipContent: "{y} (%)",
                
                dataPoints: [
                    { label: "Total", y: 100, indexLabel: "<?php echo $total ?>M"},
                    { label: "Day (<?php echo $strToday?>)", y: <?php echo $percentTotalPerDay ?>, indexLabel: "<?php echo $totalDay ?>M"},
                    { label: "Week (<?php echo $strStartdate.' to '.$strEnddate?>)", y: <?php echo $percentTotalPerWeek ?>, indexLabel: "<?php echo $totalWeek ?>M"},
                    { label: "Month (<?php echo $monthCurrent?>)", y: <?php echo $percentTotalPerMonth ?>, indexLabel: "<?php echo $totalMonth ?>M"}
                ]
            },
            ]
        });
        chart.render();
    }
</script>