<?php 
include 'classes.php';
include 'header.php';
include 'TimezoneMapper.php';
$match = new Classes;
?>
<script type="text/javascript">
function selectCountry(val) {
$("#city_name").val(val);
$("#suggesstion-box").hide();
}
</script>
<div class="page-header">
	<div class="search-section">
		<form action="" id="search" method="post">
			<input type="text" name="city" id="city_name" placeholder="Enter City Name" autocomplete="off" />
			<input type="submit" name="submit" value="Search" class="search-submit" />
		</form>
		<div id="suggesstion-box"></div>
	</div>
</div>
<?php
if(isset($_POST["submit"]) && $_POST["city"]!=''){
	$city_value = $_POST['city'];
	$city_array = explode(",",$city_value);
	$cityName= $city_array[0];
	$country_name=$city_array[1];
	$city_details = $match->searchJSON($cityName,$country_name);
	$city_all_details = explode(",",$city_details);
	$city_id = $city_all_details[0];
	$city_long = $city_all_details[1];
	$city_lat = $city_all_details[2];
	$apiKey = "cb3fe0ae205efb9c06c5732182f851cd";
	$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $city_id . "&lang=en&units=metric&APPID=" . $apiKey;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($response);
	$timezone_city = TimezoneMapper::latLngToTimezoneString($city_lat, $city_long);
	$currentTime = time();
	$timezone = new DateTimeZone("$timezone_city");
	$date = new DateTime();
	$date->setTimezone($timezone );
	$currentTime = $date->format('l, g:i A ');
	$currentDate = $date->format("jS F Y, ")
?>
	<!-- Header Section   -->
    <div class="report-container">
        <h2><?php echo $data->name ?> Weather</h2>
        <div class="time">
            <span><?php echo $currentDate.$currentTime; ?></span>
        </div>
        <div class="weather-forecast">
            <div class="weather-status">
				<span><?php echo ucwords($data->weather[0]->description); ?><span>
				<img src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png" class="weather-icon" /> 
			</div>
			<div class="temprature">
			<span class="actual-temperature"><?php echo $data->main->temp_max; ?>&#176;C</span>
			<span class="max-min-temperature">Max: <?php echo $data->main->temp_max; ?>&#176;C</span>
			<span class="man-min-temperature">Min: <?php echo $data->main->temp_min; ?>&#176;C</span>
			</div>
        </div>
        <div class="time">
            <span>Humidity: <?php echo $data->main->humidity; ?> %</span>
            <span>Wind: <?php echo $data->wind->speed; ?> km/h</span>
        </div>
    </div>
<?php
}
?>
</body>