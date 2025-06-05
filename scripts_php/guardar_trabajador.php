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
    
    <h2 align="center">RR.HH.</h2>
    <div class="container mt-3">
        <h3>Alta de trabajadores</h3>
        <?php
            $nombre = $_POST["nombre"];
            $apellido_paterno = $_POST["apellido_paterno"];
            $apellido_materno = $_POST["apellido_materno"];
            $genero = $_POST["genero"];
            $fecha_nacimiento = date("d/m/Y", strtotime($_POST["fecha_nacimiento"]));
            $foto = $_POST["foto"];
            $nss = $_POST["nss"];
            $curp = $_POST["curp"];
            $calleynum = $_POST["calleynum"];
            $colonia = $_POST["colonia"];
            $municipio = $_POST["municipio"];
            $estado = $_POST["estado"];
            $cp = $_POST["cp"];
            $email = $_POST["email"];
            $tel = $_POST["tel"];
            $cargo = $_POST["cargo"];
            $fecha_ingreso = date("d/m/Y", strtotime($_POST["fecha_ingreso"]));
            
            //$nombre_foto = $_FILES['foto']['tmp_name'];
            //print("$nombre, $apellido_paterno, $apellido_materno, $genero, $fecha_nacimiento, $nombre_foto, $nss, $curp, $calleynum, $colonia, $municipio, $estado, $cp, $email, $tel, $cargo, $fecha_ingreso");
            
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['foto']['type'];
            $size = $_FILES['foto']['size'];
            $temp = $_FILES['foto']['tmp_name'];
            $name = $_FILES['foto']['name'];
            //print("<br>$tipo $size $temp $name");
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000)) {
                print(" <div class='alert alert-warning alert-dismissible fade show'>
                            <a href='../menu.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                            <strong>¡Error!</strong> La extensión o el tamaño de la foto es correcto (Se permiten archivos .jpg, .png. y de 200 kb como máximo.)
                        </div>");
            }
            else {
                if (move_uploaded_file($temp, '../imagenes/trabajadores/'.$name)) {
                    echo '<b>Se ha subido correctamente la imagen.</b>';
                    include("conexion.php");
                    if(!$conn=conectar()){
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    else{
                        date_default_timezone_set('America/Monterrey');
                        $fecha_registro = date("d/m/Y");
                        $sql = "INSERT INTO trabajador (id_trabajador, nombre, apellido_paterno, apellido_materno, genero, fecha_nacimiento, foto, nss, curp, calleynum, colonia, municipio, estado, cp, tel, email, cargo, fecha_ingreso, fecha_registro) VALUES (0, '$nombre', '$apellido_paterno', '$apellido_materno', '$genero', '$fecha_nacimiento', '$name', '$nss', '$curp', '$calleynum', '$colonia', '$municipio', '$estado', '$cp', '$tel', '$email', '$cargo', '$fecha_ingreso', '$fecha_registro');";
                        if (mysqli_query($conn, $sql)){
                            print(" <div class='alert alert-success alert-dismissible fade show'>
                                        <a href='../menu.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                        <strong>¡Registro guardado exitosamente!</strong>
                                    </div>");
                        }else
                            {
                            print(" <div class='alert alert-danger alert-dismissible fade show'>
                                        <a href='../menu.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                        <strong>No se pudo gardar el registro, Error: '. $sql . ' '. mysqli_error($conn);</strong>
                                    </div>");
                            }
                    }
                    mysqli_close($conn);
                }
                else{
                    print(" <div class='alert alert-danger alert-dismissible fade show'>
                                <a href='../menu.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>¡Ocurrió algún error al intenter gardar el registro!</strong>
                            </div>");
                }
            }
        ?>
    </div>
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>

