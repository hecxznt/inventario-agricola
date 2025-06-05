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
  <h4 class="text-center">PRODUCCIÓN</h4>
  <p class="text-center">Etapa de levantamiento</p>
  
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="produccion.php">Lotes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="produccion_E1.php">Preparación</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="produccion_E2.php">Desarrollo</a>
    </li>
     <li class="nav-item">
      <a class="nav-link active" href="produccion_E3.php">Cosecha</a>
    </li>
  </ul>
  <br>
  
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Ver inversión acumulada
    </button>
 
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Monto</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
    
          <!-- Modal body -->
          <div class="modal-body">
            $30,000.00
          </div>
    
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          </div>
    
        </div>
      </div>
    </div>
    
  <form action="/action_page.php">
    <div class="mb-3 mt-3">
            <label for="nombre">Lote:</label>
            <input type="text" class="form-control mt-3" placeholder="Nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ1234567890\s]+" name="lote" disabled required>
        </div>  
    <div class="mb-3 mt-3">
        <label for="mano_obra">Mano de obra:</label>
        <input type="number" class="form-control mt-3" placeholder="Costo de la mano de obra" name="mano_obra">
    </div>
    
   <div class="input-group mb-3">
        <span class="input-group-text">Servicios</span>
        <input type="number" class="form-control" placeholder="Aflojada" name="aflojada">
        <input type="number" class="form-control" placeholder="Acarreo" name="acarreo">
    </div>
    
    <div class="input-group mb-3">
        <span class="input-group-text">Combustible</span>
        <input type="number" class="form-control" placeholder="Gasolina" name="gasolina">
        <input type="number" class="form-control" placeholder="Disesel" name="diesel">
    </div>

    <div class="mb-3 mt-3">
        <label for="Fecha_ingreso">Fecha de registro: </label>
        <input type="date" id="birthday" name="fecha_ingreso">
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <button type="reset" class="btn btn-danger">Cancelar</button>
  </form>
</div>

<div class="mt-5 p-3 bg-dark text-white text-center">
  <p>Copyright @RanchoVictoria 2024</p>
</div>

</body>
</html>