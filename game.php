<?php
	/*
	$server_tb_name_2 = "games";
	$server_name = "localhost";
	$database_name = "maindb";
	$user_name = "root";
	$user_pass = "";*/
	$url = $_POST["url_game"]; 
	$name = $_POST["name_game"];
	$type = $_POST["type_game"];
?>
<style>
body
{
	background:black;
}
hr
{
	box-shadow: 0 0 50px rgba(255,255,255, 0.9);
}
#title
{
	cursor:pointer;
	color:white;
	font-size:50px;
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
}
#form_of_game
{
	margin-top:10px;
	width:700px;
	height:600px;
	box-shadow: 0 0 10px rgba(255,255,255, 0.9);
	transition:1s;
}
#form_of_game:hover
{
	cursor:pointer;
	box-shadow: 0 0 100px rgba(255,255,255, 0.9);
	transition:1s;
}
#name
{
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
	cursor:pointer;
	color:white;
}
.game-src
{
	margin-top:0px;
}
</style>
<!DOCTYPE html>
<html>
<head>
 <title><?php echo $name;?></title>
</head>
<body>
<center>
 <b><text id="title">ZloGame</text></b>
</center>
	<center>
	<center><b><text id="name"><?php echo $name;?></text></b></center>
	<br>
		<hr>
		<fieldset id="form_of_game">
		<?php if($type == "object"){?>
		<center>
		<object class="game-src" id="iplayer-game"  style="z-index: 2; display:block!important; background-color:black" id="swfgame_o" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" wmode="window" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="600px" height="600px">
		<embed id="swfgame_e" id="iplayer-game" src="<?php echo $url;?>" base="http://www.shockwave.com/content/plantsvszombies/sis/"  width="100%" height="100%" allowScriptAccess="always" allownetworking="all" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
        </embed>
        </object>
		</center>
		<?php }elseif($type == "iframe"){?>
		<center>
		<iframe class="game-src" width="600px" height="600px" src="<?php echo $url;?>" id="iplayer-game" scrolling="no" frameborder="0" allowtransparency="true" id="gameFrame" name="gameFrame"></iframe>
		</center>
		<?php }?>
		</fieldset>
	</center>
</body>
</html>