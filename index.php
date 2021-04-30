<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/buzz/controllers/authController.php');
    $loggedin = false;

    if (isset($_SESSION["usertoken"])) {
        $loggedin = true;
    }

    unset($_SESSION["errormessage"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Buzzerr</title>
    
    <link href="css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

</head>
<body>

    <div class="index-page-bg">

        <nav>
            <div class="nav-center">
                <div class="nav-logo">
                    <img src="images/bee.svg" alt="an image of a bee">
                    <span class="logo-name">Buzzerr</span>
                </div>
                <button class="sign-up">
                    <?php if ($loggedin): ?>
                        <a href="/projects/buzz/?logout=1"><span>Log out</span></a>
                    <?php endif; ?>
                    <?php if (!$loggedin): ?>
                        <a href="signup.php"><span>Sign up</span></a>
                    <?php endif; ?>
                    
                </button>
            </div>
        </nav>
    
        <main>

            <div class="hero-section">
                <div class="max-width-wrapper">
                    <div class="hero-message">
                        <span>Events Suggested</span>
                        <span>For You.</span>
                    </div>
                </div>
            </div>
            
        
            <div class="max-width-wrapper">
                <div class="find-events-container">
                    <div class="load-events-grid"></div>
                </div>
            </div>

        </main>

    </div>

    <script src="js/index.js?<?php echo bin2hex(random_bytes(6)) ?>"></script>

</body>
</html>