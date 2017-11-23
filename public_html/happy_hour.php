<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//-------------------------------------Youngs App-------------------------------------
//-----------------------------------Happy Hour Page----------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

// Setup connection
require_once('dbConn.php');
$pdo = new dbConn;

date_default_timezone_set("Europe/London");

$brand = $_GET['brand'];
$offerID = $_GET['id'];

// Prepare SQL 
$selectSQL = "SELECT * 
              FROM app_offers
              WHERE offer_id = :offerID
              AND offer_type = 'happy_hour'";

$selectQuery = $pdo->prepare($selectSQL);
$selectQuery->bindParam(":offerID", $offerID , PDO::PARAM_INT);

// Execute query
$selectQuery->execute();

// Fetch results 
$results = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

//------------------------------------------------------------------------------------
//---------------------------------Time Calculations----------------------------------
//------------------------------------------------------------------------------------

$today = strtolower(date("D"));
$fullToday = ucwords(date("l"));

$startHour;
$startMinute;
$endHour;
$endMinute;

$startTime;
$currentTime;
$endTime;

$offer;


foreach($results as $result){
    // Get dates from object
    $dates = json_decode($result['offer_times'], true);

    // Check if current day
    foreach($dates['DAYS'] as $day){
        if($day === $today){
            // Check times
            // Check times are valid
            foreach($dates['TIMES'] as $time){
                if(strtolower($time['DAY']) === strtolower($today)){
                    // Get times
                    $startTime = explode(":", $time['START']);
                    $endTime = explode(":", $time['END']);

                    $startHour = $startTime[0];
                    $startMinute = $startTime[1];
                    $endHour = $endTime[0];
                    $endMinute = $endTime[1];

                    $startTime = intval(preg_replace("/:/", "", $time['START']));
                    $currentTime = intval(date("His"));
                    $endTime = intval(preg_replace("/:/", "", $time['END']));
                    $offer = $result;
                    break;
                }
            }
        }
    }
}

$status;
// Check times
if(isset($currentTime) && isset($startTime) && isset($endTime)){
    if($currentTime < $startTime){
        // Before offer started
        $status = 'before';
    } else if(($startTime < $currentTime) && ($currentTime < $endTime)){
        // During offer
        $status = 'on';
    } else if($endTime < $currentTime){
        // After Offer
        $status = 'after';
    }
} else{
    $currentTime = 0;
    $startTime = 0;
    $endTime = 0;
    $status = 'after';
}

?>

<html>

<head>
    <title>Happy Hour</title>

    <meta charset="UTF-8">
    <meta name="description" content="Youngs Happy Hour App Page">
    <meta name="keywords" content="youngs, happy, hour">
    <meta name="author" content="Zonal Marketing technologies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // Get fonts and echo out
    $fonts = file_get_contents('partials/_bespoke_fonts.php');
    echo $fonts;
    ?>

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/youngs_happy_hour.css">
    
    <!-- Script imports -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
    <!-- <script src="js/youngs_countdown.js"></script> -->

