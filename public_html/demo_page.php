<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//--------------------------------------Youngs App------------------------------------
//-----------------------------Demo Page Containing Iframe----------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

// GET destination from URL
$page = $_GET['page'];
$demo = $_GET['demo'];

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
    display: block;
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
    display: block;
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

iframe{
    width: 375px;
    height: 667px;
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

</style>

</head>

<body>

<header>
  <img src="http://www.youngs.co.uk/assets/templates/default/img/brand-logo.png" alt="Youngs">
  <h1><?php echo $demo; ?> Demo</h1>
  <div class="clearfix"></div>
</header>
<section id="demo_section">
  <iframe src="<?php echo $page ?>" frameborder="0"></iframe>
</section>
</body>
