<?php
$error = $dataToView['data']['error'] ?? null;
$csrf = $dataToView['data']['csrf'] ?? '';
$demo = $dataToView['data']['demo_codigo'] ?? '';
?>

<div class="row">
    <div class="col-md-5 offset-md-3">
        <div class="card shadow border-0">
            <div class="card-body p-4 text-center">
                <h3>🔢 Verificación en dos pasos</h3>
                <p class="text-muted">Ingrese el código de 4 dígitos enviado al correo del administrador.</p>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if($demo): ?>
                    <div class="alert alert-info">
                        <strong>Modo demo:</strong> Código generado: <code><?php echo htmlspecialchars($demo); ?></code>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=auth&action=verificar2fa">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">

                    <input class="form-control form-control-lg text-center mb-3"
                           name="codigo"
                           maxlength="4"
                           pattern="[0-9]{4}"
                           placeholder="0000"
                           required>

                    <button class="btn btn-success w-100">Verificar código</button>
                </form>
            </div>
        </div>
    </div>
</div>