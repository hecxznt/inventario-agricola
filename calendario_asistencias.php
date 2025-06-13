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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    
    <div class="container">
        <h4 class="text-center">RECURSOS HUMANOS</h4>
        <p class="text-center">Nomina - Actualizar E/S</p>
        <div class="alert alert-info">
            <strong>Personal </strong> Pase de lista
            <?php
                $id = $_GET['id'];
                $nombre = $_GET['nombre'];
                $date = $_GET['fecha'];
                print(" <br><strong> Empleado: </strong>$id  
                        <br><strong>Nombre: </strong>$nombre");        
            ?>
        </div>
      
        <div class="container mt-3">
            <?php 
                print("
                    <form action='calendario_asistencias.php' method='GET' id='miFormulario'>
                        <input type='hidden' name='nombre' value='$nombre'>
                        <input type='hidden' name='id' value='$id'>
                        
                        <div class='input-group input-group-sm mb-3'>
                            <input type='date' required  class='form-control' name='fecha' id='fecha' placeholder='Buscar una fecha' >
                            <input type='submit' class='btn btn-primary btn-sm' value='Buscar'>
                        </div>
                    </form>
                ");
            ?>
            <!-- Flatpickr JS -->
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
            <script>
                flatpickr("#fecha", {
                    locale: "es",  // Establecer idioma espa�0�9ol
                    dateFormat: "Y-m-d", // Formato de fecha
                    altInput: true,
                    altFormat: "F j, Y", // Formato visible (ejemplo: 27 de febrero, 2025)
                    minDate: "01/01/2025", // Evita seleccionar fechas pasadas
                    disableMobile: true // Evita el datepicker nativo en m��viles
                   
                });
            </script>
            <script>
                document.getElementById("miFormulario").addEventListener("submit", function(event) {
                    let fechaInput = document.getElementById("fecha").value;
                    if (!fechaInput) {
                        alert("Por favor, seleccione una fecha.");
                        event.preventDefault(); // Evita que el formulario se env��e
                    }
                });
            </script>
            
            <?php
                include("scripts_php/conexion.php");
                $conn=conectar();
                $sql = "SELECT * FROM pase_lista WHERE id_trabajador=$id";
                $result = $conn->query($sql);
               
                $ver_fecha=date("d/m/Y", strtotime($date));
                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $fecha_lista = $row["fecha_lista"];
                        $hora_entrada = $row["hora_entrada"];
                        $hora_salida = $row["hora_salida"];
                        if($hora_salida==""){
                            $hora_salida='S/R';
                        }
                        if($date==$fecha_lista){
                            print("
                                <div class='input-group mb-3'>
                                    <span class='input-group-text'>Fecha</span>
                                    <input type='text' class='form-control form-control-sm' placeholder='$ver_fecha' disabled />
                                </div>
                                <form action='scripts_php/script_actualizar_entrada.php' method='POST'>
                                    <input type='hidden' name='id' value='$id'>
                                    <input type='hidden' name='nombre' value='$nombre'>
                                    <input type='hidden' name='date' value='$date'>
                                    <input type='hidden' name='entrada' value='$hora_entrada'>
                                    <div class='input-group mb-3'>
                                        <span class='input-group-text'>Hora de entrada</span>
                                        <input type='text' class='form-control form-control-sm' placeholder='$hora_entrada' disabled />
                                        <input type='time' class='form-control form-control-sm' name='entrada_nueva' required/>
                                        <button type='submit' class='btn btn-warning btn-sm'>Actualizar entrada</button>
                                    </div>
                                </form>
                           
                           <form action='scripts_php/script_actualizar_salida.php' method='POST'>
                                    <input type='hidden' name='id' value='$id'>
                                    <input type='hidden' name='nombre' value='$nombre'>
                                    <input type='hidden' name='date' value='$date'>
                                    <input type='hidden' name='salida' value='$hora_salida'>
                                    <div class='input-group mb-3'>
                                        <span class='input-group-text'>Hora de salida &nbsp;&nbsp;</span>
                                        <input type='text' class='form-control form-control-sm' placeholder='$hora_salida' disabled />
                                        <input type='time' class='form-control form-control-sm' name='salida_nueva' required/>
                                        <button type='submit' class='btn btn-warning btn-sm'>Actualizar &nbsp; salida</button>
                                    </div>
                                </form>
                           
                           
                            ");
                        }        
                    }
                $result->free();
                }
                else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                mysqli_close($conn);
            ?>
            </br>
            <div class="d-grid" style="display: flex; justify-content: flex-end;">
                <a href="rh_nomina.php"><button type="button" class="btn btn-primary btn-block"><i class="bi bi-arrow-left-square-fill"></i> Regresar </button></a>
            </div>
        </div>    
    </div>

    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>