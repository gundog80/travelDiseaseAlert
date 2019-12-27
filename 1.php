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

<script src="./jquery-3.4.1.min.js"></script>
</body>
<script>
	//svg滑入滑出
	$('path').mouseenter((event)=>{
		$(event.target).attr('transform','translate(-5, -5)')
		$(event.target).attr('filter',"url(#filter1)")
	} )

	$('path').mouseleave((event)=>{
		$(event.target).attr('transform','translate(0, 0)')
		$(event.target).removeAttr('filter')
	})
	//svg滑入滑出end

</script>
</html>