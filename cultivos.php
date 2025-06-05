
<h4>Cultivos</h4>
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bi bi-plus-circle"></i></button>

<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Cultivo</th>
                <th>Editar</i></th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("scripts_php/conexion.php");
                $conn=conectar();
                $sql = "SELECT * FROM cultivo";
                $result = $conn->query($sql);
                $registro=1;
                if ($result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $id = $row["id_cultivo"];
                        $cultivo = $row["cultivo"];
                        print("
                            <tr>
                                <td>$registro</td>
                                <td>$cultivo</td>
                                <td><a href='scripts_php/actualiza_cultivo.php?id=$id&cultivo=$cultivo'><i class='bi bi-pen-fill'></i></a></td>
                                <td><a href='scripts_php/elimina_cultivo.php?id=$id&cultivo=$cultivo'><i style='color: red;' class='bi bi-trash3-fill'></td></i>
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
                Cultivos
                <form action="scripts_php/guardar_cultivo.php" method="post" enctype="multipart/form-data" data-aos="fade-up" data-aos-delay="500">
                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" placeholder="Nombre del cultivo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" name="cultivo" required>
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