<!--
	Página principal para Registrar un estudiante
	Gemis Daniel Guevara Villeda
	Jueves, 26 de julio del 2018
	23:03 PM
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
						<li><a href="RegistrarCurso.php">Registrar curso</a></li>
						<li><a href="#">Registrar estudiante</a></li>
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
								<h1>Registro de estudiante</h1>
							</div>
							<div>
								<h3>Datos del usuario</h3>
							</div>
							<!-- Nombres -->
							<div>
								<label>Nombres:</label>
								<input type="text" name="Nombres" placeholder="Nombres" id="Nombres" required>
							</div>
							<br>
							<!-- Apellidos -->
							<div>
								<label>Apellidos:</label>
								<input type="text" name="Apellidos" placeholder="Apellidos" id="Apellidos" required>
							</div>
							<br>
							<!-- Carnet -->
							<div>
								<label>Carent:</label>
								<input type="text" name="CarnetEstudiante" placeholder="Carnet del estudiante" id="CarnetEstudiante" required>
							</div>
							<br>
							<!-- Correo -->
							<div>
								<label>Correo:</label>
								<input type="email" name="Correo" placeholder="Correo" id="Correo" required>
							</div>
							<br>
							<div>
								<h3>Datos del inicio de sesión del usuario</h3>
							</div>
							<!-- Nombre de usuario -->
							<div>
								<label>Nombre de usuario:</label>
								<input type="text" name="NombreUsuario" placeholder="Nombre de usuario" id="NombreUsuario" required>
							</div>
							<br>
							<!-- Contraseña -->
							<div>
								<label>Contraseña:</label>
								<input type="password" name="Contrasena" placeholder="Contraseña" id="Contrasena" required>
							</div>
							<br>
							<!-- Contraseña -->
							<div>
								<label>Repita la contraseña:</label>
								<input type="password" name="Contrasena1" placeholder="Contraseña" id="Contrasena1" required>
							</div>
							<br>
							<!-- Rol del usuario -->
							<div>
								<label>Rol que deberá tener el usuario:</label>
								<select name="Curso1" id="Curso1">
									<option value="" disabled selected>Seleccione un rol</option>
									<option value="Administrador">Administrador</option>
									<option value="Catedratico">Catedrático</option>
									<option value="Estudiante">Estudiante</option>
								</select>
							</div>
							<br>
							<div>
								<h3>Si es estudiante deberá asignarle cursos</h3>
							</div>
							<!-- Curso 1 -->
							<div>
								<label>Seleccione el primer curso a recibir:</label>
								<select name="Curso1" id="Curso1">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Creamos la consulta
										$SelectCursos = "SELECT idCurso, CodigoCurso FROM Curso;";
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectCursos);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											?>
											<option value="<?php echo $row['idCurso']; ?>"><?php echo $row['CodigoCurso']; ?> </option>
											<?php
										}
									?>
								</select>
							</div>
							<br>
							<!-- Curso 2 -->
							<div>
								<label>Seleccione el segundo curso a recibir:</label>
								<select name="Curso2" id="Curso2">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Creamos la consulta
										$SelectCursos = "SELECT idCurso, CodigoCurso FROM Curso;";
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectCursos);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											?>
											<option value="<?php echo $row['idCurso']; ?>"><?php echo $row['CodigoCurso']; ?> </option>
											<?php
										}
									?>
								</select>
							</div>
							<br>
							<!-- Curso 3 -->
							<div>
								<label>Seleccione el tercer curso a recibir:</label>
								<select name="Curso3" id="Curso3">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Creamos la consulta
										$SelectCursos = "SELECT idCurso, CodigoCurso FROM Curso;";
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectCursos);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											?>
											<option value="<?php echo $row['idCurso']; ?>"><?php echo $row['CodigoCurso']; ?> </option>
											<?php
										}
									?>
								</select>
							</div>
							<br>
							<!-- Curso 4 -->
							<div>
								<label>Seleccione el cuarto curso a recibir:</label>
								<select name="Curso4" id="Curso4">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Creamos la consulta
										$SelectCursos = "SELECT idCurso, CodigoCurso FROM Curso;";
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectCursos);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											?>
											<option value="<?php echo $row['idCurso']; ?>"><?php echo $row['CodigoCurso']; ?> </option>
											<?php
										}
									?>
								</select>
							</div>
							<br>
							<!-- Curso 5 -->
							<div>
								<label>Seleccione el quinto curso a recibir:</label>
								<select name="Curso5" id="Curso5">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Creamos la consulta
										$SelectCursos = "SELECT idCurso, CodigoCurso FROM Curso;";
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectCursos);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											?>
											<option value="<?php echo $row['idCurso']; ?>"><?php echo $row['CodigoCurso']; ?> </option>
											<?php
										}
									?>
								</select>
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
