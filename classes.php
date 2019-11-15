<?php 
	class Classes{
		public function searchJSON($cityName,$country){
			$jsonitem = file_get_contents("city.list.min.json");
			$objitems = json_decode($jsonitem,true);
			foreach($objitems as $key){
				if($key['name']==$cityName && $key['country']==$country){
					$coord_array = $key['coord'];
					$city_details = $key['id'].",".$coord_array['lon'].",".$coord_array['lat'];
					return $city_details;
				}
			}			
		}
		public function suggestionJSON($city){
			$jsonitem = file_get_contents("city.list.min.json");
			$objitems = json_decode($jsonitem,true);
			echo '<ul class="suggestion-box">';
			foreach($objitems as $key){
				if(strpos(strtolower($key['name']), strtolower($city)) !== false ){
?>
<li onClick='selectCountry("<?php echo $key["name"].",".$key["country"]; ?>");'><?php echo $key['name']." ,".$key['country']; ?></li>
<?php
/*""*/
				}
			}
			echo '</ul>';
		}
	}
?>