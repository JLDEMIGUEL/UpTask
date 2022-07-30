<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <a href="/perfil" class="enlace">Volver a Perfil</a>
    <?php include_once __DIR__ . '/../templates/alertas.php' ?>
    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="campo">
            <label for="password_actual">Password actual</label>
            <input id="password_actual" name="password_actual" type="password" placeholder="Tu password actual">
        </div>
        <div class="campo">
            <label for="password_nuevo">Password nuevo</label>
            <input id="password_nuevo" name="password_nuevo" type="password" placeholder="Tu password nuevo">
        </div>

        <input type="submit" value="Guardar cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>