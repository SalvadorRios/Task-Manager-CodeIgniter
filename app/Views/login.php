<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Login</title>
  <link rel="stylesheet" href="./assets/css/login.css">

</head>
<body>
<!-- partial:index.partial.html hola mundo -->
<div class="wrapper">
	<div class="container">
		<h1>TaskManager</h1> 
		
	<form  action="/api/login-users"  method="POST">
 
        <input autocomplete="off" class="input-login" name="email" id="email" type="text" placeholder="Email" />
        <input autocomplete="off" class="input-login" name="password" id="password" type="password" placeholder="Contraseña" />
        <input class="submit-login input-login" type="submit"  value="Acceder" class="enviar">
		

    </form>

	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<!-- partial -->

  	<!-- <script src="jquery/jquery-3.3.1.min.js"></script>    
	<script src="./script.js"></script> -->
	<!-- <script src="js/login.js"></script>     -->

	<!-- <script src="bootstrap/js/bootstrap.min.js"></script>    
	<script src="popper/popper.min.js"></script>     -->
    <!-- <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>  -->

</body>
</html>