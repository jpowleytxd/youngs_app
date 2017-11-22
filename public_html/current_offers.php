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
$happyHourOn;

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

    // Starting date for weekly cycle
    $startWeek = 44;

    $ddate = date('Y-m-d');
    $duedt = explode("-", $ddate);
    $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
    $weekNumber  = (int)date('W', $date);

    $currentNumber = abs(intval($startWeek) - intval($weekNumber)) + 1;

    while($currentNumber > 12){
        $currentNumber = $currentNumber - 12;
    }

    $today = strtolower(date("D"));

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

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/youngs_offers.css?2=3">

    <!-- Script imports -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
    <script src="js/youngs_card_flip.js"></script>
</head>

<body id="<?php echo $brand; ?>">
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
        foreach($results as $result){
            printOffer($result, false, "");
        }
    ?>
</div>
</body>
</html>