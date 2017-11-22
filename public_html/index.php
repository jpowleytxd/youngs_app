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

<style>

*{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body{
  font-family: 'Opens Sans', san-serif;
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
  border-bottom: 1px solid #383838;
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
  background: #ffffff;
}

a{
  width: 100%;
  height: 40px;
  display: block;
  position: relative;
  padding-left: 20px;
  padding-right: 20px;
  color: #383838;
  font-size: 16px;
  text-align: left;
  text-decoration: none;
  line-height: 40px;
  border-bottom: 1px solid #383838;
}

a:hover{
  background: #383838;
  color: #ffffff;
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
  color: #383838;
  padding: 0;
  border-collapse: collapse;
}

tr:first-of-type td{
  border-top: 1px solid #383838;
}

td{
  width: 50%;
  height: 40px;
  padding-left: 20px;
  padding-right: 20px;
  border-bottom: 1px solid #383838;;
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
  <img src="http://www.youngs.co.uk/assets/templates/default/img/brand-logo.png" alt="Greene King">
  <h1 id="demo_title">Demo Links</h1>
  <h1 id="staging_title">Staging Links</h1>
  <h1 id="live_title">Live Links</h1>
  <h1 id="development_title">Developer Links</h1>
  <div class="clearfix"></div>
</header>
<section id="demo_section">
  <a href="demo_page.php?demo=Allergens&page=allergens.php" style="border-top: 1px solid #fff;">Allergens</a>
  <a href="demo_page.php?demo=Book%20A%20Table&page=book_a_table.php">Book A Table</a>
  <a href="demo_page.php?demo=All%20Offers&page=all_offers.php">All Offers</a>
  <a href="demo_page.php?demo=App%20Offers&page=app_offers.php">App Offers</a>
  <!-- <a href="happy_hour.php?brand=hungry_horse">Happy Hour (Hungry Horse)</a> -->
  <!-- <a href="happy_hour.php?brand=locals">Happy Hour (Locals)</a> -->
  <!-- <a href="season_ticket.php?brand=hungry_horse">Season Ticket (Hungry Horse)</a> -->
  <a href="demo_page.php?demo=Terms%20%26%20Conditions&page=terms_and_conditions.php">Terms And Conditions (Youngs)</a>
  <a href="demo_page.php?demo=Privacy%20Policy&page=privacy_policy.php">Privacy Policy (Youngs)</a>
</section>
<section id="staging_section">
    <table>
        <tbody>
            <tr>
                <td>Allergens</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/allergens.php</td>
            </tr>
            <tr>
                <td>Book A Table</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/book_a_table.php</td>
            </tr>
            <tr>
                <td>All Offers</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/all_offers.php</td>
            </tr>
            <tr>
                <td>App Offers</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/app_offers.php</td>
            </tr>
            <!-- <tr>
                <td>Season Ticket</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/season_ticket.php?brand=[[BRAND]]</td>
            </tr> -->
            <tr>
                <td>Terms And Conditions</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/terms_and_conditions.php</td>
            </tr>
            <tr>
                <td>Privacy Policy</td>
                <td>https://youngs-uat.txdclientdemos.co.uk/privacy_policy.php</td>
            </tr>
        </tbody>
    </table>
</section>
<section id="live_section">
    <table>
        <tbody>
            <tr>
                <td>Allergens</td>
                <td>https://youngs-live.txdclientdemos.co.uk/allergens.php</td>
            </tr>
            <tr>
                <td>Book A Table</td>
                <td>https://youngs-live.txdclientdemos.co.uk/book_a_table.php</td>
            </tr>
            <tr>
                <td>All Offers</td>
                <td>https://youngs-live.txdclientdemos.co.uk/all_offers.php</td>
            </tr>
            <tr>
                <td>App Offers</td>
                <td>https://youngs-live.txdclientdemos.co.uk/app_offers.php</td>
            </tr>
            <!-- <tr>
                <td>Season Ticket</td>
                <td>https://youngs-live.txdclientdemos.co.uk/season_ticket.php?brand=[[BRAND]]</td>
            </tr> -->
            <tr>
                <td>Terms And Conditions</td>
                <td>https://youngs-live.txdclientdemos.co.uk/terms_and_conditions.php</td>
            </tr>
            <tr>
                <td>Privacy Policy</td>
                <td>https://youngs-live.txdclientdemos.co.uk/privacy_policy.php</td>
            </tr>
        </tbody>
    </table>
</section>
<section id="development_section">
  <a href="allergens.php" style="border-top: 1px solid #fff;">Allergens</a>
  <a href="book_a_table.php">Book A Table</a>
  <a href="all_offers.php">All Offers</a>
  <a href="app_offers.php">App Offers</a>
  <a href="happy_hour.php?brand=hungry_horse">Happy Hour (Hungry Horse)</a>
  <a href="happy_hour.php?brand=locals">Happy Hour (Locals)</a>
  <!-- <a href="season_ticket.php?brand=hungry_horse">Season Ticket (Hungry Horse)</a> -->
  <a href="terms_and_conditions.php">Terms And Conditions (Youngs)</a>
<a href="privacy_policy.php">Privacy Policy (Youngs)</a>
</section>
</body>
