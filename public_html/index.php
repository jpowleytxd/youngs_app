<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//--------------------------------------Youngs App------------------------------------
//-------------------------------------Landing Page-----------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

require_once('dbConn.php');
require_once('../vendor/autoload.php');

// Add .env support
$dotenv = new Dotenv\Dotenv('../');

// GET environment
$environment = getenv('ENVIRONMENT');

?>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1.0 user-scalable=no">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

<?php
// Get fonts and echo out
$fonts = file_get_contents('partials/_bespoke_fonts.php');
echo $fonts;
?>

<style>

*{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body{
  font-family: "DeltaLight", san-serif;
}

header{
  width: 100%;
  height: 80px;
  z-index: 100;
  display: block;
  position: relative;
  padding-left: 20px;
  padding-right: 20px;
  background: #fff;
}

img{
  height: 60px;
  display: block;
  position: absolute;
  top: 50%;
  left: 20px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
}

h1{
  display: none;
  position: ;
  float: right;
  color: #383838;
  font-size: 18px;
  height: 80px;
  line-height: 80px;
}

section{
  width: 100%;
  min-height: 100vh;
  display: none;
  position: relative;
  padding-top: 40px;
  background: #383838;
}

a{
  width: 100%;
  height: 40px;
  display: block;
  position: relative;
  padding-left: 20px;
  padding-right: 20px;
  color: #ffffff;
  font-size: 16px;
  text-align: left;
  text-decoration: none;
  line-height: 40px;
  border-bottom: 1px solid #ffffff;
}

a:hover{
  background: #ffffff;
  color: #383838;
}

span{
  width: 100%;
  height: 40px;
  display: block;
  position: relative;
}

.clearfix{
    clear: both;
}

table{
  width: 100%;
  color: #ffffff;
  padding: 0;
  border-collapse: collapse;
}

tr:first-of-type td{
  border-top: 1px solid #ffffff;
}

td{
  width: 50%;
  height: 40px;
  padding-left: 20px;
  padding-right: 20px;
  border-bottom: 1px solid #ffffff;
}

td:first-of-type{
  text-align: right;
}

/* Differentiate for environment */
body#DEVELOPMENT #development_title, body#DEVELOPMENT #development_section{
  display: block;
}

body#STAGING #staging_title, body#STAGING #staging_section{
  display: block;
}

body#DEMO #demo_title, body#DEMO #demo_section{
  display: block;
}

body#LIVE #live_title, body#LIVE #live_section{
  display: block;
}

</style>

</head>

<body id="<?php echo $environment ?>">

<header>
  <img src="http://www.youngs.co.uk/assets/templates/default/img/brand-logo.png" alt="Youngs">
  <h1 id="demo_title">Demo Links</h1>
  <h1 id="staging_title">Staging Links</h1>
  <h1 id="live_title">Live Links</h1>
  <h1 id="development_title">Developer Links</h1>
  <div class="clearfix"></div>
</header>
<section id="demo_section">
    <a href="demo_page.php?demo=Book%20A%20Table&page=book_a_table.php" style="border-top: 1px solid #fff;">Book A Table</a>
    <a href="demo_page.php?demo=All%20Offers&page=all_offers.php">All Offers</a>
    <a href="demo_page.php?demo=Current%20Offers&page=current_offers.php">Current Offers</a>
    <!-- <a href="happy_hour.php">Happy Hour</a> -->
    <a href="demo_page.php?demo=Heritage&page=heritage.php">Heritage (Youngs)</a>
    <!-- <a href="demo_page.php?demo=Allergens&page=allergens.php">Allergens</a> -->
    <a href="demo_page.php?demo=Terms%20%26%20Conditions&page=terms_and_conditions.php">Terms And Conditions (Youngs)</a>
</section>
<section id="staging_section">
    <table>
        <tbody>
            <tr>
                <td>Book A Table</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/book_a_table.php</td>
            </tr>
            <tr>
                <td>All Offers</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/all_offers.php</td>
            </tr>
            <tr>
                <td>Current Offers</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/current_offers.php</td>
            </tr>
            <tr>
                <td>Heritage</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/heritage.php</td>
            </tr>
            <!-- <tr>
                <td>Allergens</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/allergens.php</td>
            </tr> -->
            <tr>
                <td>Terms And Conditions</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/terms_and_conditions.php</td>
            </tr>
        </tbody>
    </table>
</section>
<section id="live_section">
    <table>
        <tbody>
            <tr>
                <td>Book A Table</td>
                <td>https://youngs-live.txdclientdemos.co.uk/book_a_table.php</td>
            </tr>
            <tr>
                <td>All Offers</td>
                <td>https://youngs-live.txdclientdemos.co.uk/all_offers.php</td>
            </tr>
            <tr>
                <td>Current Offers</td>
                <td>https://youngs-live.txdclientdemos.co.uk/current_offers.php</td>
            </tr>
            <tr>
                <td>Heritage</td>
                <td>https://youngs-live.txdclientdemos.co.uk/heritage.php</td>
            </tr>
            <!-- <tr>
                <td>Allergens</td>
                <td>https://youngs-live.txdclientdemos.co.uk/allergens.php</td>
            </tr> -->
            <tr>
                <td>Terms And Conditions</td>
                <td>https://youngs-live.txdclientdemos.co.uk/terms_and_conditions.php</td>
            </tr>
        </tbody>
    </table>
</section>
<section id="development_section">
    <a href="book_a_table.php" style="border-top: 1px solid #fff;">Book A Table</a>
    <a href="all_offers.php">All Offers</a>
    <a href="current_offers.php">Current Offers</a>
    <!-- <a href="happy_hour.php">Happy Hour</a> -->
    <a href="heritage.php">Heritage (Youngs)</a>
    <!-- <a href="allergens.php">Allergens</a> -->
    <a href="terms_and_conditions.php">Terms And Conditions (Youngs)</a>
</section>
</body>
