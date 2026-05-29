<?php

$clientes = $dataToView['data']['clientes'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        👨‍👩‍👧 Clientes
    </h2>

    <a href="index.php?controller=cliente&action=crear"
       class="btn btn-primary">

        ➕ Nuevo Cliente

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
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(empty($clientes)): ?>

                        <tr>

                            <td colspan="6">

                                <div class="alert alert-warning mb-0">

                                    No existen clientes registrados.

                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                    <?php foreach($clientes as $c): ?>

                        <tr>

                            <td>
                                <?php echo $c['id']; ?>
                            </td>

                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(trim($c['nombre_completo'] ?? '') ?: 'Sin nombre');
                                ?>

                                </strong>

                            </td>

                            <td>
                                <?php echo htmlspecialchars($c['telefono']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($c['correo']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($c['direccion']); ?>
                            </td>

                            <td>

                                <a href="index.php?controller=cliente&action=editar&id=<?php echo $c['id']; ?>"
                                   class="btn btn-warning btn-sm">

                                    ✏️ Editar

                                </a>

                                <a href="index.php?controller=cliente&action=eliminar&id=<?php echo $c['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Eliminar cliente?')">

                                    🗑 Eliminar

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>