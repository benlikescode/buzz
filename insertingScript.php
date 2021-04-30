<?php
    include('../config/db.php');

    $banner = "https://media-exp1.licdn.com/dms/image/C561EAQFdKULKcC5jWg/event-background-image-shrink_200_800/0/1599069229515?e=1619730000&v=beta&t=ii5yjT7tpEt1i_xv0F7jxSDS1q4_kVIOKadSTVPWeL8";
    $description = "Ontario Virtual Job Fair - May 22nd";
    $date = "Mon, May 10, 6:00 PM";
    

    $counter = 0;
    while ($counter < 8) {
        $token = bin2hex(random_bytes(6));
        $sql = "INSERT INTO events (eventbanner, eventdescript, eventdate, eventtoken) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $banner, $description, $date, $token);
        $stmt->execute();
        $counter = $counter + 1;
    }

    

?>



               