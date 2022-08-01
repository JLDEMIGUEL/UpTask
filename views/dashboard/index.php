<?php include_once __DIR__ . '/header-dashboard.php' ?>

<?php if (count($proyectos) === 0) { ?>
    <p class="no-proyectos">No hay proyectos aún <a href="/crear-proyecto">Crea uno</a></p>
<?php } else { ?>
    <ul class="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) { ?>
            <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                <li class="proyecto" data-id="<?php echo $proyecto->url;?>">
                    <?php echo $proyecto->proyecto ?>
                    <progress value="0" max="100"></progress>
                    <p class="progreso"></p>
                </li>
                
            </a>
        <?php } ?>
    </ul>
<?php } ?>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>