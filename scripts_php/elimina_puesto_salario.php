<!DOCTYPE html>
<html lang="en">
<head>
    <title>SmartAgro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .invisible {
            visibility: hidden;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-success" href="../menu.php">Inicio</a>
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
        <h4>Eminación de Puestos y Salarios</h4>
        <?php
            $id=$_GET['id'];
            $puesto=$_GET['puesto'];
            $salario=$_GET['salario'];
            $fecha=$_GET['fecha'];    

            print("
                <form action='script_eliminar_puesto_salario.php' method='post' data-aos='fade-up' data-aos-delay='500'>
                    <div class='mb-3 mt-3'>
                        <label class='form-label'>Puesto:</label>
                        <input type='text' class='form-control' pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+' name='puesto' value='$puesto'disabled>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label'>Salario:</label>
                        <input type='number' class='form-control' placeholder='' name='salario' value='$salario' disabled>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label'>Fecha registrada:</label>
                        <input type='text' class='form-control' value='$fecha' disabled>
                    </div>
                    <div class='mb-3'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' class='btn btn-danger' id='btnParpadeante' >Eliminar de forma permanente</button>
                        <a href='../catalogos.php'><button type='button' class='btn btn-primary' >Cancelar</button></a>
                    </div>
                </form>
            ");
         ?>   
    </div>
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>

    <script>
        // Obtener referencia al botón
        const boton = document.getElementById("btnParpadeante");

        // Alternar visibilidad cada 500 ms
        setInterval(() => {
            boton.classList.toggle("invisible");
        }, 500);
    </script>

</body>
</html>


