<?php 
	$con = mysqli_connect("localhost", "root", "", "urlshortner") or die("Connection error: ". mysqli_error());

	if(isset($_POST['url'])){
		$url = $_POST['url'];
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = preprocess($url);
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			$url = mysqli_real_escape_string($con,$url);
			$uniqueUrl = randomUrl();
			$host = "http://localhost/url/";
			$ins = mysqli_query($con, "insert into `urlshort` set url='$url', short='$uniqueUrl'") or die();
			if($ins){
				$output = successCreatingURL($url,$host,$uniqueUrl);
				$finalURL = $host.$uniqueUrl;
				$processResult=1;
			}
			else{
				$processResult=0;
			}
		} 
		else {
			header("Location: index.php");
		}
	}
	function randomUrl(){
		$str = '';	$length = 6;	$i = 0;
		$possible = "23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ";
		while ($i < $length) {
			$str .= substr( $possible, mt_rand( 0, strlen( $possible )-1 ), 1 );
			$i++;
		}
		return $str;
	} 

	function successCreatingURL($url, $host, $uniqueUrl){ 
		$finalURL = $host.$uniqueUrl;
		$done = "<p style='font-size: 20px;'>Your short url is created!</p><br>";

		$printURL =  "<p><input id='myInput' 
			style = 'width: 312px;font-size: 20px; font-family: 'jamun';'
			type='text' value='".$host.$uniqueUrl."' onclick='select_text();' readonly='readonly'>";

		$buttons = "<br><button class='searchButton' onclick='copyFunction()'>Copy URL</button> 
		<div id='disable'><button class='searchButton' onclick='showQR()'>Generate QR</button></div>
		<br></p>
		<canvas id='qr-code' align='center' class='qrcode'></canvas>";

		$redirects =  "<br><br><p class='showURLFinal'>This URL redirects to <a href='".$url."'>".$url."&nbsp;<img src='assets/images/redirect.png' style='width: 15px;'></a></p>";  
		$output = $done.$printURL.$buttons.$redirects;
		return $output;  		
	}

	function preprocess($publicUrl) {

		$http = "https://";
		$ww = "www.";
		$needed=$publicUrl;
		$finalpuburl=$publicUrl;
		
		if(substr($publicUrl, 0, 4) == "http") {
			// No operation since the user entered correctly
			$finalpuburl=$publicUrl;
		}
		else if(substr($publicUrl, 0, 3) == "www") {
			$publicUrl = $http . $needed; 
			$finalpuburl=$publicUrl;
			// Assuming the User missed the http:// or https:// but started the url with www.abcd.com
		}
		else if(substr($publicUrl, 0, 3) != "www") {
			
					if(substr($publicUrl, 0, 3) != "htt") {
						$publicUrl = $http . $ww . $needed;
						$finalpuburl = $publicUrl;
					}
		}
		return $finalpuburl;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>URL-IT!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shorten Your URL">
	<meta name="keywords" content="url">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>
<body onload="processChecker()">
    <div class="wrapper indexPage" id="successCreatingURL">
        <div class="mainSection">
            <div class="logoContainer"><br>
			<img src="assets/images/urlit.png" title="Proof! Logo" alt="Site Logo"/>
		</div>
            <div class="searchContainer">
            	<?php
					echo $output;
				?>
            </div>
        </div>
         <div class="information">
            <center><br><p align="center" class="headertab" style="font-size: 20px;" font-family="jamun">
            	<a href = "index.php">Shorten Another URL </a>&nbsp;<img src='assets/images/redirect.png' style='width: 15px;'>&emsp;</p></center>
        </div>    
    </div>

	<div class="wrapper indexPage" id="urlCreationFailed">
	    <div class="mainSection">
	        <div class="logoContainer"><br>
		</div>
	        <div class="searchContainer">
	        	<center><br>
	        		<p align="center" class="headertab" style="font-size: 20px;" font-family="jamun">The shortened URL you selected is already taken. Try something more unusual.</p>
	        	</center><br>
	        </div>
	    </div>
	    <div class="information">
            <center><br><p align="center" class="headertab" style="font-size: 20px;" font-family="jamun">Try Once More with another SHORT name. <a href = "index.php">Url-IT</a>&emsp;</p></center><br><br>
        </div>       
	</div>
	<script>
		var check = <?php echo $processResult; ?>;
		var myVar = setInterval(processChecker, 2000);
		function processChecker(check) {
		  var x = document.getElementById("successCreatingURL");
		  var y = document.getElementById("urlCreationFailed");
		  if (check == 0) {
		    x.style.display = "none";

		  } else {
		    y.style.display = "none";
		  }
		}
	</script>
	<script src="assets/js/script.js"></script>
</body>
</html>