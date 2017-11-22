<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//--------------------------------------Youngs App------------------------------------
//----------------------------------Current Offers Page-------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

// Set infinite timeout
ini_set('max_execution_time', 0);

require_once('dbConn.php');
require_once('../vendor/autoload.php');

// Add .env support
$dotenv = new Dotenv\Dotenv('../');

//------------------------------------------------------------------------------------
//----------------------------------Global Variables----------------------------------
//------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------
//-----------------------------------Page Functions-----------------------------------
//------------------------------------------------------------------------------------

/**
 * Function to print out fallback page
 */
function printFallback(){
    // Redirect
    // header("Location: /fallback/youngs_all_offers_fallback.php");
    // die();
}

/**
 * function to print the offer row out
 * {Object[]} $offer   -> offer array to be print
 * {boolean} $expires  -> if the offer expires in a time frame
 * {String} $time      -> time the offer expires
*/
function printOffer($offer, $expires, $time){
    $tileText = json_decode($offer['offer_text'], true);

    // Check if this offer expires
    if($expires === true){
        $times = explode(":", $time);

        echo '<div class="tile_outer expires" data-hour="' . $times[0] . '" data-minute="' . $times[1] . '" data-second="' . $times[2] . '">';
    } else{
        echo '<div class="tile_outer">';
    }
        echo '<div class="tile_back" style="background: ' . $offer['offer_background_colour'] . ';">';
            echo '<div class="tile_title" style="color: ' . $offer['offer_title_colour'] . ';">' . $offer['offer_title'] . '</div>';
            echo '<div class="tile_sub_title" style="color: ' . $offer['offer_text_colour'] . ';">' . $offer['offer_sub_title'] . '</div>';
            echo '<div class="tile_text" style="color: ' . $offer['offer_text_colour'] . ';">';
                foreach($tileText['text'] as $text){
                    echo '<p>' . $text . '</p>';
                }
            echo '</div>';

            // Check if link has been provided
            if(isset($offer['offer_external_link']) && !empty($offer['offer_external_link'])){
                echo '<a href="' . $offer['offer_external_link'] . '" class="tile_button" style="color: ' . $offer['offer_title_colour'] . '; border-color: ' . $offer['offer_title_colour'] . ';">View</a>';
            }
        echo '</div>';
        echo '<div class="tile_front">';
            echo '<img src="' . $offer['offer_tile_image_url'] . '" alt="' . $offer['offer_title'] . ' ' . $offer['offer_sub_title'] . '">';
        echo '</div>';
    echo '</div>';
    echo '<div class="clearfix"></div>';
}

//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//-------------------------------Start Main Process Here------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

$aztecID;
$happyHourOn = false;
$happyHourOffer = array();
$currentOffers = array();

// GET environment
$environment = getenv('ENVIRONMENT');

//------------------------------------------------------------------------------------
//-----------------------------GET Venue Details From POST----------------------------
//------------------------------------------------------------------------------------

// Check environment being used
if(($environment === "DEVELOPMENT") || ($environment === "DEMO")){
    // Using a DEVELOPMENT environment

    // AZTEC examples:
    // -- 1 -- Buckingham Arms

    $aztecID = "1";
} else{
    // Environment is NOT DEVELOPMENT
    // Check POST isset and not empty
    if(isset($_POST) && !empty($_POST)){
        // Check POST
        $json = json_decode($_POST['request'], true);
        
        // Check if POST has 'siteId' as key
        if(array_key_exists('siteId', $json['request'])){
            $aztecID =  $json['request']['siteId'];
        } else{
            // 'siteId' does not exist, look for venueId
            if(array_key_exists('siteId', $json['request']['venueId'])){
                $aztecID =  $json['request']['venueId'];
            } else{
                // No aztec id found
                printFallback();
            }
        }

    } else{
        // POST not set or is empty
        printFallback();

    }
}

//------------------------------------------------------------------------------------
//--------------------------GET Venue Data From The Database--------------------------
//------------------------------------------------------------------------------------

// Setup connection
$pdo = new dbConn;

// Prepare SQL 
$selectSQL = "SELECT * 
              FROM app_venues
              WHERE venue_aztec_id = :aztec
              LIMIT 1";

$selectQuery = $pdo->prepare($selectSQL);
$selectQuery->bindParam(":aztec", $aztecID , PDO::PARAM_STR);

// Execute query
$results = $selectQuery->execute();

//------------------------------------------------------------------------------------
//-----------------------------------Process Results----------------------------------
//------------------------------------------------------------------------------------

date_default_timezone_set("Europe/London");

