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
        <h3>Actualizaci&oacute;n de trabajadores</h3>
        <?php
            $id=$_POST['id'];
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
            
            $nombre_foto = $_FILES['foto_nueva']['tmp_name'];
            //print("$id $nombre, $apellido_paterno, $apellido_materno, $genero, $fecha_nacimiento, $foto, $nombre_foto, $nss, $curp, $calleynum, $colonia, $municipio, $estado, $cp, $email, $tel, $cargo, $fecha_ingreso");
            
            if (strlen($nombre_foto)>0) {
                $tipo = $_FILES['foto_nueva']['type'];
                $size = $_FILES['foto_nueva']['size'];
                $temp = $_FILES['foto_nueva']['tmp_name'];
                $foto = $_FILES['foto_nueva']['name'];
                
                if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000)) {
                    print(" <div class='alert alert-warning alert-dismissible fade show'>
                                <a href='javascript:history.back(-1);'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                                <strong>¡Error!</strong> La extensión o el tamaño de la foto es correcto (Se permiten archivos .jpg, .png. y de 200 kb como máximo.)
                            </div>
                    ");
                }
                else {
                    if (move_uploaded_file($temp, '../imagenes/trabajadores/'.$foto)) {
                        echo '&#161;La imagen se ha acutalizado correctamente!</br>';
                    }
                }
            }
            include("conexion.php");
            if(!$conn=conectar()){
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $sql="UPDATE trabajador SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', genero='$genero', fecha_nacimiento='$fecha_nacimiento', foto='$foto', nss='$nss', curp='$curp', calleynum='$calleynum', colonia='$colonia', municipio='$municipio', estado='$estado', cp='$cp', tel='$tel', email='$email', cargo=$cargo, fecha_ingreso='$fecha_ingreso' WHERE id_trabajador=$id";
                if (mysqli_query($conn, $sql)){
                    print(" 
                        <div class='alert alert-success alert-dismissible fade show'>
                            <a href='../rh_alta_trabajadores.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                            <strong>&#161;Registro actualizado exitosamente!</strong>
                        </div>
                    ");
                }
                else
                {
                    print(" 
                        <div class='alert alert-danger alert-dismissible fade show'>
                            <a href='../rh_alta_trabajadores.php'><button type='button' class='btn-close' data-bs-dismiss='alert'></button></a>
                            <strong>No se pudo actualizar el registro, Error: '. $sql . ' '. mysqli_error($conn);</strong>
                        </div>"
                    );
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

