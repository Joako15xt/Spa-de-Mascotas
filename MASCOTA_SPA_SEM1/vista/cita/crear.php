<?php

$mascotas = $dataToView['data']['mascotas'] ?? [];
$servicios = $dataToView['data']['servicios'] ?? [];
$groomers = $dataToView['data']['groomers'] ?? [];
$errors = $dataToView['data']['errors'] ?? [];
$formData = $dataToView['data']['formData'] ?? [];
$currentCliente = $dataToView['data']['currentCliente'] ?? null;

?>

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4>
            📅 Registrar Nueva Cita
        </h4>

    </div>

    <div class="card-body">

        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Mascota</label>

                    <select name="mascota_id"
                            class="form-select"
                            required>

                        <option value="">
                            Seleccione
                        </option>
                        <?php if(empty($servicios)): ?>
                            <option value="" disabled>
                                No hay servicios activos
                            </option>
                        <?php endif; ?>
                        <?php if(empty($mascotas)): ?>
                            <option value="" disabled>
                                No hay mascotas registradas
                            </option>
                        <?php endif; ?>

                        <?php foreach($mascotas as $m): ?>

                            <option value="<?php echo $m['id']; ?>"
                                <?php if(($formData['mascota_id'] ?? '') == $m['id']) echo 'selected'; ?>
                            >

                                <?php echo htmlspecialchars($m['nombre']); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Servicio</label>

                    <select name="servicio_id"
                            class="form-select"
                            required>

                        <?php foreach($servicios as $s): ?>

                            <option value="<?php echo $s['id']; ?>"
                                <?php if(($formData['servicio_id'] ?? '') == $s['id']) echo 'selected'; ?>
                            >

                                <?php
                                echo $s['nombre']
                                . ' - '
                                . $s['duracion_minutos']
                                . ' min';
                                ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Groomer</label>

                    <select name="groomer_id"
                            class="form-select"
                            required>

                        <option value="">
                            Seleccione
                        </option>

                        <?php if(empty($groomers)): ?>
                            <option value="" disabled>
                                No hay groomers activos
                            </option>
                        <?php endif; ?>

                        <?php foreach($groomers as $g): ?>

                            <option value="<?php echo $g['id']; ?>"
                                <?php if(($formData['groomer_id'] ?? '') == $g['id']) echo 'selected'; ?>
                            >

                                <?php
                                echo htmlspecialchars($g['nombre_completo'] ?? $g['nombre'] ?? 'Groomer desconocido');
                                ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Fecha</label>

                    <input type="date"
                           name="fecha"
                           class="form-control"
                           value="<?php echo htmlspecialchars($formData['fecha'] ?? ''); ?>"
                           required>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Hora Inicio</label>

                    <input type="time"
                           name="hora_inicio"
                           class="form-control"
                           value="<?php echo htmlspecialchars($formData['hora_inicio'] ?? ''); ?>"
                           required>

                </div>

            </div>

            <div class="mb-3">

                <label>Estado</label>

                <?php if($currentCliente): ?>

                    <input type="hidden" name="estado" value="PENDIENTE">
                    <input type="text" class="form-control" value="Pendiente" disabled>

                <?php else: ?>

                    <select name="estado"
                            class="form-select">

                        <option value="PENDIENTE"
                            <?php if(($formData['estado'] ?? '') === 'PENDIENTE') echo 'selected'; ?>
                        >
                            Pendiente
                        </option>

                        <option value="CONFIRMADA"
                            <?php if(($formData['estado'] ?? '') === 'CONFIRMADA') echo 'selected'; ?>
                        >
                            Confirmada
                        </option>

                        <option value="EN_PROCESO"
                            <?php if(($formData['estado'] ?? '') === 'EN_PROCESO') echo 'selected'; ?>
                        >
                            En proceso
                        </option>

                    </select>

                <?php endif; ?>

            </div>

            <div class="mb-3">

                <label>Observaciones</label>

                <textarea name="observaciones"
                          class="form-control"></textarea>

            </div>

            <button class="btn btn-success">

                💾 Guardar Cita

            </button>

        </form>

    </div>

</div>