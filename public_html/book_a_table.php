<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//--------------------------------------Youngs App------------------------------------
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

$bookingID;
$venueName;

//------------------------------------------------------------------------------------
//-----------------------------------Page Functions-----------------------------------
//------------------------------------------------------------------------------------

/**
 * Function to print out fallback page
 */
function printFallback(){
    // Redirect
    header("Location: /fallback/youngs_booking_fallback.php");
    die();
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
    // -- 1 -- Buckingham Arms

    $aztecID = "1";
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

    $bookingID = $rows[0]['venue_booking_id'];
    $venueName = $rows[0]['venue_name'];

    // Check booking ID is set and valid 
    if(isset($bookingID) && !empty($bookingID)){
        // Check venue name is set
        if(!isset($venueName) || empty($venueName)){
            // Use Young's as a fallback
            $venueName = "Young's";
        }
    } else{
        // No link found, display fallback
        printFallback();
    }

} else{
    // No venue found display fallback
    printFallback();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Enquiry for <?php echo $venueName; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Grand+Hotel" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box !important;
        }

        body {
            padding: 30px 10px;
            background: #f4f0e6 url('media/img/background.jpg') top center no-repeat;
            background-size: 100%;
            font-family: 'Delta Jager', sans-serif;
        }

        h1,
        h2 {
            margin: 0;
            line-height: 1.1;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            font-size: 22px;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            font-family: 'Grand Hotel', cursive;
            font-weight: normal;
        }

        .dmn-form.dmn-form {
            background-color: transparent;
            border: none;
            box-sizing: content-box;
            color: #818181;
            font-family: Arial, Tahoma, sans-serif;
            font-size: 13px;
            position: relative;
            text-shadow: none;
            width: 100%;
        }

        .dmn-form.dmn-form label {
            font-family: 'Delta Jager', sans-serif;
        }

        .dmn-form.dmn-form select,
        .dmn-form.dmn-form input,
        .dmn-form.dmn-form input[type="text"],
        .dmn-form.dmn-form input[type="password"] {
            width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 3px;
            outline: none;
            box-shadow: none;
            background: #fff;
            height: 40px;
            color: #333;
        }

        .dmn-form.dmn-form select {
            background: #fff url('data:image/png;base64,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cHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAoTWFjaW50b3NoKSIgeG1wOkNyZWF0ZURhdGU9IjIwMTctMTEtMjJUMTI6NTc6NDNaIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDE3LTExLTIyVDEyOjU3OjQzWiIgeG1wOk1vZGlmeURhdGU9IjIwMTctMTEtMjJUMTI6NTc6NDNaIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjE4YzNhOTM4LWE2MWYtNDIyYS1iNDZlLTAyNjQ0Y2U1YTEyNCIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjZkYTczZDJjLTAzYWYtN2U0MS05ZmRkLTk2ZWJhZmQ3MTI3MiIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOmU1NjhmZjRkLTlmM2EtNDdkZi04NDdiLWJlMTIzMzJjZDNlNiIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJEaXNwbGF5Ij4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDplNTY4ZmY0ZC05ZjNhLTQ3ZGYtODQ3Yi1iZTEyMzMyY2QzZTYiIHN0RXZ0OndoZW49IjIwMTctMTEtMjJUMTI6NTc6NDNaIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgKE1hY2ludG9zaCkiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjE4YzNhOTM4LWE2MWYtNDIyYS1iNDZlLTAyNjQ0Y2U1YTEyNCIgc3RFdnQ6d2hlbj0iMjAxNy0xMS0yMlQxMjo1Nzo0M1oiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz73EHBMAAAA+UlEQVRIie2WUQqCQBRFj/XrCiJoC9I2wp0UbSVyJyZtw0WYK/DXsJ95ZKIyM84MFB24IKJzEK4zD8xYAxlwUddeiIEc6FRydc8pW6DsSSQlsHElSYBqRCKp1DOLSIFmRiJpgIOt5Ai0GhJJq97RRpqlKxjmikYjY+C2QKLVyKlm2aZUa36QAA+HktFG6jbLNg2QRsAOj9uJ4ul5/TdR13VBRKsglr/oK0TBCPrDBtmCxJgAtQdJDeyHnxfkmBBioHAguaMxii09yjMMy3XCfDg5mwj6mIxb6cQa2iTMH/M1DgZIYW4knmyWLcNRrMDDkC9II42b9Xu8AJVNHqhxDVF1AAAAAElFTkSuQmCC');
            background-position: calc(100% - 8px) center;
            background-repeat: no-repeat;
            background-size: 7.5px;
            -webkit-appearance: none;
        }

        .dmn-form.dmn-form h1 {
            font-size: 18px;
            margin-bottom: 20px;
            display: none;
        }

        .dmn-form.dmn-form a {
            color: #383838;
        }

        .dmn-form.dmn-form .btn-primary {
            background: #b60202;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-weight: bold;
            font-family: 'Delta Jager', sans-serif;
        }
    </style>
</head>

<body>

    <h2>Make a booking enquiry at</h2>
    <h1><?php echo $venueName; ?></h1>

    <script src="http://partners.designmynight.com/pf/js?venue_id=<?php echo $bookingID; ?>"></script>

</body>

</html>