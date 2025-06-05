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
        <button type="button" class="btn btn-success">
            <p><b>22</b> Empleados</p> 
            <p></p> 
            <p><kbd>Más información</kbd></p>
        </button>
        <button type="button" class="btn btn-info">
            <p><b>6</b> Cuadrillas</p> 
            <p><kbd>Más información</kbd></p>
        </button>
        <button type="button" class="btn btn-secondary">
            <p><b>80%</b> de asistencia</p> 
            <p><kbd>Más información</kbd></p>
        </button>
        <button type="button" class="btn btn-primary">
         <p><b>50%</b> de Cumplimiento</p> 
            <p><kbd>Más información</kbd></p>
        </button>
    </div>
    <div class="container mt-3">
        <form class="d-flex">
            <input class="form-control me-2" type="text" id="myInput" placeholder="Buscar trabajador">
            <button class="btn btn-warning" type="button">Buscar</button>
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
                        <th class='auto-width' style="text-align: center">Foto</th>
                        <th class='auto-width' style="text-align: center">Seleccionar</th>
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
                                        <td class='auto-width' style='text-align: center'><img src='imagenes/trabajadores/$foto' width='70' height='70' onclick='ampliarImagen(this)'/></td>
                                        <td style='text-align: center'><i class='bi bi-check2-square'></i></td>
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
   <script> 
    function dragStart(event) {
  event.dataTransfer.setData("Text", event.target.id);
}
function dentro(event, id){
  event.preventDefault();
  event.dataTransfer.setData("sobre", id);
}
function soltar(event){
  event.preventDefault();
  var data = event.dataTransfer.getData("Text");
  var id = event.dataTransfer.getData("sobre");
  var nodoDrop = document.getElementById(data);
  //var antesDe = document.getElementById(id);

  document.getElementById("container").appendChild(nodoDrop);
  alert(id); //el id sobre el cual se solto o se poso por ultima vez
  //document.getElementById("container").insertBefore(nodoDrop,antesDe);
}
</script>
    
    <div style="border:1px solid black;" >
  <p id="p1" draggable="true" ondragstart="dragStart(event)" ondragover="dentro(event,this.id)">parrafo1</p>
  <p id="p2" draggable="true" ondragstart="dragStart(event)" ondragover="dentro(event,this.id)">parrafo2</p>
  <p id="p3" draggable="true" ondragstart="dragStart(event)" ondragover="dentro(event,this.id)">parrafo3</p>
  <button id="btn1" draggable="true" ondragstart="dragStart(event)" ondragover="dentro(event,this.id)">btn1</button>
</div>
<br>
<div id="container" style="border:1px solid blue;" ondrop="soltar(event)" ondragover="dentro(event,this.id)"><p> texto fijo </p>
   
</div>
    
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>

