<!--
	Acerca de...
	Gemis Daniel Guevara Villeda
	Lunes, 30 de julio del 2018
	23:42 PM
	UMG - Morales Izabal
-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="imagenes/icono.ico">
<title>Sistema para registro de asistencias UMG Morales</title>

</head>
	<?php
		// Incluimos el archivo que valida si hay una sesión activa
		include_once "Seguridad/seguro.php";
		// Si en la sesión activa tiene cualquier privilegio puede ver el formulario
		if($_SESSION["PrivilegioUsuario"] == 'Catedratico' ||
		   $_SESSION["PrivilegioUsuario"] == 'Estudiante' ||
		   $_SESSION["PrivilegioUsuario"] == 'Administrador' ||
		   $_SESSION["PrivilegioUsuario"] == 'Superadmin'){
			// Guardamos el nombre del usuario en una variable
			$NombreUsuario =$_SESSION["NombreUsuario"];
		?>
			<body>
				<!-- Título -->
				<h1>Acerca de...</h1>
				<h2>Menú principal</h2>
				<h3>Selecciona una opción</h3>
				<!-- Menú -->
				<div>
					<ul>
						<?php
							if ($_SESSION["PrivilegioUsuario"] == 'Superadmin'){
								?>
								<li><a href="Principal.php">Página Principal</a></li>
								<?php
							}else if($_SESSION["PrivilegioUsuario"] == 'Administrador'){
								?>
								<li><a href="Administrador.php">Página Principal</a></li>
								<?php
							}else if ($_SESSION["PrivilegioUsuario"] == 'Catedratico'){
								?>
								<li><a href="Catedratico.php">Página Principal</a></li>
								<?php
							}else if ($_SESSION["PrivilegioUsuario"] == 'Estudiante'){
								?>
								<li><a href="Estudiante.php">Página Principal</a></li>
								<?php
							}
								?>
					</ul>
				<hr>
				</div>
					<div>
						<div>
							<h2>Sistema para registro de asistencias UMG Morales</h2>
							<h4>Universidad Mariano Gálvez</h4>
							<h4>Morales Izabal</h4>
							<h4>Gemis Daniel Guevara Villeda</h4>
							<h4>4890-13-2950</h4>
							<h4>Copyright &copy; 2018 &middot; All Rights Reserved<h4>
						</div>
					</div>
				</div>
				<!-- Pie de página, se utilizará el mismo para todos. -->
				<footer>
					<hr>
					<div>
						<div>
							<h4>Sistema para registro de asistencias UMG Morales</h4>
							<p>Copyright &copy; 2018 &middot; Todos los derechos reservados &middot; <a href="https://www.umg.edu.gt/" >Gemis Daniel Guevara Villeda</a></p>
						</div>
					</div>
					<hr>
				</footer> 
			</body>
			<?php
			// De lo contrario lo redirigimos al inicio de sesión
			} 
			else{
				echo "usuario no valido";
				header("location:index.php");
			}
		?>
</html>
