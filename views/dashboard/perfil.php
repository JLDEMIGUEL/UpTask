<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <a href="/cambiar-password" class="enlace">Cambiar Password</a>

    <?php include_once __DIR__ . '/../templates/alertas.php' ?>


    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" class="nombre" type="text" value="<?php echo $usuario->nombre; ?>" placeholder="Tu nombre">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input id="email" name="email" class="email" type="email" value="<?php echo $usuario->email; ?>" placeholder="Tu email">
        </div>

        <input type="submit" value="Guardar cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>