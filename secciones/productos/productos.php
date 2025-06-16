                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary" onclick="editarProducto(<?php echo $row['id_producto']; ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if ($row['activo'] == 1): ?>
                                <button type="button" class="btn btn-sm btn-success" onclick="cambiarEstado(<?php echo $row['id_producto']; ?>, 0)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-sm btn-danger" onclick="cambiarEstado(<?php echo $row['id_producto']; ?>, 1)">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td> 