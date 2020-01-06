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
	<style>
	.cn{
		margin:auto;
		text-align: center;
	}
	.title{
		width:98%;
		height:15vh;
	}
	#pageMark{
		display:flex;
		width:100%;
		margin:auto auto 0 auto;
		list-style-type:none;
	}
	#pageMark>li{
		font-size:1.5em;
		width:12%;
		border-width: 2px;
		padding:4px;
		background-color: #888;
		margin:2px;
		

	}
	.page{
		width:98%;
		height:83vh;
		overflow: auto;
	}
	#alertDisease{
		background-color: #ccc;
		position:absolute;
		width:15%;
		min-height: 5%;
		display:none;
	}
	#showTable{
		margin:5px auto;

	}
	</style>
</head>
<body>
	<div class="title cn">
		<h1>作業練習-國際旅遊疾病警報</h1>
		<ul id=pageMark>
			<li data-MarkNum=0>地圖檢示</li >
			<li data-MarkNum=1>列表檢示</li>
			<!-- <li data-MarkNum=2>警報統計</li > -->
		</div>

	<div class="page" data-pageNum=1 id=mapDiv>
		<div id=alertDisease>
			<fieldset>
				<legend>cName</legend>
			</fieldset>
		</div>
		<?php
		include_once "./world.svg";
		?>

	</div>
	<div class="page" data-pageNum=2>
		<table id=showTable border=1>
			<tr>
				<td style="width:20%">警報地區/國家</td >
				<td style="width:15%">警報等級</td> 
				<td style="width:65%">詳細資訊</td> 
			</tr>
		</table>
	</div>
	<!-- <div class="page" data-pageNum=3>
		333
		<canvas id="myChart" width="400" height="400"></canvas>
	</div> -->

</body>

<script src="./jquery-3.4.1.min.js"></script>
<?php
?>
<script>
	//-------------變數宣告
	let countryCode=<?php echo json_encode($countryCode); ?>;
	let countryEn=<?php echo json_encode($countryEn); ?>;
	let countryCh=<?php echo json_encode($countryCh); ?>;
	let temp=new Array();
	let alarms=new Array();
	let news="";
	let alarmCountryArr=new Array;
	let alarmCountryTable=new Array;
	let alarmArr=new Array;
	let alarmTable={};
</script>

<script>
	//------------監聽事件
	//頁籤切換
	$('#pageMark>li').on('click',function(){
		$('.page').hide();
		$('.page').eq( $(this).attr('data-markNum') ).show()
	})	
	//svg滑入滑出
	$('path').mouseenter((event)=>{
		$(event.target).attr('transform','translate(-5, -5)')
		$(event.target).attr('filter',"url(#filter1)")
		$(event.target).appendTo('svg');

		let cID=$(event.target).attr('id');
		let cName=countryCh[$.inArray(cID,countryCode)];
		$('#alertDisease legend').text(cName);
		let temp=$.inArray(cName,alarmCountryArr);
		if(temp>=0){
			let temp1=alarmCountryTable[temp].alertDisease
			$('#alertDisease>fieldset').append(temp1);
		}else{
		}
		$('#alertDisease').show();
	} )

	$('path').mouseleave((event)=>{
		$(event.target).attr('transform','translate(0, 0)')
		$(event.target).removeAttr('filter')
		$('#alertDisease').hide();
		$('#alertDisease>fieldset').html("<legend>cName</legend>");
		$('#alertDisease legend').text("");
	})
	//svg滑入滑出end

