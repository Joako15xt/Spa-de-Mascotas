<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">
                    ➕ Registrar Cliente
                </h4>

            </div>

            <div class="card-body">

                <form method="POST">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>
                                Nombre completo
                            </label>

                            <input type="text"
                                   name="nombre_completo"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                CI / NIT
                            </label>

                            <input type="text"
                                   name="ci_nit"
                                   class="form-control">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>
                                Teléfono
                            </label>

                            <input type="text"
                                   name="telefono"
                                   class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                Correo
                            </label>

                            <input type="email"
                                   name="correo"
                                   class="form-control">

                        </div>

                    </div>

                    <div class="mb-3">

                        <label>
                            Dirección
                        </label>

                        <textarea name="direccion"
                                  class="form-control"></textarea>

                    </div>

                    <button class="btn btn-success">

                        💾 Guardar Cliente

                    </button>

                    <a href="index.php?controller=cliente&action=listar"
                       class="btn btn-secondary">

                        Cancelar

                    </a>

                </form>

            </div>

        </div>

    </div>

</div>