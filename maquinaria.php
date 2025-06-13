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
  <p>PLATAFORMA DIGITAL PARA LA GESTIÓN DE LA PRODUCCIÓN AGRÍCOLA</p> 
</div>
  
<div class="container">
  <h4 class="text-center">MAQUINARIA</h4>
  <p class="text-center">Equipos</p>
  <div class="container mt-3">
  <h2>Alta</h2>
  <form action="/action_page.php">
    <div class="mb-3 mt-3">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control mt-3" placeholder="Nombre del equipo:" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required>
    </div>
  
    <div>    
        <label for="browser" class="form-label">Elige el tipo de maquinaria:</label>
        <input class="form-control" list="browsers" name="browser" id="browser">
        <datalist id="browsers">
            <option value="Tractor">
            <option value="Cosechadora">
            <option value="Remolque">
            <option value="Fumigadora">
            <option value="Sembradora">
            <option value="Rastra de discos">
        </datalist>    
    </div>
    <br>
    
    <div class="row">
        <label for="uso">Datos:</label>
        <div class="col">
            <input type="text" class="form-control mt-3" placeholder="Marca del equipo:" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="marca" required>   
        </div>
        <div class="col">
            <input type="text" class="form-control mt-3" placeholder="Modelo del equipo:" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0123456789\s]+" name="modelo" required>
        </div>
    </div>
  
    <div class="mb-3 mt-3">
        <label for="serie">Serie:</label>
        <input type="text" class="form-control mt-3" placeholder="Número de serie del equipo:" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0123456789\s]+" name="serie" required>
    </div>
    
    <div class="row">
        <label for="uso">Datos de uso:</label>
        <div class="col">
            <input type="number" class="form-control" placeholder="Captura las horas de uso (hormetro)" name="horometro">
        </div>
        <div class="col">
            <input type="tacometro" class="form-control" id="tel" placeholder="Captura los kilometros de uso (tácometro)" name="tacometro">
        </div>
    </div>
    
     <div class="row">
        <label for="uso">Datos:</label>
        <div class="col">
            <input type="numbre" class="form-control mt-3" placeholder="Precio de compra del equipo:" name="precio" required>
        </div>
        <div class="col">
           <input type="numbre" class="form-control mt-3" placeholder="Tasa de depreciación:" required>
        </div>
    </div>
    <br>
    
    <label for="uso">Tipo de adquisición:</label>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="radio1" name="optradio" value="contado" checked>
      <label class="form-check-label" for="radio1">Contado</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="radio2" name="optradio" value="credito">
      <label class="form-check-label" for="radio2">Crédito</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="radio3" name="optradio" value="renta">
      <label class="form-check-label" for="radio2">Renta</label>
    </div>
    
    <div class="mb-3 mt-3">
        <label for="Fecha_servicio">Fecha de servicio: </label>
        <input type="date" id="servicio" name="fecha_servicio">
    </div>
    
    <div class="mb-3 mt-3">
        <label for="Fecha_ingreso">Fecha de registro: </label>
        <input type="date" id="birthday" name="fecha_registro">
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <button type="reset" class="btn btn-danger">Cancelar</button>
  </form>
</div> 
</div>

<div class="mt-5 p-3 bg-dark text-white text-center">
  <p>Copyright @RanchoVictoria 2024</p>
</div>

</body>
</html>