<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//-------------------------------------Youngs App-------------------------------------
//----------------------------------Book A Table Page---------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

// Set infinite timeout
ini_set('max_execution_time', 0);

require_once('dbConn.php');
require_once('../vendor/autoload.php');

// Add .env support
$dotenv = new Dotenv\Dotenv('../');

//------------------------------------------------------------------------------------
//---------------------------------------Globals--------------------------------------
//------------------------------------------------------------------------------------
$fonts;
$styling;
$webPage;
$brand;

//------------------------------------------------------------------------------------
//-----------------------------------Page Functions-----------------------------------
//------------------------------------------------------------------------------------

/**
 * Function to print out fallback page
 */
function printFallback(){
    // Redirect
    header("Location: /fallback/greene_king_booking_fallback.php");
    die();
}

/**
 * Function to print out hungry horse booking page
 * DEPRECATED - 17/10/17
 */
function printHungryHorse(){
    $brand = "hungry_horse";
    $webURL = "https://www.hungryhorse.co.uk/book-online";
    $styleURL = "https://www.hungryhorse.co.uk/sites/default/files/css/css_Bx6t8ZCmh8Wy2BECsLCnVL2yO-4l_EyrjQGMSDfAe7M.css";
    
    // Get the required pages and remove unnecessary content
    $webPage = file_get_contents($webURL);
    $webPage = preg_replace("/<html>/", "", $webPage);
    $webPage = preg_replace("/<\/html>/", "", $webPage);
    $webPage = preg_replace("/<head>.*<\/head>/s", "", $webPage);
    $webPage = preg_replace("/<header.*?<\/header>/s", "", $webPage);
    $webPage = preg_replace("/<div class=\"Container Container--paneContentHeader\">/s", "<div class=\"Container Container--paneContentHeader\" style=\"display: none;\">", $webPage);
    $webPage = preg_replace("/<div class=\"Container Container--navigation u-textCenter\">/s", "<div class=\"Container Container--navigation u-textCenter\" style=\"display: none;\">", $webPage);
    $webPage = preg_replace("/<footer.*<\/footer>/s", "", $webPage);
    // $webPage = preg_replace("/<script.*?<\/script>/s", "", $webPage);
    $webPage = preg_replace("/<noscript.*?<\/noscript>/s", "", $webPage);
    $webPage = preg_replace("/<\!\-\-.*?\-\-\>/s", "", $webPage);
    
    $styling = file_get_contents($styleURL);
    
    // Get fonts and print into page
    $fonts = file_get_contents("partials/__greene_king_fonts.php");

    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<title>Book A Table</title>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="description" content="Greene King Book A Table">';
    echo '<meta name="keywords" content="greene, king, book, table">';
    echo '<meta name="author" content="Zonalk Marketing technologies">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<style>';
    echo $fonts;
    echo '</style>';
    echo '<style>';
    echo $styling;
    echo '</style>';
    echo '</head>';
    echo '<body id="' . $brand . '">';
    echo $webPage;
    echo '</body>';
    echo '</html>';
}

//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//-------------------------------Start Main Process Here------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

// GET environment
$environment = getenv('ENVIRONMENT');

//------------------------------------------------------------------------------------
//-----------------------------GET Venue Details From POST----------------------------
//------------------------------------------------------------------------------------

$aztecID;

// Check environment being used
if(($environment === "DEVELOPMENT") || ($environment === "DEMO")){
    // Using a DEVELOPMENT environment

    // AZTEC examples:
    // -- 1163 -- Mallard (Doncaster) -- Hungry Horse
    // -- 4 -- Bath House (Cambridge) -- Locals

    $aztecID = "1163";
} else{
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
$selectQuery->bindParam(":aztec", $aztecID , PDO::PARAM_INT);

// Execute query
$results = $selectQuery->execute();

//------------------------------------------------------------------------------------
//-----------------------------------Process Results----------------------------------
//------------------------------------------------------------------------------------


// Check row found
if($results === true){
    // Fetch results 
    $rows = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

    $bookingURL = $rows[0]['venue_booking_url'];

    // Check booking URL is set and valid 
    if(isset($bookingURL) && !empty($bookingURL)){
        // Check a valid URL is being used
        if(filter_var($bookingURL, FILTER_VALIDATE_URL)){
            header('Location: ' . $bookingURL);
        } else{
            // URL not valid, display fallback
            printFallback();
        }
    } else{
        // No link found, display fallback
        printFallback();
    }

    
    // // GET brand from results
    // $brand = $rows[0]['venue_brand'];
    // if($brand === "hungry_horse"){
    //     printHungryHorse();
    // } else{
    //     // No booking widget display fallback
    //     printFallback();
    // }
} else{
    // No venue found display fallback
    printFallback();
}

?>