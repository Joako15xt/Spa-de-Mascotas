<?php

$total_clientes = $dataToView['data']['total_clientes'] ?? 0;
$total_mascotas = $dataToView['data']['total_mascotas'] ?? 0;
$total_citas = $dataToView['data']['total_citas'] ?? 0;
$total_groomers = $dataToView['data']['total_groomers'] ?? 0;

$citas_hoy = $dataToView['data']['citas_hoy'] ?? [];

?>

<div class="row mb-4">

    <div class="col-md-12">
        <div class="p-5 rounded shadow-lg text-white"
             style="
                background:
                linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)),
                url('assets/img/banner.jpg');
                background-size: cover;
                background-position: center;
             ">

            <h1 class="display-4 fw-bold">
                🐾 Spa de Mascotas
            </h1>

            <p class="lead">
                Sistema web de gestión de grooming, agenda y atención de mascotas.
            </p>

        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card border-0 shadow h-100 text-center">

            <div class="card-body">

                <div style="font-size: 55px;">
                    👨‍👩‍👧
                </div>

                <h3 class="fw-bold mt-3">
                    <?php echo $total_clientes; ?>
                </h3>

                <p class="text-muted">
                    Clientes registrados
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card border-0 shadow h-100 text-center">

            <div class="card-body">

                <div style="font-size: 55px;">
                    🐶
                </div>

                <h3 class="fw-bold mt-3">
                    <?php echo $total_mascotas; ?>
                </h3>

                <p class="text-muted">
                    Mascotas registradas
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card border-0 shadow h-100 text-center">

            <div class="card-body">

                <div style="font-size: 55px;">
                    📅
                </div>

                <h3 class="fw-bold mt-3">
                    <?php echo $total_citas; ?>
                </h3>

                <p class="text-muted">
                    Citas registradas
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card border-0 shadow h-100 text-center">

            <div class="card-body">

                <div style="font-size: 55px;">
                    ✂️
                </div>

                <h3 class="fw-bold mt-3">
                    <?php echo $total_groomers; ?>
                </h3>

                <p class="text-muted">
                    Groomers activos
                </p>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-md-8">

        <div class="card border-0 shadow">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">
                    📅 Citas de hoy
                </h5>

            </div>

            <div class="card-body">

                <?php if(empty($citas_hoy)): ?>

                    <div class="alert alert-warning">
                        No existen citas registradas hoy.
                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>

                                <tr>
                                    <th>Mascota</th>
                                    <th>Servicio</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach($citas_hoy as $c): ?>

                                    <tr>

                                        <td>
                                            <?php echo htmlspecialchars($c['mascota']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($c['servicio']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($c['hora_inicio']); ?>
                                        </td>

                                        <td>

                                            <?php

                                            $color = 'secondary';

                                            if($c['estado'] == 'PENDIENTE'){
                                                $color = 'warning';
                                            }

                                            if($c['estado'] == 'CONFIRMADA'){
                                                $color = 'success';
                                            }

                                            if($c['estado'] == 'CANCELADA'){
                                                $color = 'danger';
                                            }

                                            ?>

                                            <span class="badge bg-<?php echo $color; ?>">

                                                <?php echo htmlspecialchars($c['estado']); ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow h-100">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">
                    🐾 Servicios del Spa
                </h5>

            </div>

            <div class="card-body">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item">
                        🛁 Baño
                    </li>

                    <li class="list-group-item">
                        ✂️ Corte de pelo
                    </li>

                    <li class="list-group-item">
                        🐶 Grooming completo
                    </li>

                    <li class="list-group-item">
                        💅 Corte de uñas
                    </li>

                    <li class="list-group-item">
                        👂 Limpieza de oídos
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>