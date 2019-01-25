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
*{margin:0;}
li{list-style:none;}
a{text-decoration: none;}
#or{color:silver; margin-left:0px;}	
.fa-header
{
	height:200px;
	width:auto;
	background: linear-gradient(#000000, #FFFFFF);
}
.fa-fa-header-user
{
	text-align:right;
	position:absolute;
	top:0px;
	right:0px;
	height:30px;
	width:100%;
	background: black;
	box-shadow:0 0 100px rgba(0,0,0,0.3);
}
.fa-fa-header-user-login
{
	position:absolute;
	top:5px;
	right:5px;
}
#fa-fa-header-name-site
{
	position:absolute;
	top:21px;
	left:20px;
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:50px;
}




#fa-fa-header-user-login-href
{
	cursor:pointer;
	height:25px;
	width:60px;
	color: white;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	background: none;
}
#fa-fa-header-user-login-input-logout
{
	cursor:pointer;
	height:25px;
	width:60px;
	color: white;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	background: none;
}






#fa-fa-header-user-login-hello_text
{
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:17px;
}






.fa-fa-header-enum
{
	position:absolute;
	top:100px;
	right:30%;
}
#fa-fa-header-enum-user
{
	cursor:pointer;
	font-size:25px;
	font-weight:bold;
	color:white;
	transition:0.5s;
}
#fa-fa-header-enum-user:hover
{
	margin-left:10px;
	font-size:25px;
	font-weight:bold;
	color:white;
	box-shadow:0 0 100px rgba(0,0,0,0.3);
	transition:0.5s;
}
#fa-fa-header-enum-game
{
	cursor:pointer;
	font-size:25px;
	font-weight:bold;
	color:white;
	transition:0.5s;
}
#fa-fa-header-enum-game:hover
{
	margin-left:10px;
	font-size:25px;
	font-weight:bold;
	color:white;
	box-shadow:0 0 100px rgba(0,0,0,0.3);
	transition:0.5s;
}


</style>
<!DOCTYPE html>
<html>
<head>
<title>ZloGame</title>
<link rel="stylesheet" href="styles_index.css">
</head>
 <body>
  <div class="fa-header">
  <div class="fa-fa-header-name">
   <text id="fa-fa-header-name-site">ZloGawe</text>
  </div>
	<div class="fa-fa-header-user">
	 <div class="fa-fa-header-user-login">
	  <?php if(!isset($_COOKIE["user"])){?>
        <a href="log.php"><text  id="fa-fa-header-user-login-href">Вход</text></a>
		<text id="or">или</text> 
		<a href="reg.php"><text id="fa-fa-header-user-login-href">Регистрация</text></a>
	   </form>
	  <?php }else{?>
	   <form action="" method="post">
	    <text id="fa-fa-header-user-login-hello_text"><?php echo "<b>Привет, пользователь ".$_COOKIE["user"]."<b>"; ?></text>
		<input id="fa-fa-header-user-login-input-logout" type="submit" name="logout" value="Выйти"></input>
	   </form>
	  <?php }?>
	  
	 </div>
	 </div>
	 <div class="fa-fa-header-enum">
	  <ul>
	  <li><text id="fa-fa-header-enum-user">Нас уже более <?php echo $_count_us?></text></li>
	  <li><text id="fa-fa-header-enum-game">Загружено более <?php echo $_count_ga?> игор</text></li>
	  </ul>
	 </div>
   </div>




<?php if(isset($_COOKIE["user"])){?>
<br>
<div class="">
<form action="" method="post">
		<input type="checkbox" name="1_game_gender" value="shuters">Стрелялки</input>
		<input type="checkbox" name="2_game_gender" value="strategies">Стратегии</input>
		<input type="checkbox" name="3_game_gender" value="sports">Спортивные</input>
		<input type="checkbox" name="4_game_gender" value="race">Гонки</input>
		<input type="checkbox" name="5_game_gender" value="Adventure">Бродилки</input>
		<input type="checkbox" name="6_game_gender" value="coloring_pages">Раскраски</input>
		<input type="submit" name="find" value="Найти"></td>
</form>
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