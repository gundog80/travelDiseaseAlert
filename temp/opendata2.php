<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
	tr>td:nth-child(8){
		width:100px;
		color:red;
	}
	</style>
</head>
<body>

<?php
    // 初始化 curl
    $curl = curl_init();

    // 設定發出請求的瀏覽器
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36");

    // 設定接受所有 https 憑證，不做驗證
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 

    // 設定跟隨重新導向
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 

    // 重新導向時自動設定訪客來源 referer
    curl_setopt($curl, CURLOPT_AUTOREFERER, true); 

    // 將回傳資料寫入變數，而不是直接輸出
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

    curl_setopt($curl, CURLOPT_URL, "https://www.cdc.gov.tw/CountryEpidLevel/ExportJSON");
    // curl_setopt($curl, CURLOPT_URL, "https://bsb.kh.edu.tw/afterschool/opendata/afterschool_json.jsp?city=21");

    $data = curl_exec($curl);

	curl_close($curl);
	
	if(preg_match('/^\xEF\xBB\xBF/',$data))    //去除可能存在的BOM
{
    $data=substr($data,3);
}

    // 將JSON文字轉為可使用的陣列`
    // true 轉陣列，false 轉物件
	$json = json_decode($data,true);
	// echo $data;
	// echo $json;
	// print_r($json);

?>
 <!-- <table border="1">
    <tr>
        <th>地區縣市</th>
        <th>短期補習班名稱</th>
        <th>短期補習班類別</th>
        <th>地址</th>
        <th>立案時間</th>
        <th>各地短期補習班數量</th>
    </tr> -->
		<table border=1>
			<tr>
    	<?php
			$title=$json[0];
			// print_r($temp);
			// $title = json_decode($temp,true);
			foreach ($title as $k => $v){
		?>
				<td>
					<?php echo $k; ?>			
				</td>	
		<?php 
			} 
			echo "</tr>";
			foreach ($json as $row){
				echo "<tr>";
					foreach ($row as $v){
						echo "<td>";
						echo $v;
						echo "</td>";
					}
				echo "</tr>";

			}
			
		?>
	
	
	
	
	
	
	</table>





                <!-- <tr>
                    <td><?=$value["地區縣市"]?></td>
                    <td><?=$value["短期補習班名稱"]?></td>
                    <td><?=$value["短期補習班類別"]?></td>
                    <td><?=$value["地址"]?></td>
                    <td><?=$value["立案時間"]?></td>
                    <td><?=$value["各地短期補習班數量"]?></td>
                </tr> -->
            <?php
        // }
    ?>
<!-- </table> -->
    
</body>
</html>