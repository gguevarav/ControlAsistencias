<!--
	Página para deactivar fechas adminstrada por el catedrático
	Gemis Daniel Guevara Villeda
	Lunes, 30 de julio del 2018
	23:15 PM
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
								<li><a href="ActivarFecha.php">ActivarFecha</a></li>
								<li><a href="#">DesactivarFecha</a></li>
								<li><a href="AcercaDe.php">Acerca de...</a></li>
								<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
							<?php
							}else{
								?>
								<li><a href="ActivarFecha.php">Activar fecha</a></li>
								<li><a href="#">Desactivar fecha</a></li>
								<li><a href="AcercaDe.php">Acerca de...</a></li>
								<li><a href="Seguridad/logout.php">Cerrar Sesión</a></li>
							<?php
							}
						?>
					</ul>
				</div>
				<br>
					<form name="DesactivarFecha" action="DesactivarFecha.php" method="post">
						<div>
							<!-- Título -->
							<div>
								<h1>Desactivar fecha</h1>
							</div>
							<!-- Fecha a desactivar -->
							<div>
								<label>Fecha a desactivar:</label>
								<select name="FechaDesactivar" id="FechaDesactivar">
									<option value="" disabled selected>Seleccione un curso</option>
									<?php
										// Si es Superadmin puede visualizar todo
										if ($_SESSION["PrivilegioUsuario"] == "Superadmin"){
											// Creamos la consulta sin restricciones
										$SelectFechaAsistencia = "SELECT idFechaAsistencia, FechaFechaAsistencia, CursoFechaAsistencia FROM fechaasistencia WHERE EstadoFechaAsistencia='Activada';";
										}else{
											// Creamos la consulta con restricción solo al catedrático que esté logueado
										$SelectFechaAsistencia = "SELECT idFechaAsistencia, FechaFechaAsistencia, CursoFechaAsistencia FROM fechaasistencia WHERE CatedraticoFechaAsistencia=".$idPersona." AND EstadoFechaAsistencia='Activada';";
										}
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
							<!-- Desactivar -->
							<div>
								<button type="submit" id="Desactivar" name="Desactivar">Desactivar</button>
							</div>
						</div>
					</form>
				</div>
				<?php
					if(isset($_POST['Desactivar'])){
						// Obtenemos los valores de todos los campos y los almacenamos en variables
						$FechaDesactivar=$_POST['FechaDesactivar'];
						
						// Creamos la consulta para la actualización de los datos
						$UpdateFechaActivada = "UPDATE fechaasistencia SET EstadoFechaAsistencia='Desactivada'
																		WHERE idFechaAsistencia=".$FechaDesactivar.";";
						
						if(!$resultado = $mysqli->query($UpdateFechaActivada)){
							echo "Error: La ejecución de la consulta falló debido a: \n";
							echo "Query: " . $UpdateFechaActivada . "\n";
							echo "Error: " . $mysqli->errno . "\n";
							exit;
						}else{
							// Después de desactivarla debería enviar la asistencia
							// Consulta para obtener la fecha y el curso para poder crear el archivo
							$ConsultaInfoFechaInforme = "SELECT FechaFechaAsistencia, CursoFechaAsistencia FROM fechaasistencia
																										  WHERE idFechaAsistencia=".$FechaDesactivar.";";
							// Resultado de la consulta
							$ResultadoConsulta = $mysqli->query($ConsultaInfoFechaInforme);
							$row = mysqli_fetch_array($ResultadoConsulta);
							// Consulta para obtener el nombre del curso
							$ConsultaNombreCurso = "SELECT NombreCurso FROM curso WHERE idCurso=".$row['CursoFechaAsistencia'].";";
							$ResultadoConsultaNombreCurso = $mysqli->query($ConsultaNombreCurso);
							$row2 = mysqli_fetch_array($ResultadoConsultaNombreCurso);
							
							// Carpeta que contiene los archivos
							$Carpeta = "reportes/";
							
							// Nombre del archivo
							$archivo_csv = $Carpeta . "asistencia_".$row2['NombreCurso']."_".$row['FechaFechaAsistencia'].".csv";
							// Creamos el archivo
							$csv = fopen($archivo_csv, 'x+');
							// Insertamos to títulos del archivo
							fputcsv($csv,array ('Carnet','Nombre','Curso'));
							// Consulta para obtener el estudiante
							$ConsultaAsistencias = "SELECT EstudianteAsistenciaMarcada FROM asistenciamarcada WHERE FechaAsistenciaMarcada=".$FechaDesactivar.";";
							$ResultadoConsultaAsistencias = $mysqli->query($ConsultaAsistencias);
							// Escribimos el archivo
							while ($fila = mysqli_fetch_array($ResultadoConsultaAsistencias)) {
								$EstudianteAsistenciaMarcada = $fila['EstudianteAsistenciaMarcada'];
								// Consulta donde obtendremos el nombre, apellido y carnet del estudiante
								$SelectInfoEstudiante = "SELECT NombrePersona, ApellidoPersona, CarnetPersona FROM persona WHERE idPersona=".$EstudianteAsistenciaMarcada.";";
								$ResultadoSelectInfoEstudiante = $mysqli->query($SelectInfoEstudiante);
								$fila2 = mysqli_fetch_array($ResultadoSelectInfoEstudiante);
								// Insertamos la informacion en el archivo
								fputcsv($csv, array($fila2['CarnetPersona'],$fila2['NombrePersona'] . " " . $fila2['ApellidoPersona'],$row2['NombreCurso']));
							}
							// Cerramos el archivo
							fclose($csv);
							// Enviamos el archivo por correo
							//recipient
							// Primero obtendremos la info del usuario para poder enviar el correo
							$SelectInforPersona = "SELECT NombrePersona, ApellidoPersona, CorreoPersona FROM persona WHERE idPersona=".$idPersona.";";
							$ResultadoSelectInforPersona = $mysqli->query($SelectInforPersona);
							$ResultadoFila = mysqli_fetch_array($ResultadoSelectInforPersona);
							$to = "gemisdguevarav@gmail.com";

							//sender
							$from = "gemisdguevarav@gmail.com";
							$fromName = 'tarea3.4890132950.net';

							//email subject
							$subject = "Asistencia del curso " . $row2['NombreCurso'] . " de la fecha " . $row['FechaFechaAsistencia'];

							//email body content
							$htmlContent = '<h1>PHP Email with Attachment</h1>
								<p>This email has sent from PHP script with attachment.</p>';

							//header for sender info
							$headers = "From: $fromName"." <".$from.">";

							//boundary 
							$semi_rand = md5(time()); 
							$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

							//headers for attachment 
							$headers .= "nMIME-Version: 1.0n" . "Content-Type: multipart/mixed;n" . " boundary='{$mime_boundary}'"; 

							//multipart boundary 
							$message = "--{$mime_boundary}n" . "Content-Type: text/html; charset='UTF-8'n" .
							"Content-Transfer-Encoding: 7bitnn" . $htmlContent . "nn"; 

							//preparing attachment
							if(!empty($archivo_csv) > 0){
								if(is_file($archivo_csv)){
									$message .= "--{$mime_boundary}n";
									$fp =    @fopen($archivo_csv,"rb");
									$data =  @fread($fp,filesize($archivo_csv));

									@fclose($fp);
									$data = chunk_split(base64_encode($data));
									$message .= "Content-Type: application/octet-stream; name='".basename($archivo_csv)."'n" . 
									"Content-Description: ".basename($archivo_csv)."n" .
									"Content-Disposition: attachment;n" . " filename='".basename($archivo_csv)."'; size=".filesize($archivo_csv).";n" . 
									"Content-Transfer-Encoding: base64nn" . $data . "nn";
								}
							}
							
							$message .= "--{$mime_boundary}--";
							$returnpath = "-f" . $from;

							//send email
							$mail = @mail($to, $subject, $message, $headers, $returnpath); 

							//email sending status
							echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";
							echo "<script languaje='javascript'>
									alert('Fecha desactivada');
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
