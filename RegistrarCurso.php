<!--
	Página principal para Registrar un Curso
	Gemis Daniel Guevara Villeda
	Jueves, 26 de julio del 2018
	22:00 PM
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
		// Incluimos el archivo para la conexión a la base de datos
		include_once "Seguridad/conexion.php";
		// Si en la sesión activa tiene privilegios de administrador o superadministrador puede ver el formulario
		if($_SESSION["PrivilegioUsuario"] == 'Administrador' || $_SESSION["PrivilegioUsuario"] == 'Superadmin'){
			// Guardamos el nombre del usuario en una variable
			$NombreUsuario =$_SESSION["NombreUsuario"];
		?>
			<body>
				<!-- Título -->
				<h1>Bienvenido <?php echo "  " . $NombreUsuario; ?></h1>
				<h2>Menú principal</h2>
				<h3>Selecciona una opción</h3>
				<!-- Menú -->
				<div>
					<ul>
						<li><a href="#">Registrar curso</a></li>
						<li><a href="RegistrarEstudiante.php">Registrar estudiante</a></li>
						<li><a href="AcercaDe.php">Acerca de...</a></li>
						<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
					</ul>
				</div>
				<hr>
				<di v>
					<form name="CrearUsuario" action="RegistrarCurso.php" method="post">
						<div>
							<!-- Título -->
							<div>
								<h1>Registro de curso</h1>
							</div>
							<!-- Semestre/Trimestre/Bimestre -->
							<div>
								<label>Semestre/Trimestre/Bimestre:</label>
								<input type="text" name="Semestre" placeholder="Semestre/Trimestre/Bimestre" id="Semestre" required>
							</div>
							<br>
							<!-- Año -->
							<div>
								<label>Año:</label>
								<input type="text" name="Anio" placeholder="Año" id="Anio" required>
							</div>
							<br>
							<!-- Código carrera -->
							<div>
								<label>Código de Carrera:</label>
								<input type="text" name="CodigoCarrera" placeholder="Código de Carrera" id="CodigoCarrera" required>
							</div>
							<br>
							<!-- Código de curso -->
							<div>
								<label>Código de Curso:</label>
								<input type="text" name="CodigoCurso" placeholder="Código de Curso" id="CodigoCurso" required>
							</div>
							<br>
							<!-- Nombre del curso -->
							<div>
								<label>Nombre del Curso:</label>
								<input type="text" name="NombreCurso" placeholder="Nombre del Curso" id="NombreCurso" required>
							</div>
							<br>
							<!-- Sección -->
							<div>
								<label>Sección:</label>
								<input type="text" name="Seccion" placeholder="Sección" id="CodigoCurso" required>
							</div>
							<br>
							<!-- Resgistrar -->
							<div>
								<button type="submit" id="Registrar" name="Registrar">Registrar</button>
							</div>
						</div>
					</form>
				</div>
				<?php
					if(isset($_POST['Registrar'])){
						// Obtenemos los valores de todos los campos y los almacenamos en variables
						$Semestre=$_POST['Semestre'];
						$Anio=$_POST['Anio'];
						$CodigoCarrera=$_POST['CodigoCarrera'];
						$CodigoCurso=$_POST['CodigoCurso'];
						$Seccion=$_POST['Seccion'];
						
						// Creamos la consulta para la insersión de los datos
						$InsertCurso = "INSERT INTO Curso(SemestreCurso, AnioCurso, CodigoCarreraCurso, CodigoCurso, SeccionCurso)
												  Values('".$Semestre."', '".$Anio."', '".$CodigoCarrera."', '".$CodigoCurso."', '".$Seccion."')";
						
						if(!$resultado = $mysqli->query($InsertCurso)){
							echo "Error: La ejecución de la consulta falló debido a: \n";
							echo "Query: " . $InsertCurso . "\n";
							echo "Error: " . $mysqli->errno . "\n";
							exit;
						}
					}
				?>
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
