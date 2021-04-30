<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/buzz/config/db.php');
    
    function isValidEmail($useremail) {
        $validInstitutes = array("@utoronto.ca", "@uwo.ca", "@york.ca");
        $emailsplit = explode('@', $useremail);
        $domain = "@" . $emailsplit[1];
        return in_array(strtolower($domain), $validInstitutes);
    }

    if (isset($_POST["signup"])) {
        
        $username = strip_tags($_POST["username"]);
        $useremail = strip_tags($_POST["useremail"]);
        $userpassword = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);
        $userdate = date('F Y');
        $usertoken = bin2hex(random_bytes(6));
    
        $sql = "SELECT * FROM users WHERE useremail='$useremail' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 0 && isValidEmail($useremail)) {
            
            $sql = "INSERT INTO users (username, useremail, userpassword, userdate, usertoken) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssss', $username, $useremail, $userpassword, $userdate, $usertoken);
            $_SESSION['usertoken'] = $usertoken;
  
            $stmt->execute();
   
            header('location: /projects/buzz/');
            
        }
        else if (mysqli_num_rows($result) != 0) {
            $_SESSION["errormessage"] = "There is already an account with that email";
        }
        else if (isValidEmail($useremail) == false) {
            $_SESSION["errormessage"] = "Please enter a valid university email";
        }
    }

    if (isset($_POST["signin"])) {
        
        $useremail = strip_tags($_POST["useremail"]);
        $userpassword = strip_tags($_POST['userpassword']);
        
        $sql = "SELECT * FROM users WHERE useremail=? OR userpassword=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $useremail, $userpassword);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($userpassword, $user['userpassword'])) {

            $sql="SELECT * FROM users WHERE useremail='$useremail' LIMIT 1";
            $result=mysqli_query($conn,$sql);

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $_SESSION['usertoken'] = $row['usertoken'];
            }

            echo $row['usertoken'];
            header('location: /projects/buzz/');
            exit();
        }
    }

    if (isset($_GET["logout"])) {
        session_destroy();
        unset($_SESSION['usertoken']);
        unset($_SESSION["errormessage"]);
        
        header('location: /projects/buzz/signin');
        exit();
    }
 
?>