<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button type="button" class="borrar-proyecto" id="borrar-proyecto">Borrar proyecto</button>
        <button type="button" class="agregar-tarea" id="agregar-tarea">&#43; Nueva tarea</button>
    </div>

    <div id="filtros" class="filtros">
        <div class="filtros-inputs">
            <h2>Filtros:</h2>
            <div class="campo">
                <label for="todas">Todas</label>
                <input id="todas" type="radio" name="filtro" value="" checked>
            </div>
            <div class="campo">
                <label for="completadas">Completadas</label>
                <input id="completadas" type="radio" name="filtro" value="1">
            </div>
            <div class="campo">
                <label for="pendientes">Pendientes</label>
                <input id="pendientes" type="radio" name="filtro" value="0">
            </div>
        </div>
    </div>
    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>

<?php

$script .= '
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="build/js/tareas.js"></script>';
?>