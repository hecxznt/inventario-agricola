<!DOCTYPE html>
<html lang="en">
<head>
    <title>SmartAgro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
            #contenido { margin: 20px; padding: 20px; border: 1px solid #ddd; }
            button { margin: 5px; padding: 10px; cursor: pointer; }
    </style>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <h2>Catálogos</h2>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link"><button onclick="cargarContenido('puestos_salarios.php')">Puestos y salario</button></a>
            </li>
            <li class="nav-item">
                <a class="nav-link"><button onclick="cargarContenido('cultivos.php')">Cultivos</button></a>
            </li>
        </ul>
        <div id="contenido">Selecciona una opción para cargar contenido.</div>
        <script>
            function cargarContenido(url) {
                fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('contenido').innerHTML = data;
                    })
                    .catch(error => console.error('Error cargando el contenido:', error));
            }
        </script>
    </div>
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>
