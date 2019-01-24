<?php
	$database_connect = true;
	$server_connect = true;
	$server_tb_name = "users";
	$server_tb_name_2 = "games";
	$server_name = "localhost";
	$database_name = "maindb";
	$table_name = "users";
	$user_name = "root";
	$user_pass = "";
	$email = null;
	$pass = null;
	$error = null;
	$game_genders = [];
	$_count_us = 0;
	$_count_ga = 0;
	$_count_of_users = null;
	$_count_of_games = null;
	
	/*Здесь мы проверяем соединение с сервером и базой данных*/
	try{$conn = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);}
	catch(PDOException $e){$database_connect = false; $server_connect = false; header("Location: 404.php");}
	
	/*Если мы присоединиль к серверу и бд то заупскаем работу сайта*/
	if($database_connect  && $server_connect)
	{
		/*Здесь мы провряем сколько игор и пользователей на сайте*/
		$connection = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM $server_tb_name";
		$_count_of_users = $connection->query($sql);
		foreach($_count_of_users as $_user)
		{
			$_count_us += 1;
		}
		$sql = "SELECT * FROM $server_tb_name_2";
		$_count_of_games = $connection->query($sql);
		foreach($_count_of_games as $_game)
		{
			$_count_ga += 1;
		}
		$connection = null;
		
		
		/*Вот здесь мы проверяем нажал ли пользователь кнопу выйти из аккаунта и при этом он должен быть авторизирован*/
		if(isset($_POST["logout"]) && isset($_COOKIE["user"]))
		{
			unset($_COOKIE["user"]);
			setcookie("user", $email, time()-1);
		}
		
		/*Здесь мы проверяем нажалли пользователь кнопу играть и при этом он должен быть авторизирован*/
		if(isset($_POST["play"]) && isset($_COOKIE["user"]))
		{
			header("Location: game.php");
		}
		
		/*Здесь мы принимаем входящие значения изформы для поиска игры*/
		if(isset($_POST["find"]) && isset($_COOKIE["user"]))
		{
			$game_genders = [];
			for($i=1; $i<=6; $i++)
			{
				if(isset($_POST[$i."_game_gender"]))
				{
					array_push($game_genders, $i."_game_gender");
				}
			}
		}
		
		/*Здесь мы проверяем нажал ли пользовтель кнопку ввойти*/
		if(isset($_POST["login"]))
		{
			
			/*Проверка введеного*/
			$error = false;
			$email = htmlspecialchars(strip_tags(trim($_POST["email"])));
			$pass = htmlspecialchars(strip_tags(trim($_POST["pass"])));		
			if($email == "" || $pass == "")
			{$error = true;}
			
			/*Есл все ок тогд проверяем совпадение EMAIL и PASSWORD*/
			if($error == false)
			{
				$connection = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM $server_tb_name";
				$information = $connection->query($sql);
				foreach($information as $info)
				{
					if($info["email"] == $email && $info["password"] == $pass)
					{
						setcookie("user", $email, time()+86400);
						header("Location: index.php");
						break;
					}else{echo "<script>alert(\"Ошибка: неверный пароль или почта\");</script>";}
				}
				$connection = null;
			}else{header("Location: index.php");}
		}
		
	}
?>
<style>
body
{
	
}
.info
{
	font-size:25px;
	color:white;
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
}
*{margin:0;}
#title
{
	cursor:pointer;
	font-size:50px;
	color:white;
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
}
hr
{
	margin-top:50px;
	border:0;
	border-top: 5px solid black;
}
b
{
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
}



#image
{
	height:300px;
	border:0;
	background:url(pre_logo.png) no-repeat center;
	box-shadow: 0 0 20px rgba(0,0,0,0.5);
	transition:0.2s;
}
#image:hover
{
	box-shadow: 0 0 100px rgba(0,0,0,0.5);
	transition:0.2s;
}





