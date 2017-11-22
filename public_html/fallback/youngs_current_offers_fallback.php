<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//--------------------------------------Youngs App------------------------------------
//-----------------------------Current Offers Fallback Page---------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
?>

<html>

<head>
    <title>Young's Fallback</title>

    <meta charset="UTF-8">
    <meta name="description" content="Youngs Current Offers Fallback">
    <meta name="keywords" content="youngs">
    <meta name="author" content="Zonal Marketing technologies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // Get fonts and echo out
    $fonts = file_get_contents('../partials/_bespoke_fonts.php');
    echo $fonts;
    ?>

    <link href="../css/youngs_fallback.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="wrapper">
        <header>
            <img src="http://www.youngs.co.uk/assets/templates/default/img/brand-logo.png" alt="Youngs">
        </header>
        <section class="message_container">
            <h1>Whoops!</h1>
            <p>
                Please refresh by clicking on the navigation again.
            </p>
        </section>
        <footer>
            &copy; Youngs <?php echo date("Y") ?>
        </footer>
    </div>
</body>
</html>