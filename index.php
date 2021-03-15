<?php
    session_start();
    $con = mysqli_connect("localhost", "root", "", "urlshortner") or die("Connection error: ". mysqli_error());
    if(isset($_REQUEST['uri'])){
        $req = mysqli_real_escape_string($con, $_REQUEST['uri']);
        $get = mysqli_query($con, "select * from urlshort where short='$req'");
        $url = mysqli_fetch_array($get);
        $tester = substr($req, -1);

        if($tester=='-'){
            $_SESSION['short'] = $req;
            header('location: info.php');
            die();
        }
        elseif(mysqli_num_rows($get) == 0){
            echo "Error invalid url".$req;
            exit();
        }
        else{
            header('location: '.$url['url']);
            exit();
        }	
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
</head>
<body>
    <div class="wrapper indexPage">
        <div class="mainSection">
            <div class="logoContainer"><br>
			<img src="assets/images/urlit.png" title="Proof! Logo" alt="Site Logo"/>
			<center><h4>Enter URL To shorten!</h4></center>
		</div>
            <div class="searchContainer">
                 <form action="create.php" method="POST">
                    <input class="searchBox" type="text" name="url" placeholder="https://" required/>
                    <br>
                    <input class="searchButton" type="submit" value="Short it!">
                    <br>
                </form>		
            </div>
        </div>       
    </div>
</body>
</html>