<?php

$mascotas = $dataToView['data']['mascotas'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        🐶 Mascotas
    </h2>

    <a href="index.php?controller=mascota&action=crear"
       class="btn btn-primary">

        ➕ Nueva Mascota

    </a>

</div>

<div class="card shadow border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dueño</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Vacunas</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($mascotas as $m): ?>

                        <tr>

                            <td>
                                <?php echo $m['id']; ?>
                            </td>

                            <td>

                                <strong>
                                    <?php echo htmlspecialchars($m['nombre']); ?>
                                </strong>

                            </td>

                            <td>
                                <?php echo htmlspecialchars($m['cliente']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($m['especie']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($m['raza']); ?>
                            </td>

                            <td>

                                <?php if($m['vacunas']): ?>

                                    <span class="badge bg-success">
                                        Sí
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">
                                        No
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a href="index.php?controller=mascota&action=editar&id=<?php echo $m['id']; ?>"
                                   class="btn btn-warning btn-sm">

                                    ✏️

                                </a>

                                <a href="index.php?controller=mascota&action=eliminar&id=<?php echo $m['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Eliminar mascota?')">

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