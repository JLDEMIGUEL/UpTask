<div class="passforgot contenedor">

    <?php include_once __DIR__."/../templates/nombreSitio.php";?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Introduce tu email para reestablecer tu password</p>

        <?php include_once __DIR__."/../templates/alertas.php";?>

        <form class="formulario" method="POST" action="/passforgot">
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu email" name="email">
            </div>
            <input type="submit" class="boton" value="Reestablecer password">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
            <a href="/crear">Aun no tienes una cuenta? Obten una</a>
        </div>
    </div>
</div>