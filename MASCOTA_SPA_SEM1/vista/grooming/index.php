<?php

$fichas = $dataToView['data']['fichas'] ?? [];

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        ✂️ Grooming
    </h2>

    <a href="index.php?controller=grooming&action=ficha"
       class="btn btn-primary">

       ➕ Nueva Ficha

    </a>

</div>

<div class="card shadow border-0">

    <div class="card-body">

        <table class="table table-hover">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Comportamiento</th>
                    <th>Tiempo</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($fichas as $f): ?>

                    <tr>

                        <td>
                            <?php echo $f['id']; ?>
                        </td>

                        <td>
                            🐶 <?php echo htmlspecialchars($f['mascota']); ?>
                        </td>

                        <td>
                            ✂️ <?php echo htmlspecialchars($f['servicio']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($f['comportamiento']); ?>
                        </td>

                        <td>
                            ⏱ <?php echo $f['tiempo_real_minutos']; ?> min
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>