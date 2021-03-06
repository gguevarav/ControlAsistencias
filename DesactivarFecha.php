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
							
							// Consulta para obtener el estudiante
							$ConsultaAsistencias = "SELECT EstudianteAsistenciaMarcada FROM asistenciamarcada WHERE FechaAsistenciaMarcada=".$FechaDesactivar.";";
							$ResultadoConsultaAsistencias = $mysqli->query($ConsultaAsistencias);
							
							$ContenidoTabla = "";
							
							while ($fila = mysqli_fetch_array($ResultadoConsultaAsistencias)) {
								$EstudianteAsistenciaMarcada = $fila['EstudianteAsistenciaMarcada'];
								// Consulta donde obtendremos el nombre, apellido y carnet del estudiante
								$SelectInfoEstudiante = "SELECT NombrePersona, ApellidoPersona, CarnetPersona FROM persona WHERE idPersona=".$EstudianteAsistenciaMarcada.";";
								$ResultadoSelectInfoEstudiante = $mysqli->query($SelectInfoEstudiante);
								$fila2 = mysqli_fetch_array($ResultadoSelectInfoEstudiante);
								$ContenidoTabla .= "<tr>";
								$ContenidoTabla .= "<td><span id='".$fila2['CarnetPersona']."'>".$fila2['CarnetPersona']."</span></td>";
								$ContenidoTabla .= "<td><span id='".$fila2['NombrePersona']."'>".$fila2['NombrePersona'] . " " . $fila2['ApellidoPersona']."</span></td>";
								$ContenidoTabla .= "<td><span id='".$row2['NombreCurso']."'>".$row2['NombreCurso']."</span></td>";
								$ContenidoTabla .= "</tr>";
							}
							
							require("phpmailer/class.phpmailer.php"); //Importamos la función PHP class.phpmailer
							$mail = new PHPMailer();

							$mail->IsSMTP();
							$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False

							$mail->SMTPSecure = "ssl";
							$mail->Host = "smtp.gmail.com";
							$mail->Port = 465;
							
							// Obtenemos la información de la persona
							$SelectInforPersona = "SELECT NombrePersona, ApellidoPersona, CorreoPersona FROM persona WHERE idPersona=".$idPersona.";";
							$ResultadoSelectInforPersona = $mysqli->query($SelectInforPersona);
							$ResultadoFila = mysqli_fetch_array($ResultadoSelectInforPersona);
							
							//Nuestra cuenta
							$mail->Username ='info.4890132950.net@gmail.com';
							$mail->Password = 'Alovelyday_0295'; //Su password
							$mail->From = "info.4890132950.net@gmail.com";
							$mail->FromName = "Control de Asistencias - UMG";
							$mail->Subject = "Reporte de asistencias del curso " . $row2['NombreCurso'] . " de la fecha " . $row['FechaFechaAsistencia'];
							$mail->AddAddress($ResultadoFila['CorreoPersona'], $ResultadoFila['NombrePersona'] . " " . $ResultadoFila['ApellidoPersona']);

							$mail->WordWrap = 50;

							$body = "<html>
										<head>
										<title>Reporte de Asistencia</title>
										<style type='text/css'>
											#datos {
												position:absolute;
												width:780px;
												left: 164px;
												top: 316px;
												text-align: center;
											}
											#apDiv1 #form1 table tr td {
												text-align: center;
												font-weight: bold;
											}
											#apDiv2 {
												position:absolute;
												width:49px;
												height:45px;
												z-index:2;
												left: 12px;
												top: 11px;
											}
											#apDiv1 #notificacion table tr td {
												text-align: center;
											}
											#apDiv1 #notificacion table tr td {
												text-align: left;
											}
											#apDiv1 #notificacion table tr td {
												text-align: center;
												font-family: Arial, Helvetica, sans-serif;
											}
											#apDiv3 {
												position:absolute;
												width:833px;
												height:115px;
												z-index:1;
												left: 99px;
												text-align: center;
												top: 16px;
											}
										</style>
										</head>
										<body>
											<div id='apDiv3'>
												<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
													<!-- Título -->
													<thead>
														<!-- Contenido -->
														<tr>
															<th>Carnet</th>
															<th>Nombre</th>
															<th>Curso</th>
														</tr>
													</thead>
													<!-- Cuerpo de la tabla -->
													<tbody>
														<td><p>&nbsp;</p>
														<p style='font-family: Helvetica LT Condensed; color: #008895; font-weight: bold; font-size: 22px; text-align: center;'>Reporte de Asistencia</p></td>
														'.$ContenidoTabla.'
													</tbody>
												</table>
											</div>								
										</body>
										</html>";
										
							$mail->msgHTML("<html>
										<head>
										<title>Reporte de Asistencia</title>
										<style type='text/css'>
											#datos {
												position:absolute;
												width:780px;
												left: 164px;
												top: 316px;
												text-align: center;
											}
											#apDiv1 #form1 table tr td {
												text-align: center;
												font-weight: bold;
											}
											#apDiv2 {
												position:absolute;
												width:49px;
												height:45px;
												z-index:2;
												left: 12px;
												top: 11px;
											}
											#apDiv1 #notificacion table tr td {
												text-align: center;
											}
											#apDiv1 #notificacion table tr td {
												text-align: left;
											}
											#apDiv1 #notificacion table tr td {
												text-align: center;
												font-family: Arial, Helvetica, sans-serif;
											}
											#apDiv3 {
												position:absolute;
												width:833px;
												height:115px;
												z-index:1;
												left: 99px;
												text-align: center;
												top: 16px;
											}
										</style>
										</head>
										<body>
											<div id='apDiv3'>
												<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
													<!-- Título -->
													<thead>
														<!-- Contenido -->
														<tr>
															<th>Carnet</th>
															<th>Nombre</th>
															<th>Curso</th>
														</tr>
													</thead>
													<!-- Cuerpo de la tabla -->
													<tbody>
														".$ContenidoTabla."
													</tbody>
												</table>
											</div>								
										</body>
										</html>");

							// Notificamos al usuario del estado del mensaje

							if(!$mail->Send()){
								echo "No se pudo enviar el Mensaje.";
							}else{
								echo "Mensaje enviado";
							}
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
