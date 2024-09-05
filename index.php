<?php
include "config.php";
$conn = Conexion();

// Verificar si la cookie de sesión está presente y contiene los datos válidos
if (!isset($_COOKIE['sesion_activa'])) {
    // La cookie de sesión no está presente, redirigir al usuario al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}
//Otenemos el folio de la solicitud
$id_solicitud = $_GET['id_solicitud'];

$sqlQuery = "SELECT *,
tipo_solicitud,
(SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM ciudadanos WHERE id_ciudadano = s.id_ciudadano) AS  nombre_ciudadano,
(SELECT nombre_comite FROM comites WHERE id_comites = s.id_comite_solicitante) AS nombre_comite
FROM solicitudes s 
WHERE id_solicitud = :id_solicitud";
$stmt = $conn -> prepare($sqlQuery);
$stmt -> bindParam(':id_solicitud', $id_solicitud);
$stmt -> setFetchMode(PDO::FETCH_ASSOC);
$stmt -> execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC); 

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Consulta Ciudadana</title>
    <link rel="website icon" type="png" href="img/favicon-16x16.png">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- BOOSTRAP -->
    <link href="css/bootstrap.min.css" rel="stylesheet" >
    
    <!-- cargar jquery -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> -->


</head>


<body id="page-top" onload="noVolver();">

    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow border-bottom-secondary d-print-none">
                    <!-- <img class="img-profile m-2 " src="img/ESCUDO-ARMAS.png" width="auto" height="60"> -->
                    <!-- <img class="img-profile m-2 " src="img/SEVIVEBIEN.png" width="auto" height="60"> -->
                    <img class="img-profile m-3 " src="img/logo.png" width="60" height="60">
                    <h5 class="align-text-bottom pt-2 ml-2"><b>MODULO DE CONSULTA CIUDADANA</b></h5>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <?php 
                        // include "includes/message-center.php"; 
                        ?>
                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle border border-0" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <b><?= ($row['tipo_solicitud'] == 0) ? $row['nombre_ciudadano'] : $row['nombre_comite'] ; ?></b>
                                    <br>
                                    Tipo de solicitud: <i><?= ($row['tipo_solicitud'] == 0) ? 'Individual' : 'Colectiva'; ?></i>
                                </span>
                                <img class="img-profile rounded-circle" src="img/user-placeholder.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in mr-4" aria-labelledby="userDropdown">
                                <a id="btnSalir" class="dropdown-item" href="#">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-900"></i>
                                    Cerrar Sesión
                                </a>
                            </div> -->
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <?php
    
                if($row['tipo_solicitud'] === 0) {
                    include "pages/individual.php";
                } else {
                    include "pages/colectiva.php";
                }
               
                
                ?>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer d-print-none bg-danger-subtle" > -->
            <div class="sticky-footer d-print-none d-flex justify-content-center border-top border-secondary border-4 shadow">
                    <div class="row d-flex w-100">
                        <div class="col text-center my-1">
                            <h6><b>CONTACTO</b></h6>
                            <p ><i class="fas fa-map-marker"></i> AV. Reforma S/N.
                            C.P. 94220, Col. Manuel Gonzalez,
                            Zentla, Veracruz. <br>
                            <i class="fas fa-phone"></i>
                            (273) 73 5 31 11 <b>-</b> 73 5 30 99 <b>-</b> 73 5 30 77 <br>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:ayuntamientozentla2022.2025@gmail.com">ayuntamientozentla2022.2025@gmail.com</a></p>
                        </div>
                        
                        <div class="col my-2"> 
                            <div class="copyright text-center my-auto">
                                <img class="img-profile" src="img/SEVIVEBIEN.png" width="50%">
                                <p class="fs-6 mt-4"> Copyright &copy; 2024. H. Ayuntamiento de Zentla, Ver.</p>
                            </div>
                        </div>
                        
                        <div class="col text-center">
                            <div class="social-icons d-flex justify-content-center">
                                <div class="d-flex flex-column">
                                    <h6><b> REDES </b></h6>
                                        
                                    <div class="d-flex flex-row">
                                        <div class="form-group d-flex flex-column">
                                            <a class="text-primary" href="https://www.facebook.com/Zentla2025" target="_blank"><i class="fab fa-facebook-square fa-lg"></i></a>
                                            <span class="text-primary">Facebook</span>
                                        </div>
                                    
                                        <div class="form-group d-flex flex-column">
                                            <a class="text-success" href="https://wa.me/2731111426" target="_blank"><i class="fab fa-whatsapp-square fa-lg"></i></a>
                                            <span class="text-success">Whatsapp</span>
                                        </div>
                                    </div>   
                                    
                                </div>
                                
                                <div class="d-flex flex-column">
                                    <h6><b>AYUDA</b></h6>
                                
                                    <div class="form-group d-flex flex-column">
                                        <a class="text-warning-emphasis" href="Manual/Manual.pdf" target="_blank"><i class="fas fa-book fa-lg"></i></a>
                                        <span class="text-warning-emphasis">Manual de usuario</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <!-- </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded d-print-none" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Librería Sweet Alert (Dialogos) -->
    <script src="js/sweetalert2@11.js"></script>

</body>

</html>
<script>
    
    $('#btnSalir').click(function(e){
    e.preventDefault();
        Swal.fire({
            title: "Cerrar Sesión",
            text: "¿Seguro que desea cerrar la sesión actual?",
            icon: "info",
            confirmButtonColor: "#0d6efd",
            confirmButtonText: "Confirmar",
            cancelButtonColor: "#dc3545",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            customClass: {
                icon: 'fa-2x'
            },
            iconHtml: '<i class="fas fa-door-open"></i>' 
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "¡Cerrando sesión!",
                    text: "Gracias por visitar nuestro modulo de consulta, vuelva pronto",
                    icon: "success",
                    confirmButtonColor: "#1FBF84",
                    confirmButtonText: "Aceptar",
                    customClass: {
                    icon: 'fa-2x'
                    },
                    iconHtml: '<i class="fas fa-door-closed"></i>' 
                }).then((result) => {
                    window.location.href = "php/cerrar.php";
                });
            }
        });
    });
    
    //funcion que se ejecuta cuando el usuario quiere volver atras mediante el navegador
    window.history.forward();
    function noVolver() {
        window.history.forward();
    }
</script>