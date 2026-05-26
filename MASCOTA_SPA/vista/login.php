<?php
$error = $dataToView['data']['error'] ?? null;
$csrf = $dataToView['data']['csrf'] ?? '';
?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-3">🔐 Iniciar sesión</h3>

                <?php if(isset($_GET['timeout'])): ?>
                    <div class="alert alert-warning">La sesión se cerró por inactividad.</div>
                <?php endif; ?>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=auth&action=login">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">

                    <div class="mb-3">
                        <label>Correo o usuario</label>
                        <input class="form-control" type="text" name="login" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?controller=auth&action=registro">Crear cuenta como cliente</a>
                </div>
            </div>
        </div>
    </div>
</div>