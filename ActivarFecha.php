<!--
	Página para activar fechas adminstrada por el caterático
	Gemis Daniel Guevara Villeda
	Lunes, 30 de julio del 2018
	22:15 PM
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
		// Si en la sesión activa tiene privilegios de Catedrático o superadministrador puede ver el formulario
		if($_SESSION["PrivilegioUsuario"] == 'Catedratico' || $_SESSION["PrivilegioUsuario"] == 'Superadmin'){
			// Guardamos el nombre del usuario en una variable
			$NombreUsuario =$_SESSION["NombreUsuario"];
			$idPersona = $_SESSION['idPersona'];
		?>
			<body>
				<!-- Título -->
				<h1>Bienvenido <?php echo "  " . $NombreUsuario; ?></h1>
				<h2>Menú principal</h2>
				<h3>Selecciona una opción</h3>
				<!-- Menú -->
				<div>
					<ul>
						<?php
							if($_SESSION["PrivilegioUsuario"] == 'Superadmin'){
								?>
								<li><a href="RegistrarCurso.php">Registrar curso</a></li>
								<li><a href="RegistrarEstudiante.php">Registrar estudiante</a></li>
								<li><a href="#">ActivarFecha</a></li>
								<li><a href="DesactivarFecha.php">DesactivarFecha</a></li>
								<li><a href="AcercaDe.php">Acerca de...</a></li>
								<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
							<?php
							}else{
								?>
								<li><a href="#">Activar fecha</a></li>
								<li><a href="DesactivarFecha.php">Desactivar fecha</a></li>
								<li><a href="AcercaDe.php">Acerca de...</a></li>
								<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
								<?php
							}
						?>
					</ul>
				</div>
				<br>
					<form name="ActivarFecha" action="ActivarFecha.php" method="post">
						<div>
							<!-- Título -->
							<div>
								<h1>Activar fecha</h1>
							</div>
							<!-- Fecha -->
							<div>
								<label>Seleccione una fecha:</label>
								<input type="date" name="FechaActivar" placeholder="Fecha" id="FechaActivar" required>
							</div>
							<br>
							<!-- Curso -->
							<div>
								<label>Curso:</label>
								<select name="Curso" id="Curso">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Si es Superadmin puede visualizar todo
										if ($_SESSION["PrivilegioUsuario"] == "Superadmin"){
											// Creamos la consulta sin restricción de usuario
											$SelectCurso = "SELECT idCurso, NombreCurso FROM curso;";
										}else{
											// Creamos la consulta normal para el catedrático
											$SelectCurso = "SELECT idCurso, NombreCurso FROM curso WHERE CatedraticoCurso=".$idPersona.";";
										}
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectCurso);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											?>
											<option value="<?php echo $row['idCurso']; ?>"><?php echo $row['NombreCurso']; ?> </option>
											<?php
										}
									?>
								</select>
							</div>
							<br>
							<!-- Resgistrar -->
							<div>
								<button type="submit" id="Activar" name="Activar">Activar</button>
							</div>
						</div>
					</form>
				</div>
				<?php
					if(isset($_POST['Activar'])){
						// Obtenemos los valores de todos los campos y los almacenamos en variables
						$FechaActivar=$_POST['FechaActivar'];
						$Curso=$_POST['Curso'];
						
						// Primero verificaremos si la fecha ya está registrada
						// Primero creamos la consulta
						//$SelectFechaActivada = "SELECT idFechaAsistecia FROM fechaasistencia WHERE FechaFechaAsistencia='".$FechaActivar."';";
						// Si es verdadero existe una fecha ya registrada, podemos volver a activarla
						//if($resultado = $mysqli->query($InsertFechaActivada)){
						//	$row = mysqli_fetch_array($ResultadoConsulta)
						// Creamos la consulta para la insersión de los datos
						$InsertFechaActivada = "INSERT INTO fechaasistencia(FechaFechaAsistencia, CursoFechaAsistencia, EstadoFechaAsistencia)
																	 Values('".$FechaActivar."', ".$Curso.", 'Activada')";
						
						if(!$resultado = $mysqli->query($InsertFechaActivada)){
							echo "Error: La ejecución de la consulta falló debido a: \n";
							echo "Query: " . $InsertFechaActivada . "\n";
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
