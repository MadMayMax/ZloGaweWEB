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
			if($email == "" || $pass == "")
			{$error = true; array_push($array_error, "Одно из полей пустое");}
			elseif(is_numeric($email))
			{$error = true; array_push($array_error, "email не может быть числом");}
			elseif(is_float($email))
			{$error = true; array_push($array_error, "email не может быть числом");}
			elseif(strlen($email) < 10 || strlen($pass) < 6)
			{$error = true; array_push($array_error, "email не должен быть коротше 10 символов, а пароль 6");}
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
				$sql_export_info = "INSERT INTO $table_name(email, password, ip_add, ip_add_proxy, date) VALUES('$email', '$pass', '$ip_add', '$ip_add_proxy', '$date')";
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
#reg_form
{
	margin-top:200px;
	width:300px;
	height:120px;
}
#reg_form:hover
{
	box-shadow: 0 0 100px rgba(0,0,0,0.5);
}
input
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
	transition:1s;
}
input[type="submit"]:hover
{
	box-shadow: 0 0 100px rgba(0,0,0,0.5);
	transition:1s;
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
   transition:1s;
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
   transition:1s;
}
#email
{
	margin-left:25px;
}
#singin
{
	margin-top:15px;
}
.name_area
{
	font-size:15px;
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
}
#name_site
{
	font-size:50px;
	font-family:Verdana, "Trebuchet MS", Geneva, sans-serif;
}
</style>
<!DOCTYPE html>
<html>
<head><title></title>
</head>
<body>
<center>
<center>
<b><text id="name_site">ZloGame</text></b>
</center>
<center>
<fieldset id="reg_form">
<center>
<form id="post_form" method="post">
	<b><text class="name_area">E-mail:</text></b><input id="email" type="text" name="email" value=""></input><br>
	<br>
	<b><text class="name_area">Password:</text></b><input id="pass" type="password" name="pass" value=""></input><br>
	<input id="singin" type="submit" id="button" name="sign-in" value="Регистрация"></input>
</form>
</center>
</fieldset>
</center>
<?php
if(count($array_error) > 0){
	for($i=0; $i<count($array_error); $i++){
		echo "<strong class = \"error\">Ошибка:</strong>"."<em>".$array_error[$i]."</em>"."<br>";
	}
}
?>
</center>
</body>
</html>


