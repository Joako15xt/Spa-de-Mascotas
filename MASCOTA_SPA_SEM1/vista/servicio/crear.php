<div class="card shadow border-0">

    <div class="card-header bg-primary text-white">

        <h4>
            ✂️ Nuevo Servicio
        </h4>

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label>Nombre Servicio</label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label>Descripción</label>

                <textarea name="descripcion"
                          class="form-control"></textarea>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Duración (minutos)</label>

                    <input type="number"
                           name="duracion_minutos"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Precio Base</label>

                    <input type="number"
                           step="0.01"
                           name="precio_base"
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

                💾 Guardar Servicio

            </button>

        </form>

    </div>

</div>