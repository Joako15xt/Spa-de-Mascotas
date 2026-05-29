<?php

$groomers = $dataToView['data']['groomers'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">

        👨‍🔧 Groomers

    </h2>

    <a href="index.php?controller=groomer&action=crear"
       class="btn btn-primary">

       ➕ Nuevo Groomer

    </a>

</div>

<div class="card shadow border-0">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Especialidad</th>
                        <th>Horario</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($groomers as $g): ?>

                        <tr>

                            <td>

                                👨‍🔧
                                <?php echo htmlspecialchars($g['nombre']); ?>

                            </td>

                            <td>

                                <?php echo htmlspecialchars($g['usuario']); ?>

                            </td>

                            <td>

                                <?php echo htmlspecialchars($g['email']); ?>

                            </td>

                            <td>

                                ✂️
                                <?php echo htmlspecialchars($g['especialidad']); ?>

                            </td>

                            <td>

                                🕒

                                <?php
                                echo substr($g['hora_inicio'],0,5);
                                ?>

                                -

                                <?php
                                echo substr($g['hora_fin'],0,5);
                                ?>

                            </td>

                            <td>

                                <?php if($g['activo']): ?>

                                    <span class="badge bg-success">

                                        Activo

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">

                                        Inactivo

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a href="index.php?controller=groomer&action=editar&id=<?php echo $g['id']; ?>"
                                   class="btn btn-warning btn-sm">

                                   ✏️ Editar

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>