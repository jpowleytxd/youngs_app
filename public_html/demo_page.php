<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//-----------------------------------Greene King App----------------------------------
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

<style>

*{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body{
  font-family: 'Arial', san-serif;
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
  height: 80px;
  display: block;
  position: relative;
  float: left;
}

h1{
  display: block;
  position: ;
  float: right;
  color: #154834;
  font-size: 18px;
  height: 80px;
  line-height: 80px;
}

section{
  width: 100%;
  min-height: calc(100% - 80px);
  display: block;
  position: relative;
  padding-top: 40px;
  background: #154834;
}

a{
  width: 100%;
  height: 40px;
  display: block;
  position: relative;
  padding-left: 20px;
  padding-right: 20px;
  color: #fff;
  font-size: 16px;
  text-align: left;
  text-decoration: none;
  line-height: 40px;
  border-bottom: 1px solid #fff;
}

a:hover{
  background: #fff;
  color: #154834;
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
    width: 320px;
    height: 568px;
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
  <img src="https://upload.wikimedia.org/wikipedia/en/4/43/Greene_king.png" alt="Greene King">
  <h1>Mallard <?php echo $demo; ?> Demo</h1>
  <div class="clearfix"></div>
</header>
<section id="demo_section">
  <iframe src="<?php echo $page ?>" frameborder="0"></iframe>
</section>
</body>
