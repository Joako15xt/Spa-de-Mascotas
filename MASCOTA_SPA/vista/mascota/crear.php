<?php

$clientes = $dataToView['data']['clientes'] ?? [];
$currentCliente = $dataToView['data']['currentCliente'] ?? null;

?>

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4>
            🐶 Registrar Mascota
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
                                class="form-select"
                                required>

                            <option value="">
                                Seleccione
                            </option>

                            <?php foreach($clientes as $c): ?>

                                <option value="<?php echo $c['id']; ?>">

                                    <?php
                                    echo htmlspecialchars($c['nombre_completo']);
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
                           required>

                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Especie</label>

                    <select name="especie"
                            class="form-select">

                        <option>Perro</option>
                        <option>Gato</option>

                    </select>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Raza</label>

                    <input type="text"
                           name="raza"
                           class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label>Sexo</label>

                    <select name="sexo"
                            class="form-select">

                        <option>Macho</option>
                        <option>Hembra</option>

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label>Fecha de nacimiento</label>

                    <input type="date"
                           name="fecha_nacimiento"
                           class="form-control">

                </div>

                <div class="col-md-3 mb-3">

                    <label>Tamaño</label>

                    <select name="tamano"
                            class="form-select">

                        <option value="PEQUENO">Pequeño</option>
                        <option value="MEDIANO">Mediano</option>
                        <option value="GRANDE">Grande</option>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label>Peso</label>

                    <input type="text"
                           name="peso"
                           class="form-control">

                </div>

                <div class="col-md-3 mb-3">

                    <label>Color</label>

                    <input type="text"
                           name="color"
                           class="form-control">

                </div>

            </div>

            <div class="mb-3">

                <label>Alergias</label>

                <textarea name="alergias"
                          class="form-control"></textarea>

            </div>

            <div class="mb-3">

                <label>Temperamento</label>

                <textarea name="temperamento"
                          class="form-control"></textarea>

            </div>

            <div class="mb-3">

                <label>Vacunas al día</label>

                <select name="vacunas"
                        class="form-select">

                    <option value="1">
                        Sí
                    </option>

                    <option value="0">
                        No
                    </option>

                </select>

            </div>

            <button class="btn btn-success">

                💾 Guardar Mascota

            </button>

        </form>

    </div>

</div>