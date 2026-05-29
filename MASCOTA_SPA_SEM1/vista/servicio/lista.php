<?php

$servicios = $dataToView['data']['servicios'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        ✂️ Servicios Grooming
    </h2>

    <a href="index.php?controller=servicio&action=crear"
       class="btn btn-primary">

        ➕ Nuevo Servicio

    </a>

</div>

<div class="card shadow border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Servicio</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($servicios as $s): ?>

                        <tr>

                            <td>
                                <?php echo $s['id']; ?>
                            </td>

                            <td>

                                <strong>
                                    <?php echo htmlspecialchars($s['nombre']); ?>
                                </strong>

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    <?php echo $s['duracion_minutos']; ?> min

                                </span>

                            </td>

                            <td>

                                <span class="badge bg-success">

                                    Bs. <?php echo $s['precio_base']; ?>

                                </span>

                            </td>

                            <td>

                                <?php if($s['activo']): ?>

                                    <span class="badge bg-success">
                                        Activo
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">
                                        Inactivo
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a href="index.php?controller=servicio&action=editar&id=<?php echo $s['id']; ?>"
                                   class="btn btn-warning btn-sm">

                                    ✏️

                                </a>

                                <a href="index.php?controller=servicio&action=eliminar&id=<?php echo $s['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Eliminar servicio?')">

                                    🗑

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>