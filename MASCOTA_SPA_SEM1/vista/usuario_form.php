<?php
$error = $dataToView['data']['error'] ?? null;
$csrf = $dataToView['data']['csrf'] ?? '';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="mb-3">➕ Crear usuario interno</h3>
                <p class="text-muted">Solo el administrador puede crear cuentas para recepción y groomers.</p>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=usuario&action=crear">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">

                    <div class="mb-3">
                        <label>Rol</label>
                        <select class="form-select" name="rol_id" required>
                            <option value="2">Recepción</option>
                            <option value="3">Groomer</option>
                            <option value="1">Administrador</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre completo</label>
                        <input class="form-control" name="nombre_completo" required>
                    </div>

                    <div class="mb-3">
                        <label>Usuario</label>
                        <input class="form-control" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label>Correo</label>
                        <input class="form-control" type="email" name="correo" required>
                    </div>

                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input class="form-control" name="telefono">
                    </div>

                    <div class="mb-3">
                        <label>Especialidad si es groomer</label>
                        <input class="form-control" name="especialidad" placeholder="Ej: Corte fino, baño completo">
                    </div>
                    <label>Contraseña</label>
                    <div class="input-group">
                        <input class="form-control" type="password" name="password" id="password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                            Ver
                        </button>
                    </div>

                    <div class="progress mt-2">
                        <div id="passBar" class="progress-bar" style="width:0%">Débil</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Confirmar contraseña</label>
                    <div class="input-group">
                        <input class="form-control" type="password" name="password_confirm" id="password_confirm" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirm')">
                            Ver
                        </button>
                    </div>
                </div>

                    <button class="btn btn-success w-100">Guardar usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>