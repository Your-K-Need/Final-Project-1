<?php
    function returnGreeting(){
        date_default_timezone_set('Asia/Jakarta');
        $hour = date('G');
        $dayTerm = ($hour > 17) ? "Evening" : (($hour > 10) ? "Afternoon" : "Morning");
        return "Good " . $dayTerm;
    }
?>
