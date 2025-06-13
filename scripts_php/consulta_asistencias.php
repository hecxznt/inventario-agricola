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
                          <li><a class="dropdown-item" href="../rh_cuadrillas.php">Cuadrillas</a></li>
                          <li><a class="dropdown-item" href="../rh_nomina.php">Nómina</a></li>
                          <li><a class="dropdown-item" href="../rh_alta_trabajadores.php">Trabajadores</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cultivos</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="../riego.php">Riego</a></li>
                          <li><a class="dropdown-item" href="../historico_cultivos.php">Histórico</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Ganado</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="../pesaje.php">Pesaje</a></li>
                          <li><a class="dropdown-item" href="../historico_ganado.php">Histórico</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../catalogos.php">Catálogos</a>
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
    
    <div class="container">
        <h4 class="text-center">RECURSOS HUMANOS</h4>
        <p class="text-center">Nomina - Pase de lista</p>
        <div class="alert alert-info">
            <strong>Personal </strong> Consulta listas de asistencias</button></a>
            <div class="container mt-3">
            <form class="d-flex">
                <input class="form-control me-2" type="text" id="myInput" placeholder="Buscar trabajador">
                <button class="btn btn-warning btn-sm" type="button">Buscar</button>
            </form>
        </div>
        </div>
        <div class="container mt-3">
            <?php 
                print("
                    <form action='consulta_asistencias.php' method='GET' id='miFormulario'>
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
                    locale: "es",  // Establecer idioma español
                    dateFormat: "Y/m/d", // Formato de fecha
                    altInput: true,
                    altFormat: "Y/m/d", // Formato visible (ejemplo: 27 de febrero, 2025)
                    minDate: "01/01/2025", // Evita seleccionar fechas pasadas
                    disableMobile: true // Evita el datepicker nativo en móviles
                   
                });
            </script>
            <script>
                document.getElementById("miFormulario").addEventListener("submit", function(event) {
                    let fechaInput = document.getElementById("fecha").value;
                    if (!fechaInput) {
                        alert("Por favor, seleccione una fecha.");
                        event.preventDefault(); // Evita que el formulario se envíe
                    }
                });
            </script>
        </div>
        
        <div class="table-responsive-sm">
            <?php
                include("conexion.php");
                $conn=conectar();
                date_default_timezone_set('America/Monterrey');
                $fecha = $_GET['fecha'];
                $newDate = date("d/m/Y", strtotime($fecha));
                $week=date('W', strtotime($fecha));
                
                $lunes = date("d/m/Y", strtotime('monday this week', strtotime($fecha)));
                $martes = date("d/m/Y", strtotime('Tuesday this week', strtotime($fecha)));
                $miercoles = date("d/m/Y", strtotime('Wednesday this week', strtotime($fecha)));
                $jueves = date("d/m/Y", strtotime('Thursday this week', strtotime($fecha)));
                $viernes = date("d/m/Y", strtotime('Friday this week', strtotime($fecha)));
                $sabado = date("d/m/Y", strtotime('Saturday this week', strtotime($fecha)));
                $domingo = date("d/m/Y", strtotime('sunday this week', strtotime($fecha)));
                
                $inicio = date("Y-m-d", strtotime('monday this week', strtotime($fecha)));
                $fin = date("Y-m-d", strtotime('sunday this week', strtotime($fecha)));
                $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                print("<p class='text-end fw-bold'>Semana #$week: del $lunes al $domingo</p>");
            ?>
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th style="text-align: center">Trabajadores</th>
                        <th style="text-align: center" colspan="7">Fecha - </th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php
                        $sql = "SELECT * FROM trabajador";
                        $result = $conn->query($sql);
                        $registro=1;
                        if ($result->num_rows > 0) {
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $id = $row["id_trabajador"];
                                $nombre = $row["nombre"];
                                $apellido_paterno = $row["apellido_paterno"];
                                $apellido_materno = $row["apellido_materno"];
                                $nombre_completo=$nombre. ' '.$apellido_paterno. ' '.$apellido_materno;
                                print("
                                    <tr>
                                        <td class='auto-width' style='text-align: right'>$registro</td>
                                        <td class='auto-width'>$nombre_completo</td>
                                    ");
                                $sql_asistencia = "SELECT * FROM pase_lista WHERE id_trabajador = '$id' AND fecha_lista BETWEEN '$inicio' AND '$fin'";
                                $resultado = $conn->query($sql_asistencia);
                                $cont=0;
                                while($record = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
                                    $status = $record["status"];
                                    $fecha_lista = $record["fecha_lista"];
                                    $dia = date("d/m/Y", strtotime($fecha_lista)); 
                                    $day[$cont] = $dia;
                                    
                                    if(strcmp($day[$cont], $lunes) == 0){
                                        print("<td class='auto-width' style='text-align: center'> Lunes - $status</td>");
                                    }
                                    if(strcmp($day[$cont], $martes) == 0){
                                        print("<td class='auto-width' style='text-align: center'>Martes - $status</td>");
                                    }
                                    if(strcmp($day[$cont], $miercoles) == 0){
                                        print("<td class='auto-width' style='text-align: center'>Miércoles - $status</td>");
                                    }
                                    if(strcmp($day[$cont], $jueves) == 0){
                                        print("<td class='auto-width' style='text-align: center'>Jueves - $status</td>");
                                    }
                                    if(strcmp($day[$cont], $viernes) == 0){
                                        print("<td class='auto-width' style='text-align: center'>Viernes - $status</td>");
                                    }
                                    if(strcmp($day[$cont], $sabado) == 0){
                                        print("<td class='auto-width' style='text-align: center'>Sábado - $status</td>");
                                    }
                                    if(strcmp($day[$cont], $domingo) == 0){
                                        print("<td class='auto-width' style='text-align: center'>Domingo - $status</td>");
                                    }
                                    
                                    $cont++;
                                }    
                            
                                print("
                                        </tr>
                                    ");
                                    
                                $resultado->free();
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
   
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>