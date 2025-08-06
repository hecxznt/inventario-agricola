<!-- Sidebar -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="../productos/index.php">
                    <i class="bi bi-box-seam"></i>
                    Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../movimientos/index.php">
                    <i class="bi bi-arrow-left-right"></i>
                    Movimientos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center position-relative" href="../alertas/index.php">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span class="ms-2">Alertas</span>
                    <div id="indicadorAlertas" style="position: absolute; right: 10px; display: none;"></div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between" href="#" data-bs-toggle="collapse" data-bs-target="#submenuTrabajador" aria-expanded="false" aria-controls="submenuTrabajador">
                    <span>
                    <i class="bi bi-person-badge"></i>
                    Trabajador
                    </span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="submenuTrabajador">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="../trabajador/index.php">
                                <i class="bi bi-people"></i>
                                Gestión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../trabajador/nomina.php">
                                <i class="bi bi-cash-coin"></i>
                                Nómina
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav> 