input[type="submit"]
{
	cursor:pointer;
	border: 1px solid #cccccc;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	background: #ffffff !important;
	outline: none;
	height: 24px;
	width: 120px;
	color: #cccccc;
	font-size: 15px;
	font-family: Tahoma;
	box-shadow: 0 0 10px rgba(0,0,0,0.5);
}
input[type="button"]
{
	cursor:pointer;
	border: 1px solid #cccccc;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	background: #ffffff !important;
	outline: none;
	height: 24px;
	width: 120px;
	color: #cccccc;
	font-size: 15px;
	font-family: Tahoma;
	box-shadow: 0 0 10px rgba(0,0,0,0.5);
}
input[type="text"]
{
   border: 1px solid #cccccc;
   border-radius: 3px;
   -webkit-border-radius: 3px; 
   -moz-border-radius: 3px;
   -khtml-border-radius: 3px;
   background: #ffffff !important;
   outline: none;
   height: 24px;
   width: 120px;
   color: #cccccc;
   font-size: 15px;
   font-family: Tahoma;
   box-shadow: 0 0 10px rgba(0,0,0,0.5);
}
input[type="password"]
{
   border: 1px solid #cccccc;
   border-radius: 3px;
   -webkit-border-radius: 3px;
   -moz-border-radius: 3px;
   -khtml-border-radius: 3px;
   background: #ffffff !important;
   outline: none;
   height: 24px;
   width: 120px;
   color: #cccccc;
   font-size: 15px;
   font-family: Tahoma;
   box-shadow: 0 0 10px rgba(0,0,0,0.5);
}
input:hover
{
	box-shadow: 0 0 100px rgba(0,0,0,0.5);
	transition:0.2s;
}
input[type="checkbox"]
{
	cursor:pointer;
}

	
	#user_name
	{
		color:white;
		margin-left:-100px;
	}
	.game_form
	{
		width:500px;
		height:150px;
		border:2;
		box-shadow: 0 0 10px rgba(0,0,0,0.5);
		transition:1s;
	}
	.game_form:hover
	{
		box-shadow: 0 0 100px rgba(0,0,0,0.5);
		transition:0.2s;
	}
	.name
	{
		font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
	}
	.what
	{
		font-size:15px;
		font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
		margin-left:110px;
		margin-top:-100px;
	}
	.img_game
	{
		width:150px;
		height:120px;
		margin-right:400px;
		margin-top:10px;
	}
	.find_form
	{
		width:800px;
		height:100px;
		border:2;
		box-shadow: 0 0 10px rgba(0,0,0,0.5);
		transition:1s;
	}
	.find_form:hover
	{
		box-shadow: 0 0 100px rgba(0,0,0,0.5);
		transition:0.2s;
	}
	#email
	{
		color:white;
	}
	#pass
	{
		color:white;
	}
</style>
<!DOCTYPE html>
<html>
<head>
<title>ZloGame</title>
<link rel="stylesheet" href="styles_index.css">
</head>
<body>

<header id="header">
<fieldset id="image">
<center>
<tbody><table>
<tr>
	<td><b><text id="title">ZloGame</text></b><td>
</tr>
<tr>
	<?php if(!isset($_COOKIE["user"])){?>
	<form action="" method="post">
	<td id="email_area"><b id="email">E-mail:</b><input type="text" name="email"></input></td>
	<td id="pass_area"><b id="pass">Password:</b><input type="password" name="pass"></input></td>
	<td><input type="submit" name="login" value="войти"></input></td>
	<td><a href="reg.php"><input id="href_to_reg" type="button" value="регистрация"></input></a></td>
	</form>
	<?php }else{?>
	<form action="" method="post">
	<td><input type="submit" name="logout" value="выйти"></input></td>
	<td><text id="user_name"><?php echo "<b>Привет, пользователь ".$_COOKIE["user"]."<b>"; ?></text></td>
	</form>
	<?php }?>
</tr>
</table></tbody>

<br>
<br>

<tbody>
<table>
<tr>
	<td><text class="info">Нас уже более <?php echo $_count_us?></text></td>
</tr>
<tr>
	<td><text class="info">Загружено более <?php echo $_count_ga?> игор</text></td>
</tr>
</table>
</tbody>
</center>
</fieldset>
</header>

