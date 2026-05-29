<?php
$usuarios = $dataToView['data']['usuarios'] ?? [];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>👥 Gestión de usuarios</h3>
    <a class="btn btn-success" href="index.php?controller=usuario&action=crear">Crear personal</a>
</div>

<?php if(isset($_GET['ok'])): ?>
    <div class="alert alert-success">Usuario creado correctamente.</div>
<?php endif; ?>

<div class="card shadow border-0">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Correo verificado</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($usuarios as $u): ?>
                <tr>
                    <td><?php echo (int)$u['id']; ?></td>
                    <td><?php echo htmlspecialchars($u['nombre_completo']); ?></td>
                    <td><?php echo htmlspecialchars($u['username']); ?></td>
                    <td><?php echo htmlspecialchars($u['correo']); ?></td>
                    <td><span class="badge bg-primary"><?php echo htmlspecialchars($u['rol']); ?></span></td>
                    <td><?php echo htmlspecialchars($u['estado']); ?></td>
                    <td><?php echo $u['email_verificado'] ? 'Sí' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>