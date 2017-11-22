<?php
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
//--------------------------------------Youngs App------------------------------------
//---------------------------------------FAQ Page-------------------------------------
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
?>

<html>

<head>
    <title>Young's FAQ Page</title>

    <meta charset="UTF-8">
    <meta name="description" content="Youngs FAQ Page">
    <meta name="keywords" content="youngs, faq">
    <meta name="author" content="Zonal Marketing technologies">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
    // Get fonts and echo out
    $fonts = file_get_contents('partials/_bespoke_fonts.php');
    echo $fonts;
    ?>

    <link href="../css/youngs_faq.css" rel="stylesheet" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/youngs_faq.js"></script>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="nav_title">Slide To View Category</div>
            <nav>
                <a class="nav_button active" data-target="account_section">Account</a>
                <a class="nav_button" data-target="payment_section">Payment</a>
                <a class="nav_button" data-target="bookings_section">Bookings</a>
                <a class="nav_button" data-target="treats_section">My Treats</a>
                <div class="clearfix"></div>
            </nav>
        </header>
        <section id="account_section" class="active">
            <h1>ACCOUNT</h1>
            <p><span class="question">Do I need to register to use On Tap?</span><br />
            <span class="answer">No, you don't need to register to enjoy On Tap, but we recommend you do to get all the benefits and treats.</span></p>
            <p><span class="question">I've forgotten my log-in details</span><br />
            <span class="answer">If you can't remember your log-in details, tap on the FORGETTEN YOUR PASSWORD and we'll send you an email to reset your password.</span></p>
            <div class="clearfix"></div>
        </section>
        <section id="payment_section">
            <h1>PAYMENT</h1>
                <p><span class="question">How do I pay my bill using On Tap?</span><br />
                <span class="answer">No, you don't need to register to enjoy On Tap, but we recommend you do to get all the benefits and treats.</span></p>
                <p><span class="question">Is there a minimum spend to pay On Tap?</span><br />
                <span class="answer">If you can't remember your log-in details, tap on the FORGETTEN YOUR PASSWORD and we'll send you an email to reset your password.</span></p>
        </section>
        <section id="bookings_section">
            <h1>BOOKINGS</h1>
                <p><span class="question">How can I cancel a table booking made On Tap?</span><br />
                <span class="answer">No, you don't need to register to enjoy On Tap, but we recommend you do to get all the benefits and treats.</span></p>
        </section>
        <section id="treats_section">
            <h1>MY TREATS</h1>
                <p><span class="question">Do I need to print off My Treat?</span><br />
                <span class="answer">No, you don't need to register to enjoy On Tap, but we recommend you do to get all the benefits and treats.</span></p>
                <p><span class="question">How do I find out which pubs are taking part in the Treat?</span><br />
                <span class="answer">If you can't remember your log-in details, tap on the FORGETTEN YOUR PASSWORD and we'll send you an email to reset your password.</span></p>
        </section>
        <footer>
            &copy; Youngs <?php echo date("Y") ?>
        </footer>
    </div>
</body>
</html>