// Check row found
if($results === true){
    // Fetch results 
    $rows = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

    // GET offer id's from row and decode
    $offers = $rows[0]['venue_offers'];
    $offers = json_decode($offers, true);
    
    // Build offers into string
    $offerString = "";
    foreach($offers['OFFERS'] as $key => $offer){
        // Check if first element or not
        if($key === 0){
            $offerString .= "'{$offer}'";
        } else{
            $offerString .= ", '{$offer}'";
        }        
    }

    // Prepare SQL 
    $selectSQL = "SELECT * 
                  FROM app_offers
                  WHERE offer_id IN ({$offerString})
                  AND offer_start_date <= DATE_FORMAT(NOW(),'%Y-%m-%d') 
                  AND offer_end_date >= DATE_FORMAT(NOW(),'%Y-%m-%d') 
                  AND offer_active = 1 
                  AND offer_removed = 0 
                  ORDER BY offer_tile_priority ASC";

    $selectQuery = $pdo->prepare($selectSQL);

    // Execute query
    $selectQuery->execute();

    // Fetch results 
    $results = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

    $today = strtolower(date("D"));

    // Go through results, add to array, search for Happy Hour
    foreach($results as $result){
        // Get dates from object
        $dates = json_decode($result['offer_times'], true);

        // Check if current day
        foreach($dates['DAYS'] as $day){
            if($day === $today){
                // printOffer($result, false, "");
                
                // Check if happy hour
                if($result['offer_type'] === "happy_hour"){
                    $happyHourOn = true;
                    array_push($happyHourOffer, $result);
                } else{
                    array_push($currentOffers, $result);
                }
            }
        }
    }

} else{
    // No venue found display fallback
    printFallback();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Current Offers</title>

    <meta charset="UTF-8">
    <meta name="description" content="Youngs Current Offers App Page">
    <meta name="keywords" content="youngs, current, offers">
    <meta name="author" content="Zonal Marketing technologies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    // Get fonts and echo out
    $fonts = file_get_contents('partials/_bespoke_fonts.php');
    echo $fonts;
    ?>

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/youngs_offers.css?2=3">

    <!-- Script imports -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
    <script src="js/youngs_card_flip.js"></script>
</head>

<body>
<div class="loading">

</div>
<div class="wrapper">
    <header>
        <img src="media/headers/current_offers.png" alt="Current Offers">
    </header>
    <div class="clearfix"></div>
    <!-- 
        Classes:
        flipped         - flipped state of tile
    -->
    <?php
        // Print each happy hour tile
        foreach($happyHourOffer as $result){
            // Get dates from object
            $dates = json_decode($result['offer_times'], true);
            // Check if current day
            foreach($dates['DAYS'] as $day){
                if($day === $today){
                    // Check times
                    if($dates['TIMES'][0] !== "all"){
                        // Check times are valid
                        foreach($dates['TIMES'] as $time){
                            if(strtolower($time['DAY']) === strtolower($today)){
                                // Get times
                                $startTime = intval(preg_replace("/:/", "", $time['START']));
                                $currentTime = intval(date("His"));
                                $endTime = intval(preg_replace("/:/", "", $time['END']));
                                if(($startTime < $currentTime) && ($currentTime < $endTime)){
                                    // Print happy hour countdown tile
                                    echo '<!-- Happy Hour Iframe -->';
                                    echo '<iframe src="happy_hour.php?brand=youngs&id=' . $result['offer_id'] . '" style="" id="happy_hour_container" scrolling="no"></iframe>';

                                    // Print happy hour tile
                                    printOffer($result, true, $time['END']);
                                }
                            }
                        }
                    }
                }
            }
        }
    ?>

    <?php
        foreach($currentOffers as $result){
            // Get dates from object
            $dates = json_decode($result['offer_times'], true);
            // Check if current day
            foreach($dates['DAYS'] as $day){
                if($day === $today){
                    // Check times
                    if($dates['TIMES'][0] === "all"){
                        printOffer($result, false, "");
                    } else{
                        // Check times are valid
                        foreach($dates['TIMES'] as $time){
                            if(strtolower($time['DAY']) === strtolower($today)){
                                // Get times
                                $startTime = intval(preg_replace("/:/", "", $time['START']));
                                $currentTime = intval(date("His"));
                                $endTime = intval(preg_replace("/:/", "", $time['END']));
                                if(($startTime < $currentTime) && ($currentTime < $endTime)){
                                    printOffer($result, true, $time['END']);
                                }
                            }
                        }
                    }
                }
            }
        }
    ?>
</div>
</body>
</html>