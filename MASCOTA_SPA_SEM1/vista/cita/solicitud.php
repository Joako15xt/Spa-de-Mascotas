<?php

$cita = $dataToView['data']['cita'] ?? null;

?>

<div class="card shadow border-0">

    <div class="card-header bg-warning text-dark">

        <h4>✉️ Solicitud de anulación</h4>

    </div>

    <div class="card-body">

        <?php if(!$cita): ?>
            <div class="alert alert-danger">
                Cita no encontrada.
            </div>
        <?php else: ?>

            <div class="mb-4">
                <strong>Mascota:</strong> <?php echo htmlspecialchars($cita['mascota']); ?><br>
                <strong>Fecha:</strong> <?php echo $cita['fecha']; ?><br>
                <strong>Horario:</strong> <?php echo substr($cita['hora_inicio'],0,5); ?> - <?php echo substr($cita['hora_fin'],0,5); ?><br>
                <strong>Groomer:</strong> <?php echo htmlspecialchars($cita['groomer']); ?><br>
                <strong>Estado:</strong> <?php echo htmlspecialchars($cita['estado']); ?>
            </div>

            <form method="POST">

                <div class="mb-3">
                    <label>Motivo de la anulación</label>
                    <textarea name="motivo_cancelacion" class="form-control" required></textarea>
                </div>

                <button class="btn btn-warning">
                    Enviar solicitud
                </button>

                <a href="index.php?controller=cita&action=listar"
                   class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        <?php endif; ?>

    </div>

</div>
