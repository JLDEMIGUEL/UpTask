<div class="passrecover contenedor">

    <?php include_once __DIR__."/../templates/nombreSitio.php";?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Introduce tu nuevo password</p>

        <?php include_once __DIR__."/../templates/alertas.php";?>

        <?php if($mostrar):?>
        <form class="formulario" method="POST">
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Tu password" name="password">
            </div>
            <div class="campo">
                <label for="password2">Repetir password</label>
                <input type="password" id="password2" placeholder="Repite tu password" name="password2">
            </div>
            <input type="submit" class="boton" value="Guardar password">
        </form>
        <?php endif;?>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
            <a href="/passforgot">¿Olvidaste tu password?</a>
        </div>
    </div>
</div>