<?php if(isset($_COOKIE["user"])){?>
<br>
<center>
<form action="" method="post">
	<fieldset class="find_form">
	<tbody>
	<table>
	<tr>
		<td><input type="checkbox" name="1_game_gender" value="shuters">Стрелялки</input></td>
		<td><input type="checkbox" name="2_game_gender" value="strategies">Стратегии</input></td>
		<td><input type="checkbox" name="3_game_gender" value="sports">Спортивные</input></td>
		<td><input type="checkbox" name="4_game_gender" value="race">Гонки</input></td>
		<td><input type="checkbox" name="5_game_gender" value="Adventure">Бродилки</input></td>
		<td><input type="checkbox" name="6_game_gender" value="coloring_pages">Раскраски</input></td>
	</tr>
	<tr>
		<td><input type="submit" name="find" value="Найти"></td>
	</tr>
	</table>
	</tbody>
	</fieldset>
</form>
</center>
<?php }?>
<?php if(!isset($_COOKIE["user"])){?>
<br>
<center>
<form action="" method="post">
	<fieldset class="find_form">
	<tbody>
	<table>
	<tr>
		<td><input type="checkbox" name="1_game_gender" value="shuters">Стрелялки</input></td>
		<td><input type="checkbox" name="2_game_gender" value="strategies">Стратегии</input></td>
		<td><input type="checkbox" name="3_game_gender_" value="sports">Спортивные</input></td>
		<td><input type="checkbox" name="4_game_gender" value="race">Гонки</input></td>
		<td><input type="checkbox" name="5_game_gender" value="Adventure">Бродилки</input></td>
		<td><input type="checkbox" name="6_game_gender" value="coloring_pages">Раскраски</input></td>
	</tr>
	<tr>
		<td>Ввоийдите, чтобы искать</td>
	</tr>
	</table>
	</tbody>
	</fieldset>
</form>
</center>
<?php }?>
<?php if(isset($_COOKIE["user"])){
		$connection = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$select = "SELECT *";
		$from = " FROM $server_tb_name_2 WHERE gender IN(";
		$info = "";
		if(count($game_genders) == 1)
			{
				$info = "'".$game_genders[0]."')";
			}
			elseif(count($game_genders) == 0)
			{
				$info = "'1_game_gender')";
			}
			else{
				for($i=0; $i<count($game_genders); $i++)
				{
					if($i+1 == count($game_genders))
					{$info = $info."'".$game_genders[$i]."')";}
					else
					{$info = $info."'".$game_genders[$i]."',";}
				}
			}
		$sql = $select.$from.$info;

		$games = $connection->query($sql);
		foreach($games as $game){?>
<center>
<form action="game.php" method="post">
	<fieldset class="game_form">
	<tbody>
	<table>
	<tr>
		<td><b><text class="name"><?php echo $game["name"];?></text></b></td>
		<td><input type="hidden" value="<?php echo $game["game"]?>" name="url_game"></input></td>
		<td><input type="hidden" value="<?php echo $game["name"]?>" name="name_game"></input></td>
		<td><input type="hidden" value="<?php echo $game["type"]?>" name="type_game"></input></td>
	</tr>
	<tr>
		<td><img src="images_game\<?php echo $game['image'];?>" class="img_game"></img></td>
		<td><input class="play" type="submit" name="play" value="Играть"></input></td>
	</tr>
	</table>
	</tbody>
	</fieldset>
</form>
</center>
<?php $connection=null;}}?>
<?php if(!isset($_COOKIE["user"])){
		$connection = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM $server_tb_name_2";
		$games = $connection->query($sql);
		foreach($games as $game){?>
<center>
	<fieldset class="game_form">
	<tbody>
	<table>
	<tr>
		<td><b><text class="name"><?php echo $game["name"];?></text></b></td>
	</tr>
	<tr>
		<td><img src="images_game\<?php echo $game['image'];?>" class="img_game"></img></td>
		<td>Ввойдите, чтобы играть</td>
	</tr>
	</table>
	</tbody>
	</fieldset>
</center>
<?php $connection=null;}}?>


</body>
</html>