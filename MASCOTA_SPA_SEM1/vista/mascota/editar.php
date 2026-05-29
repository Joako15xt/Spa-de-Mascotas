<?php

$mascota = array_merge([
    'cliente_id' => null,
    'nombre' => '',
    'especie' => '',
    'raza' => '',
    'sexo' => '',
    'fecha_nacimiento' => '',
    'tamano' => 'PEQUENO',
    'peso' => '',
    'color' => '',
    'tiempo_mascota' => '',
    'alergias' => '',
    'comportamiento' => '',
    'observaciones' => '',
    'temperamento' => '',
    'vacunas' => 0
], (array) ($dataToView['data']['mascota'] ?? []));
$clientes = $dataToView['data']['clientes'] ?? [];
$currentCliente = $dataToView['data']['currentCliente'] ?? null;

?>

<div class="card shadow border-0">

    <div class="card-header bg-warning">

        <h4>
            ✏️ Editar Mascota
        </h4>

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Dueño</label>

                    <?php if($currentCliente): ?>

                        <input type="hidden" name="cliente_id" value="<?php echo $currentCliente['id']; ?>">

                        <input type="text"
                               class="form-control"
                               value="<?php echo htmlspecialchars($currentCliente['nombre_completo']); ?>"
                               disabled>

                    <?php else: ?>

                        <select name="cliente_id"
                                class="form-select">

                            <?php foreach($clientes as $c): ?>

                                <option
                                    value="<?php echo $c['id']; ?>"

                                    <?php
                                    if($mascota['cliente_id'] === $c['id']){
                                        echo 'selected';
                                    }
                                    ?>
                                >

                                    <?php
                                    echo htmlspecialchars(
                                        trim($c['nombre_completo'] ?? '') ?: 'Cliente sin nombre'
                                    );
                                    ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    <?php endif; ?>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Nombre Mascota</label>

                    <input type="text"
                           name="nombre"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['nombre']); ?>">

                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Especie</label>

                    <input type="text"
                           name="especie"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['especie']); ?>">

                </div>

                <div class="col-md-4 mb-3">

                    <label>Raza</label>

                    <input type="text"
                           name="raza"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['raza']); ?>">

                </div>

                <div class="col-md-4 mb-3">

                    <label>Sexo</label>

                    <input type="text"
                           name="sexo"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['sexo']); ?>">

                </div>

            </div>

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label>Fecha de nacimiento</label>

                    <input type="date"
                           name="fecha_nacimiento"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['fecha_nacimiento']); ?>">

                </div>

                <div class="col-md-3 mb-3">

                    <label>Tamaño</label>

                    <select name="tamano"
                            class="form-select">

                        <option value="PEQUENO" <?php if($mascota['tamano']==='PEQUENO') echo 'selected'; ?>>Pequeño</option>
                        <option value="MEDIANO" <?php if($mascota['tamano']==='MEDIANO') echo 'selected'; ?>>Mediano</option>
                        <option value="GRANDE" <?php if($mascota['tamano']==='GRANDE') echo 'selected'; ?>>Grande</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Peso</label>

                    <input type="text"
                           name="peso"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['peso']); ?>">

                </div>

                <div class="col-md-3 mb-3">

                    <label>Color</label>

                    <input type="text"
                           name="color"
                           class="form-control"
                           value="<?php echo htmlspecialchars($mascota['color']); ?>">

                </div>

            </div>

            <div class="mb-3">

                <label>Alergias</label>

                <textarea name="alergias"
                          class="form-control"><?php echo htmlspecialchars($mascota['alergias']); ?></textarea>

            </div>

            <div class="mb-3">

                <label>Temperamento</label>

                <textarea name="temperamento"
                          class="form-control"><?php echo htmlspecialchars($mascota['temperamento']); ?></textarea>

            </div>

            <div class="mb-3">

                <label>Vacunas</label>

                <select name="vacunas"
                        class="form-select">

                    <option value="1"
                        <?php if($mascota['vacunas']) echo 'selected'; ?>>
                        Sí
                    </option>

                    <option value="0"
                        <?php if(!$mascota['vacunas']) echo 'selected'; ?>>
                        No
                    </option>

                </select>

            </div>

            <button class="btn btn-success">

                💾 Actualizar

            </button>

        </form>

    </div>

</div>