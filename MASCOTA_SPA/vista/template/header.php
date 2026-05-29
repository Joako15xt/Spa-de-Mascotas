<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Spa Mascotas
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #eef5ff 0%, #f9fbff 100%);
            min-height: 100vh;
            color: #12263f;
        }

        .navbar {
            background: linear-gradient(90deg, #1f62d0 0%, #5d4bff 100%);
            box-shadow: 0 18px 40px rgba(24, 67, 137, 0.18);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .navbar-brand {
            font-size: 1.35rem;
            letter-spacing: 0.04em;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.4);
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.92);
            margin: 0 0.18rem;
            border-radius: 999px;
            padding: 0.65rem 1rem;
            transition: all 0.25s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.18);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
        }

        .navbar-nav .nav-item + .nav-item {
            margin-left: 0.2rem;
        }

        .page-shell {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 22px 55px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            backdrop-filter: blur(10px);
        }

        .footer-card {
            background: linear-gradient(135deg, #1f62d0 0%, #5d4bff 100%);
            color: #ffffff;
            border-radius: 22px;
            padding: 22px 26px;
            box-shadow: 0 14px 34px rgba(31, 96, 208, 0.16);
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-link:hover {
            color: #ffffff;
        }
    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow">

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

                    <?php if($_SESSION['usuario']['rol_nombre'] === 'CLIENTE'): ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="index.php?controller=mascota&action=listar">

                                🐶 Mis Mascotas

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="index.php?controller=cita&action=listar">

                                📋 Mis Citas

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="index.php?controller=cita&action=solicitudes">

                                🔔 Solicitud de anulaciones

                            </a>
                        </li>

                    <?php else: ?>

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
                            <a class="nav-link btn btn-sm btn-outline-primary text-dark rounded-pill"
                               href="index.php?controller=groomer&action=index"
                               style="margin-right:0.35rem;">

                                👨‍🔧 Groomers

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

                        <?php if($_SESSION['usuario']['rol_nombre'] === 'ADMIN'): ?>

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

                <?php endif; ?>

            </ul>

            <ul class="navbar-nav">

                <?php if(isset($_SESSION['usuario'])): ?>

                    <li class="nav-item">

                        <span class="nav-link text-warning">

                            👋
                            <?php echo htmlspecialchars($_SESSION['usuario']['nombre_completo'] ?? $_SESSION['usuario']['nombre'] ?? 'Usuario'); ?>

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

<div class="container py-4 page-shell">