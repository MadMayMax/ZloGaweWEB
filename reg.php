<?php
	/*Create values*/
	$database_connect = true;
	$server_connect = true;
	$server_name = "localhost";
	$database_name = "maindb";
	$table_name = "users";
	$user_name = "root";
	$user_pass = "";
	$email = null;
	$pass = null;
	$ip_add = $_SERVER['REMOTE_ADDR'];
	$ip_add_proxy = $_SERVER['REMOTE_ADDR'];
	$error = null;
	$sql_create_database = null;
	$sql_create_table = null;
	$sql_export_info = null;
	$sql_import_info = null;
	$array_registed_email = [];
	$array_registed_pass = [];
	$array_error = [];
	
	
	
	/*Check connection error*/
	try{$conn = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass); $conn = null;}
	catch(PDOException $e){$database_connect = false; $server_connect = false;}
	

	if($database_connect && $server_connect)
	{
		if(isset($_POST["sign-in"]))
		{	
			$error = false;
			/*Create two values for export input info from form*/
			$username = htmlspecialchars(strip_tags(trim($_POST["username"])));
			$email = htmlspecialchars(strip_tags(trim($_POST["email"])));
			$pass = htmlspecialchars(strip_tags(trim($_POST["pass"])));
			
			/*
			#Cookie
			setcookie("name", $name, time()+60);
			setcookie("suranme", $surname, time()+60);
			*/
			
			/*If isset some so name or surname error*/
			$conn = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql_import_info = "SELECT * FROM $table_name";
			$result = $conn->query($sql_import_info);
			foreach ($result as $row)
			{
				array_push($array_registed_email, $row["email"]);
			}
			$conn = null;
			
			/*Check errors*/
			if($email == "" || $pass == "" || $username == "")
			{$error = true; array_push($array_error, "Одно из полей пустое");}
			elseif(is_numeric($email) || is_numeric($username))
			{$error = true; array_push($array_error, "email и имя не может быть числом");}
			elseif(is_float($email) || is_float($username))
			{$error = true; array_push($array_error, "email и имя не может быть числом");}
			elseif(strlen($email) < 10 || strlen($pass) < 6 || strlen($username) < 4)
			{$error = true; array_push($array_error, "email не должен быть коротше 10 символов, пароль 6 и имя коротше 4");}
			for($i=0; $i<count($array_registed_email); $i++)
			{
				if($array_registed_email[$i] == $email)
				{$error = true; array_push($array_error, "Этот пользователь уже зарегистрирован"); break;}
			}
			
			/*Export information if error = false*/
			if($error == false)
			{
				$conn = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
				#$pass = md5($pass);
				$date = date("d.m.y");
				$sql_export_info = "INSERT INTO $table_name(username, email, password, ip_add, ip_add_proxy, date) VALUES('$username', '$email', '$pass', '$ip_add', '$ip_add_proxy', '$date')";
				$conn->exec($sql_export_info);
				$conn = null;
				header("Location: index.php");
			}
		}
	}
	else
	{
		/*Create database and table*/
		$conn = new PDO("mysql:host=$server_name;dbname=", $user_name, $user_pass);
		$sql_create_database = "CREATE DATABASE $database_name";
		$conn->exec($sql_create_database);
		$conn = null;
		
		$conn = new PDO("mysql:host=$server_name;dbname=$database_name", $user_name, $user_pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql_create_table = "CREATE TABLE $table_name(email VARCHAR(50) NOT NULL, password VARCHAR(30) NOT NULL, ip_add VARCHAR(30) NOT NULL, ip_add_proxy VARCHAR(30) NOT NULL, date VARCHAR(10) NOT NULL)";
		$conn->exec($sql_create_table);
		$conn = null;
		
		header("Location reg.php");
	}

?>
<style>
*{margin:0;  border-radius:5px;}
li{list-style:none;}
a{
	margin-top:5px;
	cursor:pointer;
	height:25px;
	width:100px;
	color: white;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	background: none;
}

#fa-fa-header-name-site
{
	color:black;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:50px;
}
#fa-fa-header-name-site-form
{
	text-align:center;
	background:black;
	width:300px;
	border-top-left-radius:50px;
	border-top-right-radius:50px;
}
.fa-header-login
{
	margin-top:150px;
	text-align:center;
	width:400px;
	height:200px;
	background:silver;
	border:0px;
	box-shadow:0 0 100px rgba(0,0,0,0.3);
}

#fa-fa-header-user-login-input-username
{
	
	margin-right:13px;
	height:25px;
	width:160px;
	color: black;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	transition:0.5s;
}
#fa-fa-header-user-login-input-email
{
	margin-top:5px;
	margin-left:25px;
	height:25px;
	width:160px;
	color: black;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	transition:0.5s;
}
#fa-fa-header-user-login-input-pass
{
	margin-top:5px;
	margin-right:10px;
	height:25px;
	width:160px;
	color: black;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	transition:0.5s;
}
#fa-fa-header-user-login-input-email:hover
{
	border:2px;
	border-color:white;
	border-bottom-left-radius:15px;
	border-bottom-right-radius:15px;
	border-top-left-radius:15px;
	border-top-right-radius:15px;
	transition:0.5s;
}
#fa-fa-header-user-login-input-pass:hover
{
	border:2px;
	border-color:white;
	border-bottom-left-radius:15px;
	border-bottom-right-radius:15px;
	border-top-left-radius:15px;
	border-top-right-radius:15px;
	transition:0.5s;
}
#fa-fa-header-user-login-input-username:hover
{
	border:2px;
	border-color:white;
	border-bottom-left-radius:15px;
	border-bottom-right-radius:15px;
	border-top-left-radius:15px;
	border-top-right-radius:15px;
	transition:0.5s;
}

#fa-fa-header-user-login-input-login
{
	margin-top:5px;
	cursor:pointer;
	height:25px;
	width:100px;
	color: white;
	text-decoration: none;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:15px;
	border:0px;
	background: none;
}
#fa-fa-header-user-login-href
{
	margin-top:5px;
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




#fa-fa-header-user-login-username
{
	margin-right:10px;
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:16px;
}
#fa-fa-header-user-login-email
{
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:16px;
}
#fa-fa-header-user-login-pass
{
	margin-right:10px;
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:16px;
}
</style>
<body>
<title>ZloGame</title>


 <center>
	<ul>
	<li>
	 <div class="fa-fa-header-name-site-form">
		<text id="fa-fa-header-name-site">ZloGawe</text>
	 </div>
	</li>
	<li>
	<fieldset class="fa-header-login">
	<div class="fa-header-form">
    <form action="" method="post">
    <ul>
	 <li>
	  <text id="fa-fa-header-user-login-username">Username:</text><input  id="fa-fa-header-user-login-input-username" type="text" name="username" value=""></input>
     </li>
     <li>
	  <text id="fa-fa-header-user-login-email">E-mail:</text><input  id="fa-fa-header-user-login-input-email" type="text" name="email" value=""></input>
     </li>
     <li>
	  <text id="fa-fa-header-user-login-pass">Password:</text><input  id="fa-fa-header-user-login-input-pass" type="password" name="pass" value=""></input>
     </li>
     <li>
     <input id="fa-fa-header-user-login-input-login" type="submit" name="sign-in" value="Регистрация"></input>
     </li>
	 <li>
		<a href="index.php">Назад</a>
     </li>
	</ul>
    </form>
	<?php
		if(count($array_error) > 0){
			for($i=0; $i<count($array_error); $i++){
				echo "<strong class = \"error\">Ошибка:</strong>"."<em>".$array_error[$i]."</em>"."<br>";
			}
	}?>
   </div>
  </fieldset>
  </li>
</ul>
 <center>
</doby>