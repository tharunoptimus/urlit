<?php 
session_start();
$short = $_SESSION['short'];
$con = mysqli_connect("localhost", "root", "", "urlshortner") or die("Connection error: ". mysqli_error());
$short = mysqli_real_escape_string($con, $short);
$short = substr($short, 0, -1);
$get = mysqli_query($con, "select * from urlshort where short='$short'");
$url = mysqli_fetch_array($get);
if(mysqli_num_rows($get) == 0){
    header('location: index.php');
    die();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>URL-IT!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shorten Your URL effortlessly and privately">
	<meta name="keywords" content="urlshortner, url, shortner, url shortner">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>
<body>
    <div class="wrapper indexPage">
        <div class="mainSection">
            <div class="logoContainer"><br>
			<a href="index.php"><img src="assets/imagesurlit.png" title="URL-IT Logo" alt="Site Logo"/></a>
		</div>
            <div class="searchContainer">
            	<?php
					echo runThis($url['url'], $short);
				?>
            </div>
        </div>       
    </div>
	<script src="assets/js/script.js"></script>
</body>
</html>

<?php
function runThis($url, $short){ 
	$pretty_name = "<a href='index.php'>https://url-it.rf.gd/</a><img src='assets/images/redirect.png' style='width: 15px;'>";
	$done = "<p style='font-size: 20px;'><b>The Shortened Link was created using ".$pretty_name." <br> Shortened links can redirect to any website on the internet. <br>You mustn't continue if you got this shortened link from suspicious sources.</b></p>";

	$printURL =  "<p><input id='myInput'
		style = 'width: 312px;font-size: 20px; font-family: 'jamun';'
		type='text' value='"."https://url-it.rf.gd/".$short."' onclick='select_text();' readonly='readonly'>";

	$buttons = "<br><button class='searchButton' onclick='copyFunction()'>Copy URL</button> 
	<div id='disable'><button class='searchButton' onclick='showQR()'>Generate QR</button></div>
	<br></p>
	<canvas id='qr-code' align='center' class='qrcode'></canvas>";

	$redirects =  "<br><br><p class='showURLFinal'>This URL redirects to <a href='".$url."'>".$url."&nbsp;<img src='assets/images/redirect.png' style='width: 15px;'></a></p>";  
	$output = $done.$printURL.$buttons.$redirects;
	return $output;  		
}
?>