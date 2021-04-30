<?php 
    session_start();  
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/buzz/controllers/authController.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link href="css/style.css?<?php echo bin2hex(random_bytes(6)) ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>

    <div class="flex-center">
        <div class='auth-page-container'>

            <div class='auth-modal-header'>
                <div class='center-modal-header'>
                    <h3>Sign up</h3>
                </div>
            </div>

            <div class='auth-modal-body'>
                <div class='welcome-msg-wrapper'>
                    <h2>Welcome to Buzzerr</h2>
                </div>

                <form class='auth-modal-form' action='' method='post' enctype='multipart/form-data'>
                    <div class='input-group'>
                        <label>Name</label>
                        <input name='username' placeholder='John Doe' type='text'>
                    </div>
                    <div class='input-group'>
                        <label>Password</label>
                        <input name='userpassword' placeholder='•••••••••••••••' type='password'>
                    </div>
                    <div class='input-group'>
                        <label>University Email</label>
                            <?php if (isset($_SESSION["errormessage"])): ?>
                                <input name='useremail' placeholder='you@university.edu' type='email' style="border:1px solid red">
                                <div class="email-error-msg">
                                    <span><?php echo $_SESSION["errormessage"]?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!isset($_SESSION["errormessage"])): ?>
                                <input name='useremail' placeholder='you@university.edu' type='email'>
                            <?php endif; ?>             
                    </div>

                    <div class='sign-up-btn-wrapper'>
                        <button type="submit" name="signup" id="sign-up-btn">Sign Up</button>
                    </div>

                    <div class='bottom-form-msg-wrapper'>
                        <span>Already have an account?</span>
                        <a href='signin.php'>Sign in</a>
                    </div>   
                </form>
            </div>
        </div>
    </div>  
</body>
</html>