$(function(){

	getOpenData();
	// setTimeout(() => {
	// writeMap
		
	// }, 4000);

	setTimeout(writeMap,4000)
	setTimeout(writeShowTable,4000)
	setTimeout(()=>{console.log(temp)},5000)
});

	let getOpenData=function(){
		//取得opendata
		let url="https://www.cdc.gov.tw/CountryEpidLevel/ExportJSON"
		$.post("./api.php",{url},function(data){
			data=data.substring(0,data.indexOf(']')+1)
			news=JSON.parse(data)
		})

		setTimeout(getRow,2500)
			//等待2.5秒完成後呼叫getRow
	}
	let getRow=function(){
	// 取得單行資料(severityLevel,alertDisease,countries[])
		news.forEach(function temp1(row){
		// let row = news[50];
		//----------
			severityLevel=row.severity_level.substr(0,3);

			alertDisease=row.alert_disease;
			countries=row.description;
			country=row.areaDesc
			//---------------
			findID();
		})
	}
	let findID=function(){
		// console.log(country)
		// console.log(severityLevel)
		// console.log(alertDisease)
		let temp3=$.inArray(country,countryCh);
		if(temp3>=0){
			countryID=countryCode[temp3];
			//-----------------
			writeData()
		}else{
			temp[temp.length]=country;
			countryID="";
			//-----------------		}
			writeData()
			
		}

	}
	let writeData=function(){
		// console.log(alarmCountryArr)
		let levelArr=["第一級","第二級","第三級"]
		// alarms.forEach((al)=>{
		let temp1=$.inArray(country,alarmCountryArr)
		let temp2=$.inArray(alertDisease,alarmArr)
		if(temp1<0){
			alarmCountryArr[alarmCountryArr.length]=country
			alarmCountryTable[alarmCountryTable.length]={country:country,countryID:countryID,'severityLevel':severityLevel,'alertDisease':alertDisease + ":" + severityLevel};
		}else{
			alarmCountryTable[temp1].alertDisease=alarmCountryTable[temp1].alertDisease+","+alertDisease + ":" + severityLevel
			if($.inArray(severityLevel,levelArr)>$.inArray(alarmCountryTable[temp1].severityLevel,levelArr)){
				alarmCountryTable[temp1].severityLevel=severityLevel
			}
		}
		if(temp2<0){
			alarmArr[alarmArr.length]=alertDisease
			alarmTable[alertDisease]=1;
		}else{
			alarmTable[alertDisease]++;
		}
			// console.log(alarmCountryTable)
		// writeMap();	
	}
	let writeMap=function(){
		console.log(alarmCountryTable)
		alarmCountryTable.forEach((cData)=>{
			if(cData.countryID!=""){
				$(`#${cData.countryID}`).attr(`data-Level`,cData.severityLevel)
				$(`#${cData.countryID}`).attr(`data-detail`,cData.alertDisease)
				if(cData.severityLevel=="第一級"){
					$(`#${cData.countryID}`).css('fill',"#dd9999")
				}
				if(cData.severityLevel=="第二級"){
					$(`#${cData.countryID}`).css('fill',"#ff6666")
				}
				if(cData.severityLevel=="第三級"){
					$(`#${cData.countryID}`).css('fill',"#ff3333")
				}
			}
			
		})
		// setTimeout(writeShowTable,2000)
	}
	let writeShowTable=function(){
		console.log(alarmCountryTable.length)
		alarmCountryTable.forEach((cData)=>{
			if(cData.countryID!=""){
				$('#showTable>tbody').append(`
				<tr>
					<td>${cData.country}</td>
					<td>${cData.severityLevel}</td>
					<td>${cData.alertDisease}</td>
				</tr>
				`)
			}
		})
		// setTimeout(writeChart,2000)
	}
	let writeChart=function(){
		
	}
	// let writeAlarm=function(){
	// 	alarms[alarms.length]={'countryID':countryID,'country':country,'severityLevel':severityLevel,'alertDisease':alertDisease }
	// }
	// let writeTable=function(){
	// 	// let alarmCountryArr=new Array;
	// 	// let alarmCountryTable=new Array;
	// 	alarms.forEach((al)=>{
	// 		let temp=$.inArray(al.country,alarmCountryArr)
	// 		let levelArr=["第一級","第二級","第三級"]
	// 		if(temp<0){
	// 			alarmCountryArr[alarmCountryArr.length]=al.country
	// 			alarmCountryTable[alarmCountryTable.length]={country:al.country,countryID:al.countryID,'severityLevel':al.severityLevel,'alertDisease':al.alertDisease + ":" + al.severityLevel};
	// 		}else{
	// 			alarmCountryTable[temp].alertDisease=alarmCountryTable[temp].alertDisease+","+al.alertDisease + "-" + al.severityLevel
	// 			if($.inArray(al.severityLevel,levelArr)>$.inArray(alarmCountryTable[temp].severityLevel,levelArr)){
	// 				alarmCountryTable[temp].severityLevel=al.severityLevel
	// 			}
	// 		}


	// 	})
	// 		console.log(alarmCountryTable)
	// 		setTimeout(() => {
	// 		console.log(alarmCountryTable)
				
	// 		}, 1000);
	// }


	// let writeData=function(){
	// 	console.log(countries)
	// 	countries.forEach(function temp2(country){
	// 		console.log(country)

	// 	})

	// }




		// countries.forEach(function temp2(country){
		// }
		// )
	

	// })
	


</script>
</html>