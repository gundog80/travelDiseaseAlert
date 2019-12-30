<?php
	include_once "country.php";

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	<?php
	include_once "./world.svg";
	?>

</body>
<script src="./jquery-3.4.1.min.js"></script>
<script>
	//svg滑入滑出
	let paths =$('path')

	$('path').mouseenter((event)=>{
		$('.svg').append(`<use id="upup" xlink:href="#${$(event.target).attr('id')}"/>`)
		$(event.target).attr('transform','translate(-5, -5)')
		$(event.target).attr('filter',"url(#filter1)")
		$(event.target).appendTo('svg')
	} )

	$('path').mouseleave((event)=>{
		$(event.target).attr('transform','translate(0, 0)')
		$(event.target).removeAttr('filter')
		$('#upup').remove()
	})
	//svg滑入滑出end

	let news=""
$(function(){
	getOpenData();
	// temp()
	setTimeout(	temp,3000)
	setTimeout(	getRow,3000)

});

	let getOpenData=function(){
		//取得opendata
		let url="https://www.cdc.gov.tw/CountryEpidLevel/ExportJSON"
		$.post("./api.php",{url},function(data){
			data=data.substring(0,data.indexOf(']')+1)
			news=JSON.parse(data)
			// console.log(news[0].Source);
			// console.log(news[0]);
		})
	}
	let temp= function(){
		// 測式用
			console.log(news[0]);
	}

	let try1=function(){
		// 測試用，開div
   console.log("hi")
	}

	let getRow=function(){
		// 取得單行資料(若為多國則再分)
	news.forEach(function temp1(row){
	// let row = news[0];
	// console.log(row)
		// row=JSON.parse(row);
	severityLevel=row.severity_level;
	alertDisease=row.alert_disease;
	countries=row.description;
	if (countries==""){
	// 	country=row.areaDesc
	// 	console.log(country)
	}else{
		console.log(countries)
		setTimeout(
		countries.split(","),
		1000
		)
		// countries.forEach(function temp2(country){
		console.log(countries)

		// }
		// )
	}

	})
	}


</script>
</html>