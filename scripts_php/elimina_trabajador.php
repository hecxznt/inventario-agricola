<!DOCTYPE html>
<html lang="en">
<head>
  <title>SmartAgro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                          <li><a class="dropdown-item" href="../rh_cuadrillas.php">Cuadrillas</a></li>
                          <li><a class="dropdown-item" href="../rh_nomina.php">N贸mina</a></li>
                          <li><a class="dropdown-item" href="../rh_alta_trabajadores.php">Trabajadores</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cultivos</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="../riego.php">Riego</a></li>
                          <li><a class="dropdown-item" href="../historico_cultivos.php">Hist贸rico</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Ganado</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="../pesaje.php">Pesaje</a></li>
                          <li><a class="dropdown-item" href="../historico_ganado.php">Hist贸rico</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../catalogos.php">Cat谩logos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../rentabilidad.php">Rentabilidad</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../../index.html"><button type="button" class="btn btn-outline-success">Salir</button></a>
                    </li>    
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4 bg-success text-white text-center">
        <h1>SmartAgro</h1>
    </div>
    
    <h2 align="center">RR.HH.</h2>
    <div class="container mt-3">
        <h4>Eliminar permanente al trabajador</h4>
        <?php
            $id = $_POST['id'];
            //print("$id");
            include("conexion.php");
            if(!$conn=conectar()){
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $sql = "DELETE FROM trabajador WHERE id_trabajador='$id'";
                $query=mysqli_query($conn, $sql);
                if ($query){
                    print(" <div class='alert alert-danger alert-dismissible fade show'>
                                <a href='../rh_alta_trabajadores.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>¡Trababajor eliminado exitosamente!</strong>
                            </div>");
                }
                else{
                    print(" <div class='alert alert-danger alert-dismissible fade show'>
                                <a href='../rh_alta_trabajador.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>No se pudo borrar al trabajador, Error: '. $sql . ' '. mysqli_error($conn);</strong>
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

