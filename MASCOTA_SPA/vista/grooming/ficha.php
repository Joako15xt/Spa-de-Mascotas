<?php

$citas = $dataToView['data']['citas'] ?? [];
$error = $dataToView['data']['error'] ?? null;

?>

<div class="card shadow border-0">

    <div class="card-header bg-dark text-white">

        <h4>
            🐶 Ficha Grooming
        </h4>

    </div>

    <div class="card-body">

        <?php if(!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">

                <label>Cita</label>

                <select name="cita_id"
                        class="form-select"
                        required>

                    <option value="">
                        Seleccione
                    </option>

                    <?php if(empty($citas)): ?>
                        <option value="" disabled>
                            No hay citas disponibles
                        </option>
                    <?php endif; ?>

                    <?php foreach($citas as $c): ?>

                        <option value="<?php echo $c['id']; ?>">

                            <?php
                            echo $c['mascota']
                                 . ' - '
                                 . $c['servicio'];
                            ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <?php if(empty($citas)): ?>
                <div class="alert alert-warning">
                    No hay citas disponibles para crear una ficha de grooming.
                    Primero crea una cita válida en la agenda.
                </div>
            <?php endif; ?>

            <div class="mb-3">

                <label>Estado Mascota</label>

                <textarea name="estado_mascota"
                          class="form-control"></textarea>

            </div>

            <div class="mb-3">

                <label>Comportamiento</label>

                <input type="text"
                       name="comportamiento"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Tiempo Real (min)</label>

                <input type="number"
                       name="tiempo_real_minutos"
                       class="form-control">

            </div>

            <hr>

            <h5>
                ✅ Checklist
            </h5>

            <div class="row">

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="bano"
                               class="form-check-input">

                        <label class="form-check-label">

                            Baño

                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="corte"
                               class="form-check-input">

                        <label class="form-check-label">

                            Corte

                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="unas"
                               class="form-check-input">

                        <label class="form-check-label">

                            Uñas

                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="oidos"
                               class="form-check-input">

                        <label class="form-check-label">

                            Oídos

                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="perfume"
                               class="form-check-input">

                        <label class="form-check-label">

                            Perfume

                        </label>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-check">

                        <input type="checkbox"
                               name="glandulas"
                               class="form-check-input">

                        <label class="form-check-label">

                            Glándulas

                        </label>

                    </div>

                </div>

            </div>

            <hr>

            <div class="mb-3">

                <label>Recomendaciones</label>

                <textarea name="recomendaciones"
                          class="form-control"></textarea>

            </div>

            <div class="mb-3">

                <label>Observaciones</label>

                <textarea name="observaciones"
                          class="form-control"></textarea>

            </div>

            <button class="btn btn-success" <?php echo empty($citas) ? 'disabled' : ''; ?>>

                💾 Guardar Ficha

            </button>

        </form>

    </div>

</div>