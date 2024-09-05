<?php
// Eliminar la cookie de sesión para cerrar la sesión
setcookie('sesion_activa', '', time() - 3600, "/");
header("Location: ../login.php"); // Redirigir al formulario de inicio de sesión
exit();
?>
