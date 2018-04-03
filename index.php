<style>
	pre {font-family: courier, serif, size: 10pt; margin: 0px 8px;}
</style>

<pre>
 Date   Fajr   Sunrise  Dhuhr    Asr   Sunset  Maghrib  Isha 
-------------------------------------------------------------


	<?php

	// get user ip
	$ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	$url = "http://freegeoip.net/json/$ip";
	$ch  = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	$data = curl_exec($ch);
	curl_close($ch);

	if ($data) {
		$location = json_decode($data);

		$lat = $location->latitude;
		$lon = $location->longitude;


		print_r($location); die;
	}





	include('PrayTime.php');
	list($method, $year, $latitude, $longitude, $timeZone) = array(5, 2018 , 30, 31, +2);  // $method = "5";  // Egyptian General Authority of Survey
    $date = strtotime($year. '-4-3');  
	$prayTime = new PrayTime($method);
    $times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);

	$day = date('M d', $date);
	print $day. "\t". implode("\t", $times). "\n";
 


?>
</pre>