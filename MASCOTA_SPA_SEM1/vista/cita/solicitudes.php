<?php

$citas = $dataToView['data']['citas'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>🔔 Solicitudes de anulaciones</h2>
        <p class="text-muted mb-0">Aquí aparecen las citas con solicitud de anulación.</p>
    </div>

    <a href="index.php?controller=cita&action=listar"
       class="btn btn-secondary">

        ← Volver a Citas

    </a>

</div>

<div class="card shadow border-0">

    <div class="card-body">

        <?php if(empty($citas)): ?>
            <div class="alert alert-info">
                No hay solicitudes de anulación en este momento.
            </div>
        <?php else: ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mascota</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Groomer</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($citas as $c): ?>
                            <tr>
                                <td>🐶 <?php echo htmlspecialchars($c['mascota']); ?></td>
                                <td><?php echo $c['fecha']; ?></td>
                                <td><?php echo substr($c['hora_inicio'],0,5); ?> - <?php echo substr($c['hora_fin'],0,5); ?></td>
                                <td>👨‍🔧 <?php echo htmlspecialchars($c['groomer']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $c['estado'] === 'CANCELADA' ? 'danger' : 'warning'; ?>">
                                        <?php echo $c['estado']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo nl2br(htmlspecialchars($c['motivo_cancelacion'])); ?>
                                </td>
                                <td>
                                    <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol_nombre'] === 'ADMIN' && $c['estado'] !== 'CANCELADA'): ?>
                                        <a href="index.php?controller=cita&action=cancelar&id=<?php echo $c['id']; ?>"
                                           class="btn btn-sm btn-danger">
                                            Anular cita
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>

</div>
