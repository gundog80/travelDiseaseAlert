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

	// //測試 變色
	// $('path').on('click',(event)=>{
	// 	$(event.target).css('fill','red')
	// 	// $(event.target).removeAttr('filter')
	// 	// $('#upup').remove()
	// })

	let news=""
$(function(){
	getOpenData();

	

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
		setTimeout(getRow,2500)
			//等待2.5秒完成後呼叫getRow
	}
	let getRow=function(){
	// 取得單行資料(severityLevel,alertDisease,countries[])
		news.forEach(function temp1(row){
		// let row = news[50];
		//----------
			severityLevel=row.severity_level;
			alertDisease=row.alert_disease;
			countries=row.description;
			if (countries==""){  		//判別警戒是否是多國，並作相應處理
				country=row.areaDesc
				findID();
				// console.log(country)
			}else{
				countries=countries.substring(0,countries.indexOf('-'))
				// setTimeout(()=>{countriesToArr(countries)
				// },200)
				countries=countries.split(",")
				let getCountry=function(){
					countries.forEach(function temp2(country){
						// console.log(country)
						findID();
					})
				}
				setTimeout(getCountry,50)
			}
		})
	}
	let findID=function(){}
	// let writeData=function(){
	// 	console.log(countries)
	// 	countries.forEach(function temp2(country){
	// 		console.log(country)

	// 	})

	}




		// countries.forEach(function temp2(country){
		// }
		// )
	

	// })
	


</script>
</html>