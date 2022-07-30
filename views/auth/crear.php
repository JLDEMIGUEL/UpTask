<div class="crear contenedor">

    <?php include_once __DIR__."/../templates/nombreSitio.php";?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__."/../templates/alertas.php";?>

        <form class="formulario" method="POST" action="/crear">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $usuario->nombre?>" name="nombre">
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu email" value="<?php echo $usuario->email?>" name="email">
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Tu password"  name="password">
            </div>
            <div class="campo">
                <label for="password2">Repetir password</label>
                <input type="password" id="password2" placeholder="Repite tu password"  name="password2">
            </div>
            <input type="submit" class="boton" value="Crear cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
            <a href="/passforgot">¿Olvidaste tu password?</a>
        </div>
    </div>
</div>