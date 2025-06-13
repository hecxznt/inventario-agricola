<!DOCTYPE html>
<html lang="en">
<head>
  <title>SmartAgro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
   
    <div class="container-fluid p-4 bg-success text-white text-center">
        <h1>SmartAgro</h1>
    </div>
    
    <h2 align="center">RR.HH.</h2>
    <div class="container mt-3">
        <h3>Pase de lista</h3>
        <?php
            $id = $_GET["id"];
            date_default_timezone_set('America/Monterrey');
            $fecha_hora_registro = date("Y-m-d - g:i a"); 
            $fecha = substr($fecha_hora_registro, 0 ,10);
            $hora_salida = substr($fecha_hora_registro, -8);
            //print("$id $fecha $hora_salida");
            include("conexion.php");
            if(!$conn=conectar()){
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $sql = "UPDATE pase_lista SET salida='V', hora_salida='$hora_salida' WHERE id_trabajador='$id' AND fecha_registro='$fecha'";
                if (mysqli_query($conn, $sql)){
                    print(" <div class='alert alert-primary alert-dismissible fade show'>
                                <a href='../rh_nomina.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>¡Registro de salida exitoso!</strong> $hora_salida
                            </div>
                    ");
                }
                else{
                    print(" <div class='alert alert-danger alert-dismissible fade show'>
                                <a href='../rh_nomina.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>No se pudo gardar el registro, Error: '. $sql . ' '. mysqli_error($conn);</strong>
                            </div>
                    ");
                }
            }
            
            mysqli_close($conn);
        ?>
    </div>
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>