</head>
<body id="<?php echo $brand; ?>">
<div class="wrapper">
    <header>
        <h1>Happy Hour</h1>
        <h2>Get 20% off all drinks during Happy Hour</h2>
    </header>
    <div class="countdown_container">
        <div class="countdown_track">
            <div class="countdown_slider">
                <div class="demo">
                    <svg class="progress" width="100%" height="90vw" viewBox="0 0 120 120">
                        <circle class="progress__meter" cx="60" cy="60" r="54" stroke-width="12" />
                        <circle class="progress__value" cx="60" cy="60" r="54" stroke-width="12" />
                    </svg>
                </div>
            </div>
            <?php if($status === 'before'){ ?> <!-- HAPPY HOUR IS ON LATER-->
                <div class="before_inner">
                    <div class="before_upper_title">Starts At:</div>
                    <div class="time_container"><?php echo $startHour . ":" . $startMinute . ":00"; ?></div>
                    <div class="before_lower_title">Be Ready...</div>
                </div>
                <div class="countdown_inner">
                    <div class="countdown_upper_title">Ending In</div>
                    <div class="timer_container">
                    <div class="hours_container" id="hours" data-time="<?php echo $endHour ?>">00</div>
                    <div class="spacer_container">
                        <div class="spacer">:</div>
                    </div>
                    <div class="minutes_container" id="minutes" data-time="<?php echo $endMinute ?>">00</div>
                    <div class="spacer_container">
                        <div class="spacer">:</div>
                    </div>
                    <div class="seconds_container" id="seconds">00</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="countdown_lower_title"></div>
                </div>
                <div class="ended_inner">
                    <div class="ended_upper_title">Oh Dear...</div>
                    <div class="day_container">Happy Hour Timed Out!!</div>
                    <div class="ended_lower_title">Come again next week</div>
                </div>
            <?php } else if($status === 'on'){ ?> <!-- HAPPY HOUR IS ON NOW -->
                <div class="countdown_inner">
                    <div class="countdown_upper_title">Ending In</div>
                    <div class="timer_container">
                    <div class="hours_container" id="hours" data-time="<?php echo $endHour ?>">00</div>
                    <div class="spacer_container">
                        <div class="spacer">:</div>
                    </div>
                    <div class="minutes_container" id="minutes" data-time="<?php echo $endMinute ?>">00</div>
                    <div class="spacer_container">
                        <div class="spacer">:</div>
                    </div>
                    <div class="seconds_container" id="seconds">00</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="countdown_lower_title"></div>
                </div>
                <div class="ended_inner">
                    <div class="ended_upper_title">Oh Dear...</div>
                    <div class="day_container">Happy Hour Timed Out!!</div>
                    <div class="ended_lower_title">Come again soon</div>
                </div>
            <?php } else{ ?> <!-- HAPPY HOUR NOT ON -->
                <div class="ended_inner">
                    <div class="ended_upper_title">Oh Dear...</div>
                    <div class="day_container">Happy Hour Timed Out!!</div>
                    <div class="ended_lower_title">Come again soon</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <footer>
        <p>Order your drinks via the menu at the top</p>
    </footer>
</div>
<script>
    //------------------------------------------------------------------------------------
    //----------------------------------Global Variables----------------------------------
    //------------------------------------------------------------------------------------
    var status = "<?php echo $status; ?>";

    var startHour = <?php echo $startHour; ?>;
    var startMinute = <?php echo $startMinute; ?>;
    var endHour = <?php echo $endHour; ?>;
    var endMinute = <?php echo $endMinute; ?>;

    var duration;

    var interval = 1000; // 1 second
    var beforeInterval;
    var duringInterval;

    var progressValue = document.querySelector('.progress__value');
    
    var RADIUS = 54;
    var CIRCUMFERENCE = 2 * Math.PI * RADIUS;

    //------------------------------------------------------------------------------------
    //-------------------------------Prepare Date Variables-------------------------------
    //------------------------------------------------------------------------------------
    if(status === "before"){
        progress(0);
        offerDuration()
        beforeHappyHour();
    } else if(status === "on"){
        progress(0);
        offerDuration()
        onHappyHour();
    }

    //------------------------------------------------------------------------------------
    //-----------------------Functions Used Within Happy Hour Page------------------------
    //------------------------------------------------------------------------------------

    /**
     * Function to calculate happy hour duration
     */
    function offerDuration(){
        // Prep times
        var startDate = "01/01/2019 " + startHour + ":" + startMinute + ":00";
        startDate = new Date(startDate);
        var endDate = "01/01/2019 " + endHour + ":" + endMinute + ":00";
        endDate = new Date(endDate);

        duration = new Date(endDate - startDate);
    }

    /**
     * Function to countdown until happy hour
     */
    function beforeHappyHour(){
        beforeInterval = setInterval(function(){

            var currentDate = new Date();
            currentDate = "01/01/2019 " + currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
            var startDate = "01/01/2019 " + startHour + ":" + startMinute + ":00";

            if(Date.parse(currentDate) > Date.parse(startDate)){
                // Start Happy Hour
                onHappyHour();
                animateOut($('.before_inner'));
                clearInterval(beforeInterval);
            }
        }, interval);
    }

    /**
     * Function to countdown happy hour
     */
    function onHappyHour(){
        duringInterval = setInterval(function(){
            var currentDate = new Date();
            var currentDateString = "01/01/2019 " + currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
            currentDate = new Date(currentDateString);
            
            var endDateString = "01/01/2019 " + endHour + ":" + endMinute + ":00";
            var endDate = new Date(endDateString);

            // Calculate remaining times for displays
            var remaining = new Date(endDate - currentDate);

            // Parse hours for display
            var hours = remaining.getHours();
            hours = hours + "";
            if(hours.length == 1){
                hours = "0" + hours + "";
            }
            // Parse minutes for display
            var minutes = remaining.getMinutes();
            minutes = minutes + "";
            if(minutes.length == 1){
                minutes = "0" + minutes + "";
            }
            // Parse seconds for display
            var seconds = remaining.getSeconds();
            seconds = seconds + "";
            if(seconds.length == 1){
                seconds = "0" + seconds + "";
            }

            // Insert times into displays
            $('#hours').html(hours);
            $('#minutes').html(minutes);
            $('#seconds').html(seconds);

            // Progress bar calculations
            // Convert into percentage
            console.log("Remaining: " + remaining);
            console.log("Duration: " + duration);
            var percentage = (remaining / duration) * 100; 
            console.log("Percentage: " + percentage);
            var value = 100 - (1 * percentage);
            console.log("Value: " + value);
            progress(value);


            if(Date.parse(currentDate) > Date.parse(endDate)){
                // End Happy Hour
                progress(100);
                animateOut($('.countdown_inner'));
                clearInterval(duringInterval);
            }
        }, interval);
    }

    /**
     * Function to animate out clock faces
     * @param {object} face     - face to be animated out
     */
    function animateOut(face){
        var tl = new TimelineMax({paused:true});
        
        // Build timeline structure
        tl  .to($(face), 1.5, {
                transformOrigin: "50% 50%",
                rotation: 360,
                opacity: 0,
                scale: 0
            }, 0).to($(face), 0.5, {
                zIndex: -1
            }, 1.5);
        
        face.animation = tl;
        face.animation.play();
    }
    
    /**
     * Function to change time down bar
     * @param {float} value   - value (0-60) i
     */
    function progress(value){
        var progress = value / 100;
        var dashoffset = CIRCUMFERENCE * (progress -1);
        
        console.log('progress:', value + '%', '|', 'offset:', dashoffset)
        
        progressValue.style.strokeDashoffset = dashoffset;
        progressValue.style.strokeDasharray = CIRCUMFERENCE;
    }
    

</script>
</body>
</html>
