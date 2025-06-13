<!DOCTYPE html>
<html lang="en">
<head>
  <title>SmartAgro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    #log {
      margin-top: 20px;
      max-height: 200px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
      background-color: #f9f9f9;
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

    <div class="container">
        <h3>Pesaje automatizado</h3>
        <button id="connect">Conectar al dispositivo</button>
        <button id="disconnect" disabled>Desconectar</button>
        <div id="log"></div>
        <form id="miFormulario"> 
            <input type="hidden" name="caja_valor" id="caja_valor" >
            <div class="d-grid">
                <input type="submit" id="boton" class="btn btn-primary btn-block" value="Guardar peso">
             </div>
        </form>
        <p id="respuesta"></p>
        
        <script>
            document.getElementById("miFormulario").addEventListener("submit", function(event) {
                event.preventDefault(); // Evita la recarga de la página
    
                const formData = new FormData(this);
    
                fetch("scripts_php/guardar_peso.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("respuesta").innerText = data; // Muestra la respuesta
                })
                .catch(error => console.error("Error:", error));
            });
        </script>
        
        <script>
            const boton = document.getElementById("boton");
            const clases = ["btn-primary", "btn-success", "btn-danger", "btn-warning", "btn-info"];
            let index = 0;
    
            boton.addEventListener("click", function() {
                boton.classList.remove(clases[index]); // Elimina la clase actual
                index = (index + 1) % clases.length; // Cambia el índice cíclicamente
                boton.classList.add(clases[index]); // Agrega la nueva clase
            });
        </script>
        
        <script>
            let port = null; // Variable para el puerto serial
            let reader = null; // Reader para leer datos
            let deviceData = ''; // Almacena datos recibidos
        
            // Actualiza el log en la página
            function logMessage(message) {
              const log = document.getElementById('log');
              log.innerHTML += `<p>${message}</p>`;
              log.scrollTop = log.scrollHeight;
            }
        
            // Conectar al dispositivo
            document.getElementById('connect').addEventListener('click', async () => {
              try {
                port = await navigator.serial.requestPort();
                await port.open({ baudRate: 9600 });
        
                logMessage('Conexión establecida');
                document.getElementById('disconnect').disabled = false;
                
                // Inicia la lectura de datos
                reader = port.readable.getReader();
                readSerialData();
              } catch (error) {
                logMessage("Error al conectar: ${error.message}");
              }
            });
        
            // Leer datos del puerto serial
            async function readSerialData() {
                while (port && reader) {
                    try {
                        const { value, done } = await reader.read();
                        if (done) break; // Finaliza si no hay más datos
                        const data = new TextDecoder().decode(value);
                        deviceData += data; // Almacena los datos
                        logMessage(`Peso recibido: ${data}`);
                        document.getElementById("caja_valor").value = data;
                        var miVariable = data;
                    } catch (error) {
                      logMessage("Error al leer peso: ${error.message}");
                      break;
                    }
                }
            }
        
            // Desconectar del dispositivo
            document.getElementById('disconnect').addEventListener('click', async () => {
              try {
                if (reader) {
                  await reader.cancel();
                  reader.releaseLock();
                }
                if (port) {
                  await port.close();
                }
                port = null;
        
                logMessage('Conexión cerrada');
                document.getElementById('disconnect').disabled = true;
              } catch (error) {
                logMessage("Error al desconectar: ${error.message}");
              }
            });
        </script>
    </div>
    
    <div class="mt-5 p-3 bg-success text-white text-center">
        <p>Copyright @SmartAgro 2025</p>
    </div>
    
</body>
</html>

