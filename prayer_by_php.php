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
		$latitude = round($location->latitude);
		$longitude = round($location->longitude);

		if($latitude != 0 && $longitude != 0 ){

		}else{// default egypt lat , lang
			$latitude = "30";
			$longitude = "31";
		}

	}



	include('PrayTime.php');

	$method = 5 ; // Egyptian General Authority of Survey
	$timeZone = +2 ;

	$date = strtotime(date("Y-n-j"));  // php date month and day without leading zero   ... Use j instead of d and n instead of m:


	$prayTime = new PrayTime($method);
	$prayTime->timeFormat = 1 ;  // 12-hour format
	$times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);

	$prayer_arra = array();
	foreach ($times as $key=>$value ){
		$prayer_arra[$prayTime->timeNames[$key]] = $value;
	}

	print_r($prayer_arra) ; die;

	/*
	$day = date('M d', $date);
	print $day . "\t" . implode("\t", $times) . "\n";
	*/

	?>
</pre>