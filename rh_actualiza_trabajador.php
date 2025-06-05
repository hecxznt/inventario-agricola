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
        <h4>Actualización de datos del trabajador</h4>
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
                $newDate = date("Y-m-d", strtotime($fecha_nacimiento));
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
                
                $sql_cargo = "SELECT puesto FROM puesto_salario WHERE id_puesto_salario=$cargo";
                $resultado=mysqli_query($conn,$sql_cargo);
                $record=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                $puesto=$record["puesto"];
                
                $fecha_ingreso = $row["fecha_ingreso"];
                $nuevaFecha = date("Y-m-d", strtotime($fecha_ingreso));
                $nombre_completo=$nombre. ' '.$apellido_paterno. ' '.$apellido_materno;
              
                print("
                    <form action='scripts_php/actualizar_trabajador.php' method='post' enctype='multipart/form-data' id='miFormulario'>
                         <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Nombre:</span>
                            <input type='text' class='form-control form-control-sm' placeholder='Nombre(s)' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='nombre' value='$nombre' />
                        </div>
                          <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Apellido Parerno:</span>
                            <input type='text' class='form-control form-control-sm' placeholder='Apellido Paterno' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='apellido_paterno' value='$apellido_paterno' />
                        </div>
                         <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Apellido Materno:</span>
                            <input type='text' class='form-control form-control-sm' placeholder='Apellido Materno' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='apellido_materno' value='$apellido_materno' />
                        </div>
                ");        
                        if($genero=='Femenino'){
                            print("
                                <div class='input-group mb-3 input-group-sm'>
                                    <span class='input-group-text'>Genero:</span>
                                    <input type='text' class='form-control' placeholder='$genero' name='genero' value='$genero'>
                                    <div class='form-check form-switch'>
                                        <label for='generoSwitch'>Cambiar a:</label>
                                        <input class='form-check-input' type='checkbox' id='generoSwitch' onchange='cambiarGenero()' name='genero' value='Masculino'>
                                        <span id='generoTexto'>Masculino</span>
                                    </div>
                                </div>
                            ");
                        }
                        else{
                            print("
                                <div class='input-group mb-3 input-group-sm'>
                                    <span class='input-group-text'>Genero:</span>
                                    <input type='text' class='form-control' placeholder='$genero' name='genero' value='$genero'>
                                    <div class='form-check form-switch'>
                                        <label for='generoSwitch'>Cambiar a:</label>
                                        <input class='form-check-input' type='checkbox' id='generoSwitch' onchange='cambiarGenero()' name='genero' value='Femenino'>
                                        <span id='generoTexto'>Femenino</span>
                                    </div>
                                </div>
                            ");
                        }
                print("
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Fecha de nacimiento:</span>
                            <input type='date' class='form-control form-control-sm' value='$newDate' name='fecha_nacimiento' />
                        </div>
                        <div class='mb-3'>
                            <div class='card' style='width: 15rem;'>
                                <img id='previewImagen' src='imagenes/trabajadores/$foto' class='card-img-top' alt='Vista previa'>
                                <div class='card-body'>
                                    <p class='card-text'>Imagen registrada </p>
                                </div>
                            </div>
                            <input type='file' class='form-control form-control-sm' id='inputImagen' name='foto_nueva'  accept='image/*'>
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
                            <span class='input-group-text'>NSS:&nbsp;&nbsp;</span>
                            <input type='number' class='form-control' placeholder='$nss' name='nss' value='$nss' minlength='11' maxlength='11' >
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>CURP:</span>
                            <input type='text' class='form-control' placeholder='$curp' name='curp' value='$curp' minlength='18' maxlength='18' >
                        </div>
                        <label for='direccion'>Dirección:</label>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Calle y número:</span>
                            <input type='text' class='form-control' placeholder='$calleynum' value='$calleynum' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ1234567890\s]+' name='calleynum' >
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Colonia:&nbsp;&nbsp;&nbsp;</span>
                            <input type='text' class='form-control' placeholder='$colonia' value='$colonia' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='colonia' >
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Municipio:</span>
                            <input type='text' class='form-control' placeholder='$municipio' value='$municipio' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='municipio' >
                        </div>
                         <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Estado:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type='text' class='form-control' placeholder='$estado' value='$estado' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='estado' >
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Código Postal:</span>
                            <input type='number' class='form-control' placeholder='$cp' value='$cp' name='cp' >
                        </div>
                        <label for='tel'>Contacto:</label>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Teléfono/Móvil:</span>
                            <input type='tel' class='form-control' id='tel' placeholder='$tel' value='$tel' name='tel' >
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Correo electrónico:</span>
                            <input type='text' class='form-control' placeholder='$email' value='$email' name='email'>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Puesto/cargo:</span>
                            <input type='text' class='form-control' placeholder='$puesto'disabled/>
                            <select class='form-select' id='sel1' name='cargo'>
                            <option value='$cargo'>Cambiar</option>
                    ");
                        $sql_cargos = "SELECT * FROM puesto_salario";
                        $resultados=mysqli_query($conn,$sql_cargos);
                        while($records=mysqli_fetch_array($resultados, MYSQLI_ASSOC)) {
                            $id_puesto=$records['id_puesto_salario'];
                            $puestos=$records['puesto'];
                            print("<option value='$id_puesto'>$puestos</option>");
                        }
                        $resultados->free();
                        
                print("        
                            </select>
                        </div>
                        <div class='input-group mb-3 input-group-sm'>
                            <span class='input-group-text'>Fecha de ingreso:</span>
                            <input type='date' class='form-control form-control-sm' value='$nuevaFecha' name='fecha_ingreso' id='fecha'/>
                        </div>
                        <div class='d-grid'>
                            <input type='hidden' name='foto' value='$foto'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit' class='btn btn-warning btn-block' id='btnSubmit'>Actualizar datos</button>
                            <button type='button' class='btn btn-primary btn-block' onclick='history.back()'><i class='bi bi-arrow-left-square-fill'></i> Regresar</button>
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
    
   <script>
    document.getElementById("miFormulario").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío inmediato del formulario

        let btn = document.getElementById("btnSubmit");
        btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...`;
        btn.disabled = true; // Deshabilita el botón para evitar múltiples clics

        // Simula un envío con retardo (reemplazar con una petición real)
        setTimeout(() => {
            this.submit(); // Envía el formulario después de 3 segundos
        }, 3000);
    });
</script>
        
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
        function cambiarGenero() {
            let switchInput = document.getElementById("generoSwitch");
            let textoGenero = document.getElementById("generoTexto");
    
            if (switchInput.checked) {
                textoGenero.innerText = "Femenino";
            } else {
                textoGenero.innerText = "Masculino";
            }
        }
    </script>

    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>
    