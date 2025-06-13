<!DOCTYPE html>
<html lang="en">
<head>
  <title>RV</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Logo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mynavbar">
        <ul class="navbar-nav me-auto">
        
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="rh_calendario.php">RH</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="rh_calendario.php">Calendario</a></li>
                    <li><a class="dropdown-item" href="rh_cuadrillas.php">Cuadrillas</a></li>
                    <li><a class="dropdown-item" href="rh_alta_trabajadores.php">Trabajadores</a></li>
                    <li><a class="dropdown-item" href="rh_nomina.php">Nomina</a></li>
                </ul>
            </li>
            
            <li class="nav-item dropdown"> 
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="produccion.php">Producción</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="produccion.php">Lotes</a></li>
                    <li><a class="dropdown-item" href="poscosecha.php">Poscoseha</a></li>
                    <li><a class="dropdown-item" href="maquinaria.php">Maquinaria</a></li>
                    <li><a class="dropdown-item" href="maquinaria.php">Implementos</a></li>
                    <li><a class="dropdown-item" href="pozos.php">Pozos</a></li>
                </ul>
             </li>
             
            <li class="nav-item dropdown"> 
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="produccion.php">Inventario</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="agroquimicos.php">Agroquímicos</a></li>
                    <li><a class="dropdown-item" href="fertilizantes.php">Fertilizantes</a></li>
                </ul>
             </li>
        
            <li class="nav-item dropdown"> 
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="produccion.php">Trazabilidad</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="empaquetado.php">Empaquetado</a></li>
                    <li><a class="dropdown-item" href="certificación.php">Certificación</a></li>
                </ul>
             </li>
             <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Inventario</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="inventario-agricola/secciones/productos/">Dashboard</a></li>
                          <li><a class="dropdown-item" href="inventario-agricola/secciones/movimientos/">Movimientos</a></li>
                        </ul>
                    </li>
            <li class="nav-item dropdown"> 
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="produccion.php">Analítico</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="rentabilidad.php">Rentabilidad</a></li>
                    <li><a class="dropdown-item" href="unidades_produccion.php">Unidades de producción</a></li>
                    <li><a class="dropdown-item" href="datos_historicos.php">Históricos</a></li>
                </ul>
             </li>
        </ul>
        
        <form class="d-flex">
          <input class="form-control me-2" type="text" placeholder="Buscar">
          <button class="btn btn-primary" type="button">Buscar</button>
        </form>
      </div>
    </div>
  </nav>

<div class="container-fluid p-5 bg-warning text-white text-center">
  <h1>RANCHO VICTORIA</h1>
  <p>PLATAFORMA DIGITAL PARA LA GESTIÓN DE LA PRODUCCIÓN AGRÍCOLA Y GANADERA</p> 
</div>

<div class="container">
  <h4 class="text-center">PRODUCCIÓN</h4>
  <p class="text-center">Etapa de crecimiento y monitoreo del desarrollo</p>
  
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="produccion.php">Lotes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="produccion_E1.php">Preparación</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="produccion_E2.php">Desarrollo</a>
    </li>
     <li class="nav-item">
      <a class="nav-link" href="produccion_E3.php">Cosecha</a>
    </li>
  </ul>
  <br>
  <a href="riego.php"><button type="button" class="btn btn-primary">Riego</button></a>

  <form action="/action_page.php">
    <div class="mb-3 mt-3">
            <label for="nombre">Lote:</label>
            <input type="text" class="form-control mt-3" placeholder="Nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ1234567890\s]+" name="lote" disabled required>
        </div>  
        <p>Fecha y hora: 
        <?php
            date_default_timezone_set('America/Monterrey');
            $fecha_y_hora = date("d-m-Y H:i");
            echo $fecha_y_hora;
        ?>
        </p>
        <div>
            <p>Estado de la válvula:</p>
            <button type="button" class="btn btn-primary btn-lg">Abrierta<img src="imagenes/abrir.png" height ="50" width="50" /></button>
            <button type="button" class="btn btn-primary btn-lg">Cerrada<img src="imagenes/cerrar_llave.png" height ="50" width="50" /></button>
        </div>
        <div>
            <br>    
            <p>Acumulado:</p>
            <button type="button" class="btn btn-primary btn-lg">Tiempo<img src="imagenes/cronometro.png" height ="50" width="50" /> 2:30 hrs</button>
            <button type="button" class="btn btn-primary btn-lg"><img src="imagenes/tanque.png" height ="50" width="50" />M<sup>3</sup> 2,500 </button>
        </div>
            
  </form>
</div>

<div class="mt-5 p-3 bg-dark text-white text-center">
  <p>Copyright @RanchoVictoria 2024</p>
</div>

</body>
</html>
        
     
   