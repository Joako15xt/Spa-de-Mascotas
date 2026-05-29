<?php

$agenda = $dataToView['data']['agenda'] ?? [];
$fecha = $dataToView['data']['fecha'] ?? date('Y-m-d');

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            📅 Agenda Grooming
        </h2>

        <p class="text-muted">
            Control operativo diario del spa
        </p>

    </div>

    <a href="index.php?controller=cita&action=crear"
       class="btn btn-primary">

       ➕ Nueva Cita

    </a>

</div>

<div class="card shadow border-0 mb-4">

    <div class="card-body">

        <form method="GET"
              class="row align-items-end">

            <input type="hidden"
                   name="controller"
                   value="agenda">

            <input type="hidden"
                   name="action"
                   value="index">

            <div class="col-md-4">

                <label class="form-label">

                    Seleccionar fecha

                </label>

                <input type="date"
                       name="fecha"
                       value="<?php echo $fecha; ?>"
                       class="form-control">

            </div>

            <div class="col-md-2">

                <button class="btn btn-dark w-100">

                    Ver Agenda

                </button>

            </div>

        </form>

    </div>

</div>

<div class="row">

<?php if(count($agenda) > 0): ?>

    <?php foreach($agenda as $a): ?>

        <?php

        $color = 'secondary';

        switch($a['estado']){

            case 'PENDIENTE':
                $color = 'warning';
            break;

            case 'CONFIRMADA':
                $color = 'primary';
            break;

            case 'EN_PROCESO':
                $color = 'info';
            break;

            case 'FINALIZADA':
                $color = 'success';
            break;

            case 'CANCELADA':
                $color = 'danger';
            break;
        }

        ?>

        <div class="col-md-6 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-<?php echo $color; ?> text-white">

                    <div class="d-flex justify-content-between">

                        <strong>

                            🕒
                            <?php echo substr($a['hora_inicio'],0,5); ?>

                            -

                            <?php echo substr($a['hora_fin'],0,5); ?>

                        </strong>

                        <span>

                            <?php echo $a['estado']; ?>

                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <h5 class="fw-bold">

                        🐶
                        <?php echo htmlspecialchars($a['mascota']); ?>

                    </h5>

                    <p class="mb-2">

                        ✂️ Servicio:
                        <strong>

                            <?php
                            echo htmlspecialchars($a['servicio']);
                            ?>

                        </strong>

                    </p>

                    <p class="mb-2">

                        👨‍🔧 Groomer:
                        <strong>

                            <?php
                            echo htmlspecialchars($a['groomer']);
                            ?>

                        </strong>

                    </p>

                    <p class="mb-0 text-muted">

                        📝
                        <?php
                        echo htmlspecialchars($a['observaciones']);
                        ?>

                    </p>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <div class="col-md-12">

        <div class="alert alert-info shadow-sm">

            No existen citas registradas para esta fecha.

        </div>

    </div>

<?php endif; ?>

</div>