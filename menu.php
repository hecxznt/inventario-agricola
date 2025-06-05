<!DOCTYPE html>
<html lang="en">
<head>
  <title>SmartAgro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
        .calendar-container {
            position: relative;
            padding-bottom: 70%; /* Ajusta la proporción según necesites */
            height: 0;
            overflow: hidden;
        }
        .calendar-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
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
                          <li><a class="dropdown-item" href="contador.php">Contador</a></li>
                          <li><a class="dropdown-item" href="historico_ganado.php">Histórico</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Inventario</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="../inventario-agricola/secciones/productos/">Dashboard</a></li>
                          <li><a class="dropdown-item" href="contador.php">Contador</a></li>
                          <li><a class="dropdown-item" href="historico_ganado.php">Histórico</a></li>
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
    
    <h2 align="center">Calendario de trabajo</h2>
    <div class="container p-5 my-5 border">
        <div class="calendar-container">
            <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=America%2FMexico_City&src=bHphcGF0YUB1dHphYy5lZHUubXg&src=Y19jbGFzc3Jvb21iOTJiZWYzN0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbWU1ZmQxMWE5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb21jNTgyZjI5YUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbWRiYjFkMzE2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb203NGVjNjIxMEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb20wNzVhMzMwYkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb200ZDFjNWRiNEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb21iNmU5ODBiOEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb204OTM3Nzk0ZkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb21hNmJhYWUxYUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbTY5MTliODcxQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb21hYWQzMzFkZUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbTJmY2RmNDg5QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbTY1OTRmMjY4QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb202OGZkZGZmNEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb21jNzA5Y2Q5NkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb21hYjBlZjE0NkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb203ZWU0MjQzOEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbTc0MTc3MDFhQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbWFkNjg3MDQ3QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb201NmJhNDBlM0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbTJkMThlYjRlQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb203NWE3ZDNhMUBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbTg4MzU5MTRkQGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=Y19jbGFzc3Jvb21kYmY5ODQzNkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb21hZTc2MDhmY0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=dXR6YWMuZWR1Lm14X2NsYXNzcm9vbWU4YjdlYjY1QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&src=dnY0YjVvNzFpczl0MmViMm5nb2M1aGNwOTBAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=djltZWU2ZWI2ZjZvZ2JkN25wbmlmOG80OTRAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=NmM3djJmNW1ibnFyN29lZ3M5Ymtrb3VxdXVhcmk0YThAaW1wb3J0LmNhbGVuZGFyLmdvb2dsZS5jb20&src=cW00ZTR1ZDFoczYxaWF0YWUxbzJ2cTk2aWtAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=ZW4ubWV4aWNhbiNob2xpZGF5QGdyb3VwLnYuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=Y19jbGFzc3Jvb21lNDhmOTg4OEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=Y19jbGFzc3Jvb21jYjA1ZDA2M0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%234285F4&color=%23AD1457&color=%23202124&color=%23c26401&color=%23202124&color=%23202124&color=%23A79B8E&color=%23202124&color=%23F4511E&color=%23795548&color=%23c26401&color=%237627bb&color=%239E69AF&color=%230047a8&color=%230047a8&color=%23616161&color=%23D50000&color=%233F51B5&color=%233F51B5&color=%23137333&color=%230047a8&color=%23616161&color=%237627bb&color=%23B39DDB&color=%230047a8&color=%23EF6C00&color=%230047a8&color=%230047a8&color=%23D50000&color=%23F4511E&color=%23F4511E&color=%23009688&color=%237CB342&color=%23202124&color=%23174ea6" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
        </div>  
    </div>
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>

<!--
            <li class="nav-item dropdown"> 
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="produccion.php">Producción</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="produccion.php">Lotes</a></li>
                <li><a class="dropdown-item" href="poscosecha.php">Poscoseha</a></li>
                <li><a class="dropdown-item" href="maquinaria.php">Maquinaria</a></li>
                <li><a class="dropdown-item" href="maquinaria.php">Implementos</a></li>
                <li><a class="dropdown-item" href="pozos.php">Pozos</a></li>
                <li><a class="dropdown-item" href="pesaje.php">Engorda</a></li>
            </ul>
         </li>
         
        <li class="nav-item dropdown"> 
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="inventario.php">Inventario</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="agroquimicos.php">Agroquímicos</a></li>
                <li><a class="dropdown-item" href="fertilizantes.php">Fertilizantes</a></li>
                <li><a class="dropdown-item" href="maquinaria.php">Maquinaria</a></li>
                <li><a class="dropdown-item" href="maquinaria.php">Implementos</a></li>
                <li><a class="dropdown-item" href="pozos.php">Pozos</a></li>
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
                <li><a class="dropdown-item" href="estados_financieros.php">Estados Financieros</a></li>
                <li><a class="dropdown-item" href="rentabilidad.php">Rentabilidad</a></li>
                <li><a class="dropdown-item" href="unidades_produccion.php">Unidades de producción</a></li>
                <li><a class="dropdown-item" href="datos_historicos.php">Históricos</a></li>
            </ul>
         </li>
    </ul>
-->