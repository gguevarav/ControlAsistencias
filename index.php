<!--
	Sistema de Control de asistencias
	Domingo, 22 de Juliio del 2018
	8:39 PM
	Gemis Daniel Guevara Villeda
	-
	UMG - Morales Izabal
	-
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" href="imagenes/icono.ico">
        <title>Control de Asistencias</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		</head>
        <body>
			<!-- Contenedor del ícono del Usuario -->
    		<div>
    			<div>
					<h2 class="text-center">Inicie sesión</h2>
    			</div>

    			<div class="form-group">
    				<form name="FormEntrar" action="index.php" method="post">
						<div>
							<input type="text" class="form-control" name="usuario" placeholder="Usuario" id="Usuario" aria-describedby="sizing-addon1" required>
    					</div>
						<br>
						<div>
							<input type="password" name="password" class="form-control" placeholder="******" aria-describedby="sizing-addon1" required>
    					</div>
						<br>
						<div>
							<button class="btn btn-lg btn-primary btn-block btn-signin" id="IngresoLog" name="enviar" type="submit">Entrar</button>
						</div>
    				</form>
    			</div>
    		</div>
    		<?php
    			include_once "Seguridad/conexion.php";
    			if (isset($_POST['enviar'])) {
					// Guardamos el nombre del usuario un una variable
					$Usuario= $_POST["usuario"];
					// Encriptamos la contraseña a MD5 para seguridad y lo guardamos en una variable
					$password = md5($_POST['password']);

					// Consulta SQL, seleccionamos todos los datos de la tabla y obtenemos solo
					// la fila que tiene el usario especificado
					$query = "SELECT * FROM usuario WHERE NombreUsuario='".$Usuario."'";
					if(!$resultado = $mysqli->query($query)){
						echo "Error: La ejecución de la consulta falló debido a: \n";
						echo "Query: " . $query . "\n";
						echo "Errno: " . $mysqli->errno . "\n";
						echo "Error: " . $mysqli->error . "\n";
						exit;
					}
					else{
						if ($resultado->num_rows == 0) {
							echo "<script languaje='javascript'>
									alert('Usuario no registrado');
								  </script>";
							exit;
						}
						else{
							$ResultadoConsulta = $resultado->fetch_assoc();
							if($ResultadoConsulta['NombreUsuario'] = $Usuario){
								if($ResultadoConsulta['ContraseniaUsuario'] == $password){
									$idPersona = $ResultadoConsulta['idPersona'];
									$query = "SELECT * FROM persona WHERE idPersona='".$idPersona."'";
									if(!$resultado = $mysqli->query($query)){
										echo "Error: La ejecución de la consulta falló debido a: \n";
										echo "Query: " . $query . "\n";
										echo "Errno: " . $mysqli->errno . "\n";
										echo "Error: " . $mysqli->error . "\n";
										exit;
									}
									else{
										$RolUsuario = $ResultadoConsulta['RolUsuario'];
										$ResultadoConsultaPersona = $resultado->fetch_assoc();
										session_start();
										$_SESSION['NombreUsuario'] = $ResultadoConsultaPersona['NombrePersona'] . " " . $ResultadoConsultaPersona['ApellidoPersona'];
										$_SESSION['Usuario'] = $ResultadoConsulta['NombreUsuario'];
										$_SESSION['ContrasenaUsuario'] = $password;
										$_SESSION['idUsuario'] = $ResultadoConsulta['idUsuario'];
										$_SESSION['PrivilegioUsuario'] = $RolUsuario;
										if($RolUsuario == "Administrador"){
											header("location:Administrador.php");
										}
											else if($RolUsuario == "Catedratico"){
												header("location:Catedratico.php");
											}
												else if($RolUsuario == "Estudiante"){
													header("location:Estudiante.php");
												}
									}
								}
								else{
									echo "<script languaje='javascript'>
											alert('Contraseña erronea');
										  </script>";
								}
							}
							else{
								echo "<script languaje='javascript'>
										alert('Usuario erroneo');
									  </script>";
							}
						}
					}
				}
    		?>
        </body>
</html>
