<?php
    include "../config.php";
    $conn = Conexion();
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usr = $_POST['folio'];
    $pwd = $_POST['password'];    
    $hashedPassword = substr(md5($usr . "Zentla24"), 0, 6);
    
    $stmt = $conn -> prepare("SELECT COUNT(*) AS 'N' FROM solicitudes WHERE folio_seguimiento = :usr");
    $stmt -> bindParam(':usr', $usr);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if ($row['N'] == "1" && $pwd == $hashedPassword) {
    
        $sqlquery = "SELECT
        id_solicitud
        FROM solicitudes 
        WHERE folio_seguimiento = :folio";
        $stmt = $conn -> prepare($sqlquery);
        $stmt -> bindParam(':folio', $usr);
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
        // Establecer la cookie de sesión con un tiempo de expiración
        setcookie('sesion_activa', '1', time() + (86400 * 1), "/");
        header("Location: ../index.php?id_solicitud=".$row['id_solicitud']); // Redirigir al usuario al panel de control o dashboard
        exit();
    } else {
        // Credenciales incorrectas, redirigir al formulario de inicio de sesión con un mensaje de error
        echo ("El folio o contraseña ingresados son incorrectos, favor de verificarlos.");
        header("Location: ../login.php?error=1");
        exit();
    }   
    
} 
?>