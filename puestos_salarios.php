
<h4>Puestos y salarios</h4>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bi bi-person-plus-fill"></i></button>

<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Puesto</th>
                <th>Pago</th>
                <th>Fecha de actualización</th>
                <th>Editar</i></th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("scripts_php/conexion.php");
                $conn=conectar();
                $sql = "SELECT * FROM puesto_salario";
                $result = $conn->query($sql);
                $registro=1;
                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $id = $row["id_puesto_salario"];
                        $puesto = $row["puesto"];
                        $salario = $row["salario"];
                        $fecha = $row["fecha_registro"];
                        $monto_formateado = "$" . number_format($salario, 2, '.', ',');
                        print("
                            <tr>
                                <td>$registro</td>
                                <td>$puesto</td>
                                <td>$monto_formateado</td>
                                <td>$fecha</td>
                                <td><a href='scripts_php/actualiza_puesto_salario.php?id=$id&puesto=$puesto&salario=$salario&fecha=$fecha'><i class='bi bi-pen-fill'></i></a></td>
                                <td><a href='scripts_php/elimina_puesto_salario.php?id=$id&puesto=$puesto&salario=$salario&fecha=$fecha'><i style='color: red;' class='bi bi-trash3-fill'></td></i>
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

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body">
                Puesto y salario
                <form action="scripts_php/guardar_puesto_salario.php" method="post" enctype="multipart/form-data" data-aos="fade-up" data-aos-delay="500">
                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" placeholder="Nombre del puesto" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="puesto" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control" placeholder="Salario X semana" name="salario" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" >Guardar</button>
                    </div>
                </form> 
            </div>
    
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>