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
        <h3>Registro de puesto y salario</h3>
        <?php
            $puesto = $_POST["puesto"];
            $salario = $_POST["salario"];
           
            include("conexion.php");
            date_default_timezone_set('America/Monterrey');
            $fecha = date("d/m/Y");
            
            //echo "$puesto $salario $fecha"
            if(!$conn=conectar()){
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $sql = "INSERT INTO puesto_salario (id_puesto_salario, puesto, salario, fecha_registro) VALUES (0, '$puesto', '$salario', '$fecha')";
                if (mysqli_query($conn, $sql)){
                    print(" <div class='alert alert-info alert-dismissible fade show'>
                                <a href='../catalogos.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>¡Registro guardado exitosamente!</strong>
                            </div>
                    ");
                }
                else{
                    print(" <div class='alert alert-danger alert-dismissible fade show'>
                                <a href='../catalogos.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
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

