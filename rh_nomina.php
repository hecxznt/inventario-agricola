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
        <p class="text-center">Nomina - Pase de lista</p>
        <div class="alert alert-info">
            <?php
                date_default_timezone_set('America/Monterrey');
                $fecha=date("Y-m-d");
                print(" 
                    <a href='scripts_php/consulta_asistencias.php?fecha=$fecha'>
                        <button type='button' class='btn btn-sm'><strong>Personal </strong> Consulta listas de asistencias</button>
                    </a>
                ");
            ?>
        </div>
        <div class="alert alert-success">
            <strong>IMSS </strong> Altas - Bajas
        </div>
        <div class="alert alert-warning">
            <strong>Cálculos </strong> Primas
        </div>
        <div class="alert alert-danger">
            <strong>Historial </strong> Antigüedad
        </div>
        <div class="container mt-3">
            <form class="d-flex">
                <input class="form-control me-2" type="text" id="myInput" placeholder="Buscar trabajador">
                <button class="btn btn-warning btn-sm" type="button">Buscar</button>
            </form>
        </div>
        <div class="table-responsive-sm">
            <?php
                include("scripts_php/conexion.php");
                $conn=conectar();
                date_default_timezone_set('America/Mexico_City');
                $fecha_hora_registro = date("Y-m-d - g:i a");
                $ver_fecha_hora= strftime("%A %d of %B %Y - %r");
                print("<p class='text-end fw-bold'>$ver_fecha_hora</p>");
            ?>
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th style="text-align: center">Nombre</th>
                        <th style="text-align: center">Entrada</th>
                        <th style="text-align: center">Salida</th>
                        <th style="text-align: center">Modificar</th>
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
                                
                                $sql_lista = "SELECT * FROM pase_lista WHERE id_trabajador=$id";
                                $resultados = $conn->query($sql_lista);
                                $flag='F';
                                while($record = mysqli_fetch_array($resultados, MYSQLI_ASSOC)){
                                    $pase_lista = $record['fecha_lista'];
                                    $estado = $record['status'];
                                    $salida = $record['salida'];
                                    if($fecha===$pase_lista){
                                        $flag='V';
                                    }
                                }
                                print("
                                    <tr>
                                        <td class='auto-width' style='text-align: right'>$registro</td>
                                        <td class='auto-width'>$nombre_completo</td>
                                        <td style='text-align: center'>
                                            <form action='scripts_php/pase_lista_entrada.php' method='POST'>
                                                <div class='input-group container-sm'>
                                ");
                                                if($flag=='V'){
                                                    print("
                                                        <select class='form-select' class='form-control form-control-sm' id='sel1' name='status' disabled>
                                                            <option>($estado)</option>
                                                        </select>
                                                        <button type='submit' class='btn btn-primary' class='form-control form-control-sm' disabled><i class='bi bi-box-arrow-in-right'></i></button>
                                                    
                                                    ");
                                                }
                                                else{
                                                    print("
                                                        <select class='form-select' class='form-control form-control-sm' id='sel1' name='status'>
                                                            <option value='A'>(A)sistencia</option>
                                                            <option value='R'>(R)etardo</option>
                                                            <option value='F'>(F)alta</option>
                                                            <option value='J'>(J)ustificante</option>
                                                        </select>
                                                        <input type='hidden' name='id' value='$id'>
                                                        <input type='hidden' name='fecha_lista' value='$fecha_hora_registro'>
                                                        <button type='submit' class='btn btn-primary' class='form-control form-control-sm'><i class='bi bi-box-arrow-in-right'></i></button>
                                                    ");
                                                }
                                print("    
                                                </div>
                                            </form>
                                        </td>
                                ");
                                    if($salida=='V'){
                                        print("<td style='text-align: center' class='auto-width'><button type='button' class='btn btn-primary' class='form-control form-control-sm' disabled><i class='bi bi-box-arrow-left'></i></button></td>");
                                    }   
                                    else{
                                        print("<td style='text-align: center' class='auto-width'><a href='scripts_php/pase_lista_salida.php?id=$id'><button type='button' class='btn btn-primary' class='form-control form-control-sm'><i class='bi bi-box-arrow-left'></i></button></a></td>");
                                    } 
                                print("
                                        <td style='text-align: center' class='auto-width'><a href='calendario_asistencias.php?id=$id&nombre=$nombre_completo&fecha=$fecha'><button type='button' class='btn btn-primary' class='form-control form-control-sm'><i class='bi bi-calendar-check-fill'></i></button></td>
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