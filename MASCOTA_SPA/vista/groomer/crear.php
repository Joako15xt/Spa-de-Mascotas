<?php

$usuarios = $dataToView['data']['usuarios'] ?? [];

?>

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4>

            👨‍🔧 Registrar Groomer

        </h4>

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label>Usuario</label>

                <select name="usuario_id"
                        class="form-select"
                        required>

                    <option value="">

                        Seleccione

                    </option>

                    <?php foreach($usuarios as $u): ?>

                        <option value="<?php echo $u['id']; ?>">

                            <?php
                            echo htmlspecialchars($u['nombre_completo'])
                                 . ' ('
                                 . htmlspecialchars($u['username'])
                                 . ') - '
                                 . htmlspecialchars($u['rol_nombre']);
                            ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label>Especialidad</label>

                <input type="text"
                       name="especialidad"
                       class="form-control"
                       placeholder="Ej: Corte canino">

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Hora Inicio</label>

                    <input type="time"
                           name="hora_inicio"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Hora Fin</label>

                    <input type="time"
                           name="hora_fin"
                           class="form-control"
                           required>

                </div>

            </div>

            <div class="mb-3">

                <label>Estado</label>

                <select name="activo"
                        class="form-select">

                    <option value="1">

                        Activo

                    </option>

                    <option value="0">

                        Inactivo

                    </option>

                </select>

            </div>

            <button class="btn btn-success">

                💾 Guardar Groomer

            </button>

        </form>

    </div>

</div>