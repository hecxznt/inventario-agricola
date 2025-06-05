<!DOCTYPE html>
<html lang="en">
<head>
    <title>SmartAgro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos del fondo oscuro (modal) */
        .modal_foto {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Imagen dentro del modal */
        .modal_foto img {
            display: block;
            max-width: 80%;
            max-height: 80%;
            margin: auto;
            margin-top: 5%;
            border-radius: 10px;
        }
    </style>
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
        <h2 align="center">RR.HH.</h2>
        <h3>Datos del trabajador</h3>
        <?php
            $id=$_GET["id"];
            include("scripts_php/conexion.php");
            $conn=conectar();
            $sql = "SELECT * FROM trabajador WHERE id_trabajador='$id'";
            $result = $conn->query($sql);
            if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $nombre = $row["nombre"];
                $apellido_paterno = $row["apellido_paterno"];
                $apellido_materno = $row["apellido_materno"];
                $genero = $row["genero"];
                $fecha_nacimiento = $row["fecha_nacimiento"];
                $foto = $row["foto"];
                $nss = $row["nss"];
                $curp = $row["curp"];
                $calleynum = $row["calleynum"];
                $colonia = $row["colonia"];
                $municipio = $row["municipio"];
                $estado = $row["estado"];
                $cp = $row["cp"];
                $tel = $row["tel"];
                $email = $row["email"];
                $cargo = $row["cargo"];
                $fecha_ingreso = $row["fecha_ingreso"];
                $fecha_registro = $row["fecha_registro"];
                $nombre_completo=$nombre. ' '.$apellido_paterno. ' '.$apellido_materno;
                $sql_cargo = "SELECT * FROM puesto_salario WHERE id_puesto_salario=$cargo";
                $resultado=mysqli_query($conn,$sql_cargo);
                if($record=mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
                    $puesto=$record["puesto"];
                    $salario=$record["salario"];
                    $sueldo = "$" . number_format($salario, 2, '.', ',');
                }
                else{
                    print("Error de consulta");
                }
                print("
                    <form action='#' method='post' enctype='multipart/form-data' data-aos='fade-up' data-aos-delay='500'>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Nombre</span>
                            <input type='text' class='form-control' placeholder='$nombre_completo'disabled>
                        </div>
                ");
                if($genero=="Femenino"){
                    print("
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Genero</span>
                            <input type='text' class='form-control' placeholder='$genero' disabled>
                        </div>
                    ");
                }
                else{
                    print("
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Genero</span>
                            <input type='text' class='form-control' placeholder='$genero' disabled>
                        </div>
                    ");
                }
                print("
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Fecha de nacimiento</span>
                            <input type='text' class='form-control' value='$fecha_nacimiento' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <div class='card' style='width: 15rem;'>
                                <img id='previewImagen' src='imagenes/trabajadores/$foto' class='card-img-top' alt='Vista previa' onclick='ampliarImagen(this)'>
                            </div>
                        </div>
                        <script>
                            document.getElementById('inputImagen').addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('previewImagen').src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>NSS</span>
                            <input type='number' class='form-control' placeholder='$nss' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>CURP</span>
                            <input type='text' class='form-control' placeholder='$curp' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Dirección</span>
                            <input type='text' class='form-control' placeholder='$calleynum, $colonia' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <input type='text' class='form-control' placeholder='$municipio, $estado, $cp' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Dirección</span>
                            <input type='tel' class='form-control' id='tel' placeholder='$tel'  disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Correo electrónico</span>
                            <input type='text' class='form-control' placeholder='$email' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Puesto/cargo</span>
                            <input type='text' class='form-control' placeholder='$puesto' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Salario</span>
                            <input type='text' class='form-control' placeholder='$sueldo' disabled>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Fecha de ingreso</span>
                            <input type='text' class='form-control'  placeholder='$fecha_ingreso' disabled>
                        </div>
                        <div class='d-grid'>
                            <button type='button' class='btn btn-warning btn-block' onclick='window.history.back()'>Regresar</button>
                        </div>
                    </form> 
                ");
                $result->free();
            }
            else {
                echo "Error: " . $sql_Cargos . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
       ?>
    </div>
        
    <div id="modal_foto" class="modal_foto" onclick="cerrarModal()">
        <img id="imagen-ampliada">
    </div>

    <script>
        function ampliarImagen(imagen) {
            const modal = document.getElementById("modal_foto");
            const imgAmpliada = document.getElementById("imagen-ampliada");

            imgAmpliada.src = imagen.src; // Copia la imagen al modal
            modal.style.display = "block";
        }

        function cerrarModal() {
            document.getElementById("modal_foto").style.display = "none";
        }
    </script>

    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>
    