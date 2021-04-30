<?php
     
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/projects/buzz/config/db.php');

    $repsponse;
    $userloggedin;
    $responseContent;

    $usertoken = $_SESSION['usertoken'];

    if (isset($_POST['attendclick'])) {
        if (isset($_SESSION['usertoken'])) {

            $eventtoken = $_POST['eventtoken'];
            $userloggedin = "loggedin";
            $userattending = false;

            $sql = "SELECT * FROM userevents WHERE eventtoken='$eventtoken'";
            $result = mysqli_query($conn,$sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($row['usertoken'] == $usertoken) {
                    $userattending = true;
                }
            }

            if ($userattending) {
                $sql = "DELETE FROM userevents WHERE usertoken='$usertoken' AND eventtoken='$eventtoken'";
                if (!mysqli_query($conn, $sql)) {
                    echo "Error deleting record: " . mysqli_error($conn);
                } 
                mysqli_close($conn);
                $responseContent = "Attend event";
            }
            else {
                $sql = "INSERT INTO userevents (usertoken, eventtoken) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $usertoken, $eventtoken);
                $stmt->execute();
                $responseContent = "Attending";
            }  
        }
        else {
            $userloggedin = "notloggedin";
            $responseContent =
            "
            <div class='modal-container'>
                <div class='modal-click-catcher' role='btn'></div>
                    <div class='auth-modal'>
                        <div class='auth-modal-header'>
                            <div class='center-modal-header'>
                                <h3>Log in</h3>
                            </div>
                            <button class='close-modal-btn'>
                                <i class='fas fa-times'></i>
                            </button>
                        </div>
                        <div class='auth-modal-body'>
                            <div class='modal-welcome-msg-wrapper'>
                                <h2>Welcome to Buzzerr</h2>
                            </div>
                            <form class='auth-modal-form' action='controllers/authController.php' method='post' enctype='multipart/form-data'>
                                <div class='input-group'>
                                    <label>Email Address</label>
                                    <input name='useremail' placeholder='you@university.edu' type='email'>
                                </div>
                                <div class='input-group'>
                                    <label>Password</label>
                                    <input name='userpassword' placeholder='•••••••••••••••' type='password'>
                                </div>
                                <div class='sign-up-btn-wrapper'>
                                    <button type='submit' name='signin'>Continue</button>
                                </div>
                                <div class='bottom-form-msg-wrapper'>
                                    <span>Don't have an account?</span>
                                    <a href='signup.php'>Sign up</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }

        header('Content-Type: application/json');
        $response;

        $response->result = $userloggedin;
        $response->content = $responseContent;

        echo json_encode($response, JSON_FORCE_OBJECT);
    }

    if (isset($_POST['loadEvents'])) {
        $sql = "SELECT * FROM events LIMIT 8";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $banner = $row['eventbanner'];
            $description = $row['eventdescript'];
            $date = $row['eventdate'];
            $token = $row['eventtoken'];
            $buttonText = "Attend event";

            $sql1 = "SELECT * FROM userevents WHERE eventtoken='$token'";
            $result1 = mysqli_query($conn,$sql1);
            while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                if ($row1['usertoken'] == $usertoken) {
                    $buttonText = "Attending";
                }
            }
            
            echo "
            <div class='event-card' data-event-token=" . $token . ">
                <div class='banner-image'>
                    <img src=" . $banner . ">
                </div>
                <div class='event-content'>
                    <div class='event-description'>
                    " . $description . "
                    </div>
                    <div class='gray-border'></div>
                    <div class='event-date'>
                        <span>" . $date . "</span>
                    </div>
                </div>
                
                <div class='attend-event-btn-wrapper'>
                    <button class='attend-event-btn' name='attend-btn'>" . $buttonText . "</button>
                </div>
                
            </div>
            ";
        }  
    }
?>