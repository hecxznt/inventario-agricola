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
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-success" href="menu.php">Inicio</a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">RR.HH.</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="rh_cuadrillas.php">Cuadrillas</a></li>
                          <li><a class="dropdown-item" href="rh_nomina.php">Nómina</a></li>
                          <li><a class="dropdown-item" href="rh_alta_trabajadores.php">Trabajadores</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cultivos</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="riego.php">Riego</a></li>
                          <li><a class="dropdown-item" href="historico_cultivos.php">Histórico</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Ganado</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="pesaje.php">Pesaje</a></li>
                          <li><a class="dropdown-item" href="historico_ganado.php">Histórico</a></li>
                        </ul>
                    </li>
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Inventario</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="inventario-agricola/secciones/productos/">Dashboard</a></li>
                          <li><a class="dropdown-item" href="inventario-agricola/secciones/movimientos/">Movimientos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="rentabilidad.php">Rentabilidad</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../index.html"><button type="button" class="btn btn-outline-success">Salir</button></a>
                    </li>    
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4 bg-success text-white text-center">
        <h1>SmartAgro</h1>
    </div>
    
    <div class="container mt-3">
        <h2>RECURSOS HUMANOS</h2>
        <h4>Actualización de Salida</h4>
        <?php
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $date = $_POST['date'];
            $salida_nueva = date("h:i A", strtotime($_POST["salida_nueva"]));
            date_default_timezone_set('America/Monterrey');
            $fecha_cambio = date("Y/m/d"); 
            //print("$id $nombre $date $salida_nueva");
    
            include("conexion.php");
            if(!$conn=conectar()){
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $sql = "UPDATE pase_lista SET hora_salida = '$salida_nueva', fecha_registro = '$fecha_cambio' WHERE id_trabajador='$id' AND fecha_lista = '$date'";
                $query=mysqli_query($conn, $sql);
                if ($query){
                    print(" <div class='alert alert-primary alert-dismissible fade show'>
                                <a href='../rh_nomina.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>¡La hora de salida ha sido actualizada exitosamente!</strong>
                            </div>");
                }
                else{
                    print(" <div class='alert alert-danger alert-dismissible fade show'>
                                <a href='../rh_nomina.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>No se pudo actualizar la hora de salida, Error: '. $sql . ' '. mysqli_error($conn);</strong>
                            </div>");
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