
<link rel="stylesheet" href="scheduler/codebase/dhtmlxscheduler.css">
<script src="scheduler/codebase/dhtmlxscheduler.js"></script>

<style media="screen">
    html, body{
        margin:0;
        padding:0;
        height:100%;
        overflow:hidden;
    }
</style>

<body onload="init();">
<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
    <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
    </div>
    <div class="dhx_cal_header"></div>
    <div class="dhx_cal_data"></div>
</div>




</body>

<script>
    function init() {
        scheduler.config.xml_date="%Y-%m-%d %H:%i:%s";
        scheduler.load("data.php");
        /* saving data */
        var dp = new dataProcessor("data.php");
        dp.init(scheduler);
        scheduler.init('scheduler_here', new Date(),"month");

    }
</script>



