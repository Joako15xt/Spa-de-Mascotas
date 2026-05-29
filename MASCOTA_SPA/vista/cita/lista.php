<?php

$citas = $dataToView['data']['citas'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        📅 Agenda Grooming
    </h2>

    <div>
        <a href="index.php?controller=cita&action=crear"
           class="btn btn-primary me-2">

            ➕ Nueva Cita

        </a>

        <?php if(isset($_SESSION['usuario']) && in_array($_SESSION['usuario']['rol_nombre'], ['CLIENTE', 'ADMIN'])): ?>
            <a href="index.php?controller=cita&action=solicitudes"
               class="btn btn-outline-warning">

               🔔 Solicitud de anulaciones

            </a>
        <?php endif; ?>
    </div>

</div>

<div class="card shadow border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>Mascota</th>
                        <th>Servicio</th>
                        <th>Groomer</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Duración</th>
                        <th>Precio</th>
                        <th>Notificación</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($citas as $c): ?>

                        <tr>

                            <td>

                                🐶
                                <?php echo htmlspecialchars($c['mascota']); ?>

                            </td>

                            <td>

                                ✂️
                                <?php echo htmlspecialchars($c['servicio']); ?>

                            </td>

                            <td>

                                👨‍🔧
                                <?php echo htmlspecialchars($c['groomer']); ?>

                            </td>

                            <td>

                                <?php echo $c['fecha']; ?>

                            </td>

                            <td>

                                <?php
                                echo substr($c['hora_inicio'],0,5);
                                ?>

                                -

                                <?php
                                echo substr($c['hora_fin'],0,5);
                                ?>

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    <?php
                                    echo $c['duracion_minutos'];
                                    ?> min

                                </span>

                            </td>

                            <td>

                                <span class="badge bg-success">

                                    Bs.
                                    <?php echo $c['precio_final']; ?>

                                </span>

                            </td>

                            <td>

                                <?php

                                $color = 'secondary';

                                switch($c['estado']){

                                    case 'PENDIENTE':
                                        $color='warning';
                                    break;

                                    case 'CONFIRMADA':
                                        $color='primary';
                                    break;

                                    case 'EN_PROCESO':
                                        $color='info';
                                    break;

                                    case 'FINALIZADA':
                                        $color='success';
                                    break;

                                    case 'CANCELADA':
                                        $color='danger';
                                    break;
                                }

                                ?>

                                <?php if(!empty($c['motivo_cancelacion']) && $c['estado'] !== 'CANCELADA'): ?>
                                    <span class="badge bg-warning text-dark">
                                        Solicitud de anulación
                                    </span>
                                    <div class="small text-truncate" style="max-width:180px;">
                                        <?php echo htmlspecialchars($c['motivo_cancelacion']); ?>
                                    </div>
                                <?php else: ?>
                                    -
                                <?php endif; ?>

                            </td>

                            <td>

                                <span class="badge bg-<?php echo $color; ?>">

                                    <?php echo $c['estado']; ?>

                                </span>

                            </td>

                            <td>

                                <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol_nombre'] === 'CLIENTE' && $c['estado'] !== 'CANCELADA' && empty($c['motivo_cancelacion'])): ?>
                                    <a href="index.php?controller=cita&action=solicitarAnulacion&id=<?php echo $c['id']; ?>"
                                       class="btn btn-sm btn-outline-warning">
                                        Solicitar anulación
                                    </a>
                                <?php elseif(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol_nombre'] === 'ADMIN' && $c['estado'] !== 'CANCELADA'): ?>
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

    </div>

</div>