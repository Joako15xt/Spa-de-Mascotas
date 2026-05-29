<?php

$servicio = array_merge([
    'nombre' => '',
    'descripcion' => '',
    'duracion_minutos' => '',
    'precio_base' => '',
    'activo' => 0
], (array) ($dataToView['data']['servicio'] ?? []));

?>

<div class="card shadow border-0">

    <div class="card-header bg-warning">

        <h4>
            ✏️ Editar Servicio
        </h4>

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label>Nombre Servicio</label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       value="<?php echo htmlspecialchars($servicio['nombre']); ?>">

            </div>

            <div class="mb-3">

                <label>Descripción</label>

                <textarea name="descripcion"
                          class="form-control"><?php echo htmlspecialchars($servicio['descripcion']); ?></textarea>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Duración (minutos)</label>

                    <input type="number"
                           name="duracion_minutos"
                           class="form-control"
                           value="<?php echo $servicio['duracion_minutos']; ?>">

                </div>

                <div class="col-md-6 mb-3">

                    <label>Precio Base</label>

                    <input type="number"
                           step="0.01"
                           name="precio_base"
                           class="form-control"
                           value="<?php echo $servicio['precio_base']; ?>">

                </div>

            </div>

            <div class="mb-3">

                <label>Estado</label>

                <select name="activo"
                        class="form-select">

                    <option value="1"
                        <?php if($servicio['activo']) echo 'selected'; ?>>
                        Activo
                    </option>

                    <option value="0"
                        <?php if(!$servicio['activo']) echo 'selected'; ?>>
                        Inactivo
                    </option>

                </select>

            </div>

            <button class="btn btn-success">

                💾 Actualizar

            </button>

        </form>

    </div>

</div>