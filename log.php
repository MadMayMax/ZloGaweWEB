<style>
*{margin:0; border-radius:5px;}
li{list-style:none;}
a{text-decoration: none;}


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
#fa-fa-header-user-login-input-email
{
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
#fa-fa-header-user-login-input-login
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




#fa-fa-header-user-login-email
{
	color:white;
	font-family:ms sans serif;
	font-weight:bold;
	font-size:16px;
}
#fa-fa-header-user-login-pass
{
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
    <form action="index.php" method="post">
    <ul>
     <li>
	  <text id="fa-fa-header-user-login-email">E-mail:</text><input  id="fa-fa-header-user-login-input-email" type="text" name="email"></input>
     </li>
     <li>
	  <text id="fa-fa-header-user-login-pass">Password:</text><input  id="fa-fa-header-user-login-input-pass" type="password" name="pass"></input>
     </li>
     <li>
      <a href="index.php"><input id="fa-fa-header-user-login-input-login" type="submit" name="login" value="Войти"></input></a>
     </li>
	 <li>
	  <a href="reg.php"><text id="fa-fa-header-user-login-href">Регистрация</text></a>
	 </li>
	</ul>
    </form>
   </div>
  </fieldset>
  </li>
  </ul>
 <center>
</doby>