<!DOCTYPE html>
<html lang="en">
<head>
    <title>SmartAgro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .auto-width {
            white-space: nowrap; /* Evita que el contenido se divida en varias líneas */
            width: 1px; /* Ajusta al contenido */
        }
    </style>
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
    
    <h2 align="center">RR.HH.</h2>
    <div class="container mt-3">
        <form class="d-flex">
            <input class="form-control me-2" type="text" id="myInput" placeholder="Buscar trabajador">
            <button class="btn btn-warning" type="button">Buscar</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bi bi-person-plus-fill"></i></button>
        </form>
    </div>
    <div class="container mt-3">
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th class='auto-width' style="text-align: center">#</th>
                        <th class='auto-width' style="text-align: center">Nombre</th>
                        <th class='auto-width' style="text-align: center">Pueso</th>
                        <th class='auto-width' style="text-align: center">Teléfono</th>
                        <th class='auto-width' style="text-align: center">Foto</th>
                        <th class='auto-width' style="text-align: center">Ver más</th>
                        <th class='auto-width' style="text-align: center">Editar</i></th>
                        <th class='auto-width' style="text-align: center">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php
                        include("scripts_php/conexion.php");
                        $conn=conectar();
                        $sql = "SELECT * FROM trabajador";
                        $result = $conn->query($sql);
                        $registro=1;
                        if ($result->num_rows > 0) {
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $id = $row["id_trabajador"];
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
                                
                                $sql_cargo = "SELECT puesto FROM puesto_salario WHERE id_puesto_salario=$cargo";
                                $resultado=mysqli_query($conn,$sql_cargo);
                                $record=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                                $puesto=$record["puesto"];
                                print("
                                    <tr>
                                        <td class='auto-width' style='text-align: right'>$registro</td>
                                        <td class='auto-width'>$nombre_completo</td>
                                        <td class='auto-width'>$puesto</td>
                                        <td class='auto-width'>$tel</td>
                                        <td class='auto-width' style='text-align: center'><img src='imagenes/trabajadores/$foto' width='70' height='70' onclick='ampliarImagen(this)'/></td>
                                        <td class='auto-width' style='text-align: center'><a href='rh_ver_trabajador.php?id=$id'><i class='bi bi-search'></i></a></td>
                                        <td style='text-align: center'><a href='rh_actualiza_trabajador.php?id=$id'><i class='bi bi-pen-fill'></i></a></td>
                                        <td style='text-align: center'><a href='rh_elimina_trabajador.php?id=$id'><i style='color: red;' class='bi bi-trash3-fill'></td></i>
                                    </tr>
                                ");
                                $registro++;
                            }
                            $result->free();
                        }
                        else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                        mysqli_close($conn);
                   ?>
                </tbody>
            </table>
        </div>
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

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    
    <!-- The Modal Alta-->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Agregar trabajador</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="scripts_php/guardar_trabajador.php" method="post" enctype="multipart/form-data" data-aos="fade-up" data-aos-delay="500">
                        <div class="mb-3 mt-3">
                            <input type="text" class="form-control" placeholder="Nombre(s)" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="nombre" required>
                            <input type="text" class="form-control" placeholder="Apellido Paterno" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="apellido_paterno" required>
                            <input type="text" class="form-control" placeholder="Apellido Materno" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="apellido_materno" required>
                        </div>
                        <label for="genero">Genero:</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio1" name="genero" value="Femenino" checked>
                            <label class="form-check-label" for="radio1">Femenino</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio1" name="genero" value="Masculino">
                            <label class="form-check-label" for="radio2">Masculino</label>
                        </div>
                        <div class="mb-3">
                            <label for="Fecha_nacimiento">Fecha de nacimiento: </label>
                            <input type="date" class="form-control" id="fecha" name="fecha_nacimiento"  required>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" id="inputImagen" name="foto" accept="image/*">
                            <div class="card" style="width: 15rem;">
                                <img id="previewImagen" src="imagenes/usuario.png" class="card-img-top" alt="Vista previa">
                                <div class="card-body">
                                    <p class="card-text">Imagen seleccionada.</p>
                                </div>
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
                        <div class="mb-3">
                            <input type="number" class="form-control" placeholder="NSS/Número de Seguridad Social" name="nss" minlength="11" maxlength="11" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="CURP/Clave Única de Registro de Población" name="curp" minlength="18" maxlength="18" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control" placeholder="Calle y número" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ1234567890\s]+" name="calleynum" required>
                            <input type="text" class="form-control" placeholder="Colonia" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="colonia" required>
                            <input type="text" class="form-control" placeholder="Municipio" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="municipio" required>
                            <input type="text" class="form-control" placeholder="Estado" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="estado" required>
                            <input type="number" class="form-control" placeholder="Código postal" name="cp" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel">Contacto:</label>
                            <div class="col">
                               <input type="tel" class="form-control" id="tel" placeholder="Teléfono/Móvil" name="tel" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Correo electrónico" name="email" name="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="puesto">Puesto/cargo:</label>
                            <select class='form-select' id='sel1' name='cargo'>
                            <?php  
                                // include("scripts_php/conexion.php");
                                $connect=conectar();
                                $sql_cargos = "SELECT * FROM puesto_salario";
                                $resultados=mysqli_query($connect,$sql_cargos);
                                if ($resultados->num_rows > 0) {
                                    while($records=mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
                                        $id_puesto=$records['id_puesto_salario'];
                                        $puestos=$records['puesto'];
                                        echo "$puestos";
                                        print("<option value='$id_puesto'>$puestos</option>");
                                    }
                                    $resultados->free();
                                }
                                else {
                                    echo "Error: " . $sql_cargos . "<br>" . mysqli_error($connect);
                                }
                                mysqli_close($connect);
                             ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Fecha_ingreso">Fecha de ingreso: </label>
                            <input type="date" name="fecha_ingreso" class="form-control" id="fecha" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-block" >Guardar</button>
                        </div>
                    </form> 
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>
    