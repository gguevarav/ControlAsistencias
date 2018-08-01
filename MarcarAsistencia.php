<!--
	Página para Marcar asistencias adminstrada por el estudiante
	Gemis Daniel Guevara Villeda
	Martes, 31 de julio del 2018
	12:23 PM
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
		// Si en la sesión activa tiene privilegios de estudiante o superadministrador puede ver el formulario
		if($_SESSION["PrivilegioUsuario"] == 'Estudiante' || $_SESSION["PrivilegioUsuario"] == 'Superadmin'){
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
								<li><a href="ActivarFecha.php">Activar Fecha</a></li>
								<li><a href="#">Marcar Asistencia</a></li>
								<li><a href="DesactivarFecha.php">Desactivar Fecha</a></li>
								<li><a href="AcercaDe.php">Acerca de...</a></li>
								<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
							<?php
							}else{
								?>
								<li><a href="#">Marcar Asistencia</a></li>
								<li><a href="AcercaDe.php">Acerca de...</a></li>
								<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
							<?php
							}
						?>
					</ul>
				</div>
				<br>
					<form name="MarcarAsistencia" action="MarcarAsistencia.php" method="post">
						<div>
							<!-- Título -->
							<div>
								<h1>Marcar asistencia</h1>
							</div>
							<!-- Fecha a marcar -->
							<div>
								<label>Fecha a marcar:</label>
								<select name="FechaMarcar" id="FechaMarcar">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// El estudiante puede ver todas las fechas activas de cualquier curso
										$SelectFechaAsistencia = "SELECT idFechaAsistencia, FechaFechaAsistencia, CursoFechaAsistencia FROM fechaasistencia WHERE EstadoFechaAsistencia='Activada';";
										// Ejecutamos la consulta
										$ResultadoConsulta = $mysqli->query($SelectFechaAsistencia);
										while($row = mysqli_fetch_array($ResultadoConsulta)){
											// Creamos la consulta
											$SelectCurso = "SELECT NombreCurso FROM curso WHERE idCurso=".$row['CursoFechaAsistencia'].";";
											// Ejecutamos la consulta
											$ResultadoConsulta2 = $mysqli->query($SelectCurso);
											// Guardamos la fila resultante
											$row2 = mysqli_fetch_array($ResultadoConsulta2);
											?>
											<option value="<?php echo $row['idFechaAsistencia']; ?>"><?php echo $row2['NombreCurso'] . " - " . $row['FechaFechaAsistencia']; ?> </option>
											<?php
										}
									?>
								</select>
							</div>
							<br>
							<!-- Resgistrar -->
							<div>
								<button type="submit" id="Marcar" name="Marcar">Marcar</button>
							</div>
						</div>
					</form>
				</div>
				<?php
					if(isset($_POST['Marcar'])){
						// Obtenemos los valores de todos los camp os y los almacenamos en variables
						$FechaMarcar=$_POST['FechaMarcar'];
						
						// Primero tenemos que verificar si ya marcó con anterioridad
						$SelectFecharMarcar = "SELECT idAsistenciaMarcada FROM asistenciamarcada
												WHERE FechaAsistenciaMarcada =".$FechaMarcar." AND EstudianteAsistenciaMarcada=".$idPersona.";";
						
						$ResultadoConsulta = $mysqli->query($SelectFecharMarcar);
						$row = mysqli_fetch_array($ResultadoConsulta);
						if($row['idAsistenciaMarcada'] == ""){
							// Creamos la consulta para la insersión de los datos
							$InsertFechaMarcar = "INSERT INTO asistenciamarcada(FechaAsistenciaMarcada, EstudianteAsistenciaMarcada)
																		  VALUES(".$FechaMarcar.", ".$idPersona.")";
							
							if(!$resultado = $mysqli->query($InsertFechaMarcar)){
								echo "Error: La ejecución de la consulta falló debido a: \n";
								echo "Query: " . $InsertFechaMarcar . "\n";
								echo "Error: " . $mysqli->errno . "\n";
								exit;
							}else{
								echo "<script languaje='javascript'>
										alert('Asistencia registrada');
									  </script>";
							}
						}else{
							echo "<script languaje='javascript'>
									alert('Ya marcó la asistencia para este curso');
								  </script>";
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
