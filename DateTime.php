<?php
// It is the correct time selon my computer
date_default_timezone_set("Africa/Casablanca");

$current = time();//returns you the current time 
// echo $current;
$DateTemp = new DateTime();
$DateTemp->setTimestamp($current);
$DateTime = $DateTemp->format("F-d-Y H:i:s");

echo $DateTime;

// The problem why the time isn't right is that , the time returned is Xampp's time
// https://www.php.net/manual/fr/timezones.africa.php
?>