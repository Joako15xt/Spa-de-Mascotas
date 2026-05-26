<?php
$titulo = $dataToView['data']['titulo'] ?? 'Mensaje';
$mensaje = $dataToView['data']['mensaje'] ?? '';
?>

<div class="card shadow border-0">
    <div class="card-body p-4 text-center">
        <h3><?php echo htmlspecialchars($titulo); ?></h3>
        <p class="lead"><?php echo htmlspecialchars($mensaje); ?></p>
        <a class="btn btn-primary" href="index.php?controller=auth&action=login">Ir al login</a>
    </div>
</div>