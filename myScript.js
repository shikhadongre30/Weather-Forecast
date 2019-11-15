$(document).ready(function(){
	$("#city_name").on("keyup", function(){
		$.ajax({
				type: "POST",
				url: "suggestion.php",
				data:'city_name='+$(this).val(),
				success: function(data){
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#search-box").css("background","#FFF");
				}
				});
		});
});
