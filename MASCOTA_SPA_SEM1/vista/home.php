<div class="hero p-5 text-center mb-5">
    <h1 class="display-5 fw-bold">🐶 Spa, grooming y tienda para mascotas 🐱</h1>
    <p class="lead mt-3">
        Organiza citas, registra mascotas, controla usuarios y prepara la base para gestionar servicios, ventas y notificaciones.
    </p>

    <?php if(!isset($_SESSION['usuario'])): ?>
        <div class="mt-4">
            <a class="btn btn-light btn-lg me-2" href="index.php?controller=auth&action=login">Ingresar al sistema</a>
            <a class="btn btn-outline-light btn-lg" href="index.php?controller=auth&action=registro">Registrarme como cliente</a>
        </div>
    <?php endif; ?>
</div>

<?php if(!isset($_SESSION['usuario'])): ?>
<div class="alert alert-warning shadow-sm">
    <strong>Datos para la demo:</strong><br>
    Admin: <code>admin</code> / <code>Admin123!</code><br>
    Correo admin: <code>admin@pawspa.com</code><br>
    Al ingresar como administrador, el sistema pedirá código 2FA.
</div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 shadow border-0 glass text-center p-3">
            <div class="service-icon">📅</div>
            <h4>Agenda de citas</h4>
            <p>Diseñada para controlar fecha, hora, groomer, estado de cita y disponibilidad.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow border-0 glass text-center p-3">
            <div class="service-icon">✂️</div>
            <h4>Grooming</h4>
            <p>Ficha de atención para baño, corte, uñas, oídos, fotos antes/después y recomendaciones.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow border-0 glass text-center p-3">
            <div class="service-icon">🛒</div>
            <h4>Tienda</h4>
            <p>Catálogo de productos, stock, ventas y pedidos rápidos por WhatsApp.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow border-0 glass text-center p-3">
            <div class="service-icon">🐾</div>
            <h4>Clientes y mascotas</h4>
            <p>Registro de dueños, mascotas, alergias, vacunas, comportamiento e historial de visitas.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow border-0 glass text-center p-3">
            <div class="service-icon">🔐</div>
            <h4>Seguridad</h4>
            <p>Roles, BCrypt, correo único, bloqueo por intentos, sesión protegida y 2FA para administrador.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow border-0 glass text-center p-3">
            <div class="service-icon">📊</div>
            <h4>Reportes</h4>
            <p>Base preparada para reportes de citas, ventas, servicios, stock y calificación a groomers.</p>
        </div>
    </div>
</div>