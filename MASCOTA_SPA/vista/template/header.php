<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Spa Mascotas
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background: #f4f6f9;">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">

            🐾 Spa Mascotas

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav me-auto">

                <?php if(isset($_SESSION['usuario'])): ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=dashboard&action=index">

                            🏠 Dashboard

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=cliente&action=listar">

                            👨‍👩‍👧 Clientes

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=mascota&action=listar">

                            🐶 Mascotas

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=servicio&action=listar">

                            ✂️ Servicios

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=agenda&action=index">

                            📅 Agenda

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=cita&action=listar">

                            📋 Citas

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="index.php?controller=grooming&action=index">

                            🛁 Grooming

                        </a>
                    </li>

                    <?php if($_SESSION['usuario']['rol_nombre'] == 'ADMIN'): ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="index.php?controller=usuario&action=listar">

                                👤 Usuarios

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="index.php?controller=auditoria&action=listar">

                                📑 Auditoría

                            </a>
                        </li>

                    <?php endif; ?>

                <?php endif; ?>

            </ul>

            <ul class="navbar-nav">

                <?php if(isset($_SESSION['usuario'])): ?>

                    <li class="nav-item">

                        <span class="nav-link text-warning">

                            👋
                            <?php echo htmlspecialchars($_SESSION['usuario']['nombre_completo']); ?>

                        </span>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link text-danger"
                           href="index.php?controller=auth&action=logout">

                            🚪 Salir

                        </a>

                    </li>

                <?php else: ?>

                    <li class="nav-item">

                        <a class="nav-link"
                           href="index.php?controller=auth&action=login">

                            🔐 Iniciar sesión

                        </a>

                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>

<div class="container py-4">