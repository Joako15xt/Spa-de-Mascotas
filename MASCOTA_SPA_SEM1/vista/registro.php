<?php
$error = $dataToView['data']['error'] ?? null;
$csrf = $dataToView['data']['csrf'] ?? '';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-3">🐾 Registro de cliente</h3>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=auth&action=registro">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nombre completo</label>
                            <input class="form-control" name="nombre_completo" required value="<?php echo htmlspecialchars($_POST['nombre_completo'] ?? ''); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Usuario</label>
                            <input class="form-control" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                            <small class="text-muted">Elija un nombre único para ingresar al sistema.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Correo</label>
                            <input class="form-control" type="email" name="correo" required value="<?php echo htmlspecialchars($_POST['correo'] ?? ''); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Teléfono</label>
                            <input class="form-control" name="telefono">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>CI/NIT</label>
                            <input class="form-control" name="ci_nit">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Dirección</label>
                            <input class="form-control" name="direccion">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label>Contraseña segura</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password" id="password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    Ver
                                </button>
                            </div>

                            <small class="text-muted">
                                Mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.
                            </small>

                            <div class="progress mt-2">
                                <div id="passBar" class="progress-bar" style="width:0%">Débil</div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label>Confirmar contraseña</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password_confirm" id="password_confirm" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirm')">
                                    Ver
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-success w-100 mt-3">Crear cuenta</button>
                </form>
            </div>
        </div>
    </div>
</div>