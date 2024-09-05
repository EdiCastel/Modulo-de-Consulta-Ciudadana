<?php
include "config.php";
$conn = Conexion();

$id_solicitud = $_GET['id_solicitud'];

    $sqlquery = "SELECT *,
    id_ciudadano,
    descripcion_solicitud,
    beneficiarios,
    (SELECT fecha FROM historial_estados WHERE id_solicitud = s.id_solicitud LIMIT 1) AS fecha,
    (SELECT nombre FROM estados WHERE  id_estado = s.id_estado_solicitud LIMIT 1) AS id_estado_solicitud,
    (SELECT nombre_apoyo FROM tipos_apoyo WHERE  id_tipo_apoyo = s.id_tipo_apoyo LIMIT 1) AS id_tipo_apoyo,
    (SELECT departamento FROM departamentos WHERE  id_departamento = s.id_departamento_asignado LIMIT 1) AS id_departamento_asignado
    FROM solicitudes s
    WHERE id_solicitud = :id";
    $stmt = $conn -> prepare($sqlquery);
    $stmt -> bindParam(':id', $id_solicitud);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    $sqlQuery1 = "SELECT 
    nombre,
    apellido_paterno,
    apellido_materno,
    (SELECT nombre FROM localidades WHERE id_localidad = c.id_localidad) AS id_localidad
    FROM ciudadanos c 
    WHERE id_ciudadano = :id_ciudadano";
    $stmt1 = $conn -> prepare($sqlQuery1);
    $stmt1 -> bindParam(':id_ciudadano', $row['id_ciudadano']);
    $stmt1 -> setFetchMode(PDO::FETCH_ASSOC);
    $stmt1 -> execute();
    $row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC);

?>


<div class="mb-4">
  <div class="container pt-5 ">
      <div class="d-flex justify-content-between">
        <img class="img-profile mt-1" src="img/logo.png" width="60" height="60">
        <h2 class="text-center"><b>CONSULTA DE ESTADO DE SOLICITUD</b></h2>
        <img class="img-profile mt-1" src="img/ESCUDO-ARMAS.png" width="60" height="60">
      </div>

      <hr class="border border-dark border-3 opacity-75">
      <!-- <h2 class="text-center"><b>Detalles de la solicitud:</b></h2> -->
      <div class="row d-flex justify-content-center">
        <div class = "row">

        <div class= "col" >

            <label class="h5 text-dark">Datos de la solicitud</label>
            <hr class="border border-dark border-1">
            <div class="form-group">
                <label class="h6 text-dark">Tipo de apoyo: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"> <?= $row['id_tipo_apoyo'];?> </label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Departamento: </label>  
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row['id_departamento_asignado'];?></label> 
            </div>

            <div class="form-group">
                <label class="h6 text-dark">Descripción de la solicitud: </label>  
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row['descripcion_solicitud'];?></label> 
            </div>
            

            <div class="form-group">
                <label class="h6 text-dark">Total de beneficiarios: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row['beneficiarios'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Fecha de ingreso: </label>  
            </div>
            <div class="form-group"> 
                <label class="h6 text-black-50"> <?= $row['fecha_registro'];?> </label> 
            </div>
            
            <div class="form-group d-flex flex-column">
                <label class="h6 text-dark">Estado de la solicitud: </label>
            </div>
            
            <div class="form-group">
                <label id="estado" class="h6 text-black-50"><?= $row['id_estado_solicitud'];?></label> 
            </div>
            
            <div class="form-group d-flex flex-column">
                <label class="h6 text-dark">Fecha de la ultima modificación: </label>
            </div>
            
            <div class="form-group">
                <label id="estado" class="h6 text-black-50"><?= $row['fecha'];?></label> 
            </div>
        </div>  
        


        <div class="col">  
    
            <label class="h5 text-dark">Datos del ciudadano</label>
            <hr class="border border-dark border-1">
            <div class="form-group">
                <label class="h6 text-dark">Nombre: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row1['nombre'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark fl">Apellido paterno: </label> 
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row1['apellido_paterno'];?></label> 
            </div>

            <div class="form-group">
                <label class="h6 text-dark fl">Apellido materno: </label>  
            </div>
            <div class="form-group">
                <label class="h6 text-black-50"><?= $row1['apellido_materno'];?></label> 
            </div>
            
            <div class="form-group">
                <label class="h6 text-dark">Localidad: </label>  
            </div>
            <div class="form-group"> 
                <label class="h6 text-black-50"><?= $row1['id_localidad'];?></label> 
            </div>
           
        
        </div>
    </div>

      <hr class="border border-dark border-1 d-print-none"><br>

      <div class="form-group d-flex justify-content-center"> 
        <a href="#" class="btn btn-primary mr-5 w-25 d-print-none" onclick="window.print();">
          Imprimir formato <i class="fas fa-print"></i>
        </a>
        <button class="btn btn-success mr-5 w-25 d-print-none" type="submit" id="btnSalir2">
        Salir <i class="fas fa-sign-out-alt ml-2"></i>    
        </button>
      </div>
  </div>
</div>


<script>
    
    $('#btnSalir2').click(function(e){
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
                icon: "warning",
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
    
</script>