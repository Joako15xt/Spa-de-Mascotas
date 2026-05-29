<?php

$usuarios = $dataToView['data']['usuarios'] ?? [];
$groomer = $dataToView['data']['groomer'] ?? null;

?>

<div class="card shadow border-0">

    <div class="card-header bg-warning text-dark">

        <h4>

            ✏️ Editar Groomer

        </h4>

    </div>

    <div class="card-body">

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?php echo $groomer['id']; ?>">

            <div class="mb-3">

                <label>Usuario</label>

                <select name="usuario_id"
                        class="form-select"
                        required>

                    <?php foreach($usuarios as $u): ?>

                        <option
                            value="<?php echo $u['id']; ?>"

                            <?php
                            if($groomer['usuario_id'] == $u['id']){
                                echo 'selected';
                            }
                            ?>

                        >

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

                       value="<?php
                       echo htmlspecialchars(
                            $groomer['especialidad']
                       );
                       ?>">

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Hora Inicio</label>

                    <input type="time"
                           name="hora_inicio"
                           class="form-control"

                           value="<?php
                           echo $groomer['hora_inicio'];
                           ?>"

                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Hora Fin</label>

                    <input type="time"
                           name="hora_fin"
                           class="form-control"

                           value="<?php
                           echo $groomer['hora_fin'];
                           ?>"

                           required>

                </div>

            </div>

            <div class="mb-4">

                <label>Estado</label>

                <select name="activo"
                        class="form-select">

                    <option value="1"

                        <?php
                        if($groomer['activo'] == 1){
                            echo 'selected';
                        }
                        ?>

                    >

                        Activo

                    </option>

                    <option value="0"

                        <?php
                        if($groomer['activo'] == 0){
                            echo 'selected';
                        }
                        ?>

                    >

                        Inactivo

                    </option>

                </select>

            </div>

            <button class="btn btn-warning">

                💾 Actualizar Groomer

            </button>

            <a href="index.php?controller=groomer&action=index"
               class="btn btn-secondary">

               Cancelar

            </a>

        </form>

    </div>

</div>