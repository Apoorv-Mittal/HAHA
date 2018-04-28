<head>
    <!-- dhtmlx calendar scripts -->
    <link rel="stylesheet" href="scheduler/codebase/dhtmlxscheduler.css">
    <script src="scheduler/codebase/dhtmlxscheduler.js"></script>
    <!-- Script for small calendar in new event form -->
    <script src="scheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" >

    <style media="screen">
        html, body{
            margin:0;
            padding:0;
            height:100%;
            overflow:hidden;
        }
    </style>

</head>

<!-- Style for public events not owned by user (Change to orange color) -->
<style type="text/css" >
    html, body{
        margin:0;
        padding:0;
        height:100%;
        overflow:hidden;
    }
    /*event in day or week view*/
    .dhx_cal_event.public div{
        background-color:orange !important;
        color:white !important;
    }
    /*multi-day event in month view*/
    .dhx_cal_event_line.public{
        background-color:orange !important;
        color:white !important;
    }
    /*event with fixed time, in month view*/
    .dhx_cal_event_clear.public{
        color:orange !important;
    }
</style>

<!-- Style for public events created by user (Change to orangered color)-->
<style type="text/css" >
    html, body{
        margin:0;
        padding:0;
        height:100%;
        overflow:hidden;
    }
    /*event in day or week view*/
    .dhx_cal_event.public_mine div{
        background-color:orangered !important;
        color:white !important;
    }
    /*multi-day event in month view*/
    .dhx_cal_event_line.public_mine{
        background-color:orangered !important;
        color:white !important;
    }
    /*event with fixed time, in month view*/
    .dhx_cal_event_clear.public_mine{
        color:orangered !important;
    }
</style>

<!-- Style for navigation bar-->
<style>
    #nav {
        padding: 4px;
        width: 100%;
        height:49px;
        background-color:lightblue;
    }
    form {
        float: left;
        width: 50%;
        margin: 0;
    }
</style>

<head>


<body onload="init();">

<div style="padding: 4px;width: 100%;height:49px;background-color:lightblue;">
    <form>
        <input type="submit" value="Go to Home Page" class="btn btn-info" formaction="user.php" formmethod="post"/>
        <input type="submit" value="Create New Event" class="btn btn-info" formaction="new_event.php" formmethod="post"/>
        <input type="submit" value="Edit Interests" class="btn btn-info" formaction="interests.php" formmethod="post"/>
        <a href="logout.php" class="btn btn-warning" style='float: right'>Logout</a>
    </form>
</div>


<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:90%;'>
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

<?php
    session_start();
    $session_value=$_SESSION['email'];
?>

<script>
    function init() {
        var email='<?php echo $session_value;?>';

        // Calendar configurations
        scheduler.config.xml_date="%Y-%m-%d %H:%i:%s";
        scheduler.config.details_on_create = true;
        scheduler.config.max_month_events = 5; // displayed with 'view more' otherwise
        scheduler.config.first_hour = 10; // default hour when displaying calendar and adding event

        // Code to display public events with different color
        scheduler.templates.event_class=function(start,end,event){
            if (event.type === "PUBLIC") {
                if(event.owner_email === email)
                    return "public_mine";
                else
                    return "public";
            }
        };

        // Allow edit operations only for private events
        function allow_own(id){
            let ev = this.getEvent(id);
            return ev.type === "PRIVATE" || ev.owner_email === email;
        }
        scheduler.attachEvent("onClick",allow_own);
        scheduler.attachEvent("onBeforeDrag",allow_own);
        scheduler.attachEvent("onDblClick",allow_own);

        // Format for the new event form
        let email_map = [
            { key: email, label: email }
        ];
        let type_map = [
            { key: 'PRIVATE', label: 'PRIVATE' }
        ];
        scheduler.config.lightbox.sections=[
            {name:"Title", height:40, type:"textarea" , focus:true, map_to:"text"},
            {name:"Email", height:23, type:"select", options: email_map, map_to:"owner_email" },
            {name:"Type", height:23, type:"select", options: type_map, map_to:"type" },
            {name:"Time Period", height:72, type:"calendar_time", map_to:"auto"}
        ];

        // Code to be able to save data into the db
        scheduler.load("data.php");
        let dp = new dataProcessor("data.php");
        dp.init(scheduler);

        // Initialize calendar
        scheduler.init('scheduler_here', new Date(),"month");

    }
</script>



