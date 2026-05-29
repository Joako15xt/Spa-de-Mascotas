<?php
$registros = $dataToView['data']['registros'] ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>📋 Auditoría del sistema</h3>
    <a class="btn btn-outline-primary" href="index.php">Volver al inicio</a>
</div>

<div class="alert alert-info">
    Aquí se registran eventos importantes del sistema: inicios de sesión, intentos fallidos, verificación 2FA y creación de usuarios.
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <?php if(empty($registros)): ?>
            <div class="alert alert-warning mb-0">
                Todavía no existen registros de auditoría.
            </div>
        <?php else: ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acción</th>
                        <th>IP</th>
                        <th>Navegador / Dispositivo</th>
                        <th>Fecha y hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($registros as $r): ?>
                        <tr>
                            <td><?php echo (int)$r['id']; ?></td>

                            <td>
                                <?php if(!empty($r['nombre_completo'])): ?>
                                    <strong><?php echo htmlspecialchars($r['nombre_completo']); ?></strong><br>
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($r['username']); ?>
                                    </small>
                                <?php else: ?>
                                    <span class="text-muted">Usuario no identificado</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    <?php echo htmlspecialchars($r['rol'] ?? 'Sin rol'); ?>
                                </span>
                            </td>

                            <td><?php echo htmlspecialchars($r['accion']); ?></td>

                            <td>
                                <code><?php echo htmlspecialchars($r['ip_address']); ?></code>
                            </td>

                            <td style="max-width: 300px;">
                                <small><?php echo htmlspecialchars($r['user_agent']); ?></small>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($r['creado_en']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>
    </div>
</div>