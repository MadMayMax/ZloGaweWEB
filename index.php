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
			for($i=1; $i<=12; $i++)
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
						setcookie("user", $info["username"], time()+86400);
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


input[type="checkbox"]{cursor:pointer;}
*{margin:0;  border-radius:5px;}
li{list-style:none;}
a{text-decoration: none;}
#or{color:silver; margin-left:0px;}	
.fa-header
{
	height:200px;
	width:auto;
}
.fa-fa-header-user
{
	text-align:right;
	position:absolute;
	top:0px;
	right:0px;
	height:30px;
	width:100%;
	background-color: black;
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
	text-align:center;
	margin-left:40%;
	position:absolute;
	top:21px;
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:50px;
	background:black;
	width:300px;
	border-bottom-left-radius:50px;
	border-bottom-right-radius:50px;
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
#fa-fa-header-user-login-href_2
{
	cursor:pointer;
	height:25px;
	width:60px;
	color:black;
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




.fa-body-menu
{
	margin-top:10px;
	margin-left:20%;
}
.fa-body-menu-form
{
	width:200px;
	height:400px;
	background-color: rgba(0, 120, 201, 0.2);
	border-left:solid #1E90FF;
	border-left-width:10px;
	border-top:0;
	border-right:0;
	border-bottom:0;
}

.fa-body-game_form
{
	cursor:pointer;
	text-align:center;
	width:200px;
	height:160px;
	background-color: rgba(0, 120, 201, 0.2);
	border-left:solid #1E90FF;
	border-left-width:15px;
	border-top:0;
	border-right:0;
	border-bottom:0;
	transition:1s;
}
.fa-body-game_form:hover
{
	margin-left:20px;
	width:250px;
	transition:1s;
}

#fa-body-game_form-game-name
{
	cursor:pointer;
	font-size:15px;
	color:black;
	font-family:ms sans serif;
	font-weight:bold;
}
.fa-body-game
{
	position:absolute;
	top:191px;
	margin-left:35%;
	width:500px;
}
.img_game
{
	width:150px;
	height:100px;
}
.fa-body-menu-form-gender
{
	text-align:center;
	background:rgba(0, 120, 201, 0.4);
	border-left:solid #1E90FF;
	border-right:0;
	border-top:0;
	border-bottom:0;
	height:10px;
	width:auto;
}
.fa-body-menu-form-input-find
{
	cursor:pointer;
	height:25px;
	width:60px;
	color: black;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	background: none;
}
.fa-body-game_form-input-play
{
	cursor:pointer;
	height:25px;
	width:60px;
	color: black;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	background: none;
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
				<?php }else{?>
					<form action="" method="post">
						<text id="fa-fa-header-user-login-hello_text"><?php echo "<b>Привет, пользователь ".$_COOKIE["user"]."<b>"; ?></text>
						<input id="fa-fa-header-user-login-input-logout" type="submit" name="logout" value="Выйти"></input>
					</form>
				<?php }?>
			</div>
		</div>
	 <!--<div class="fa-fa-header-enum">
	  <ul>
	  <li><text id="fa-fa-header-enum-user">Нас уже более <?php echo $_count_us?></text></li>
	  <li><text id="fa-fa-header-enum-game">Загружено более <?php echo $_count_ga?> игор</text></li>
	  </ul>
	 </div>-->
   </div>



<div class="fa-body">
<?php if(isset($_COOKIE["user"])){?>
<div class="fa-body-menu">
<fieldset class="fa-body-menu-form">
<form action="" method="post">
 <ul>
  <li><input class="fa-body-menu-form-input-find" type="submit" name="find" value="Найти"></li><br>
  <li><fieldset class="fa-body-menu-form-gender">Для мальчиков</fieldset></li>
  <li><input type="checkbox" name="1_game_gender" value="shuters">Стрелялки</input></li>
  <li><input type="checkbox" name="2_game_gender" value="strategies">Стратегии</input></li>
  <li><input type="checkbox" name="3_game_gender" value="sports">Спортивные</input></li>
  <li><input type="checkbox" name="4_game_gender" value="race">Гонки</input></li>
  <li><input type="checkbox" name="5_game_gender" value="Adventure">Бродилки</input></li><br>
  
  <li><fieldset class="fa-body-menu-form-gender">Для девочек</fieldset></li>
  <li><input type="checkbox" name="6_game_gender" value="coloring_pages">Раскраски</input></li>
  <li><input type="checkbox" name="7_game_gender" value="shuters">Куклы</input></li>
  <li><input type="checkbox" name="8_game_gender" value="strategies">Одевалки</input></li>
  <li><input type="checkbox" name="9_game_gender" value="sports">Барби</input></li>
  <li><input type="checkbox" name="10_game_gender" value="race">Готовим еду</input></li>
  <li><input type="checkbox" name="11_game_gender" value="Adventure">Тесты</input></li>
  <li><input type="checkbox" name="12_game_gender" value="coloring_pages">Пони</input></li>
 </ul>
</form>
</fieldset>
</div>
<div class="fa-body-game">
		<?php
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
<br>
<form action="game.php" method="post">
	<fieldset class="fa-body-game_form">
		<ul>
			<li><text id="fa-body-game_form-game-name"><?php echo $game["name"];?></text></li>
			<li><input type="hidden" value="<?php echo $game["game"]?>" name="url_game"></input></li>
			<li><input type="hidden" value="<?php echo $game["name"]?>" name="name_game"></input></li>
			<li><input type="hidden" value="<?php echo $game["type"]?>" name="type_game"></input></li>
			<li><img src="images_game\<?php echo $game['image'];?>" class="img_game"></img></li>
			<li><input class="fa-body-game_form-input-play" type="submit" name="play" value="Играть"></input></li>
		</ul>
	</fieldset>
</form>
<?php $connection=null;}?></div><?php }?>
<?php if(!isset($_COOKIE["user"])){?>
<div class="fa-body-menu">
<fieldset class="fa-body-menu-form">
<form action="" method="post">
 <ul>
  <li><a href="log.php"><text id="fa-fa-header-user-login-href_2">Ввойти</text></a></li><br>
  <li><fieldset class="fa-body-menu-form-gender">Для мальчиков</fieldset></li>
  <li><input type="checkbox" name="1_game_gender" value="shuters">Стрелялки</input></li>
  <li><input type="checkbox" name="2_game_gender" value="strategies">Стратегии</input></li>
  <li><input type="checkbox" name="3_game_gender" value="sports">Спортивные</input></li>
  <li><input type="checkbox" name="4_game_gender" value="race">Гонки</input></li>
  <li><input type="checkbox" name="5_game_gender" value="Adventure">Бродилки</input></li><br>
  
  <li><fieldset class="fa-body-menu-form-gender">Для девочек</fieldset></li>
  <li><input type="checkbox" name="6_game_gender" value="coloring_pages">Раскраски</input></li>
  <li><input type="checkbox" name="7_game_gender" value="shuters">Куклы</input></li>
  <li><input type="checkbox" name="8_game_gender" value="strategies">Одевалки</input></li>
  <li><input type="checkbox" name="9_game_gender" value="sports">Барби</input></li>
  <li><input type="checkbox" name="10_game_gender" value="race">Готовим еду</input></li>
  <li><input type="checkbox" name="11_game_gender" value="Adventure">Тесты</input></li>
  <li><input type="checkbox" name="12_game_gender" value="coloring_pages">Пони</input></li>
 </ul>
</form>
</fieldset>
</div>
<div class="fa-body-game">
		<?php
		$connection = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM $server_tb_name_2";
		$games = $connection->query($sql);
		foreach($games as $game){?>
<br>		
<fieldset class="fa-body-game_form">
	<ul>
		<li><text id="fa-body-game_form-game-name"><?php echo $game["name"];?></text>
		<li><img src="images_game\<?php echo $game['image'];?>" class="img_game"></img></li>
		<li>Ввойдите, чтобы играть</li>
	</ul>
</fieldset>

<?php $connection=null;}?></div><?php }?>
</div>

</body>
</html>