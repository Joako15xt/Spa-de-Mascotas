<?php

$cliente = $dataToView['data']['cliente'] ?? $cliente ?? null;

if(!$cliente || !is_array($cliente)){
    echo '<div class="alert alert-warning">Cliente no encontrado o inválido.</div>';
    return;
}

?>

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card shadow border-0">

            <div class="card-header bg-warning">

                <h4 class="mb-0">
                    ✏️ Editar Cliente
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
                                   required
                                   value="<?php echo htmlspecialchars($cliente['nombre_completo']); ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                CI / NIT
                            </label>

                            <input type="text"
                                   name="ci_nit"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($cliente['ci_nit']); ?>">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>
                                Teléfono
                            </label>

                            <input type="text"
                                   name="telefono"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($cliente['telefono']); ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>
                                Correo
                            </label>

                            <input type="email"
                                   name="correo"
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($cliente['correo']); ?>">

                        </div>

                    </div>

                    <div class="mb-3">

                        <label>
                            Dirección
                        </label>

                        <textarea name="direccion"
                                  class="form-control"><?php echo htmlspecialchars($cliente['direccion']); ?></textarea>

                    </div>

                    <button class="btn btn-success">

                        💾 Actualizar

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