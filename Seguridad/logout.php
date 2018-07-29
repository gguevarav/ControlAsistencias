<?php
	// Iniciamos y destruimos la sesión
	session_start();
	session_destroy();
	// Redirigimos el usuario al index
	header('location:../index.php');
?>