<?php
include './seguridad.php'; 
$seguridad = new Seguridad($conexion, "ADMINISTRADOR");
$seguridad->init();

function headernav(){

?>  
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/websocketService.js?v=<?= rand() ?>"></script>

    <script>
/*
        async function listarNotificacionesPaciente(){
            try {
                const formData = new FormData();
                formData.append("method", "listarNotificacionesPaciente");
                formData.append("id", <?= $_SESSION['id'] ?>);

                const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/classNotificaciones.php", {
                    method: "post",
                    body: formData
                }), json = await response.json();

                return json;

            } catch (error) {
                console.log('error', error);
            }
        };

        async function actualizarNotificacionesLeidasNoLeidas(){
            try {

                if (document.getElementById("nuevasNotificaciones").style.display == "none") return;

                const formData = new FormData();
                formData.append("method", "actualizarNotificacionesLeidasNoLeidas");
                formData.append("id", <?= $_SESSION['id'] ?>);
                formData.append("estadoLeido", "SI");

                const response = await fetch("<?php echo $_ENV['APP_URL'];?>php/classNotificaciones.php", {
                    method: "post",
                    body: formData
                }), json = await response.json();
                
                await mostrarNotificaciones();
                return json;

            } catch (error) {
                console.log('error', error);
            }
        };

        async function mostrarNotificaciones(){
            const listaDeNotificaciones = await listarNotificacionesPaciente();

            // FILTRAMOS Y ORDEMANOS LAS NOTIFICACIONES DE FORMA ASCENDENTE
            const notificacionesOrdenadas = listaDeNotificaciones.filter((notificacion) => {
                return notificacion.tiempoSegundos;
            }).sort(function(a, b) {
                return a.tiempoSegundos - b.tiempoSegundos;
            });   

            // UNIMOS TODAS LAS NOTIFICACIONES YA ORDENADAS
            const notificacionesListas = [
                ...notificacionesOrdenadas, 
                ...listaDeNotificaciones.filter((n) => !n.tiempoSegundos)
            ];

            // FILTRAMOS Y MSOSTRAMOS LAS NOTIFICACIONES NO LEIDAS
            const notificacionesNoLeidas = (notificacionesListas.filter((notificacion) => notificacion.leido == "NO") || []);
            const _nuevasNotificaciones = document.getElementById("nuevasNotificaciones");
            if (notificacionesNoLeidas.length) {
                Object.assign(_nuevasNotificaciones.style, {display: "block"});
                _nuevasNotificaciones.innerHTML = `
                <p>
                    ${notificacionesNoLeidas.length}
                </p>`;
            } else {
                Object.assign(_nuevasNotificaciones.style, {display: "none"});
            }

            // FILTRAMOS LAS NOTIFICACIONES VENCIDAS YA QUE NO SE MUESTRAN
            document.getElementById("box-noti").innerHTML = notificacionesListas
            .filter(({start, estado}) => (new Date(start) >= new Date()))// SI NO ESTA VENCIDO
            .filter(({start, estado}) => !["CANCELADA"].includes(estado))
            .reduce((previousValue, currentValue) => {
                return previousValue + `<li><a href="<?php echo $_ENV['APP_URL'];?>cita/${currentValue.idupro}">
                    <p id="pnotif">${currentValue?.notificacion}<br>
                    <small><strong>${currentValue?.tiempo}</strong></small></p>
                </a></li>`;
            }, "");
        };


        window.addEventListener("DOMContentLoaded", async () => {

            await mostrarNotificaciones();

        });
*/
    </script>
    <header class="header" id="header">
        <div class="container-nav">
            <form method="POST" class="formulario__nav" id="formulario-nav">
                <span class="search"><i class="fa-solid fa-magnifying-glass" id="icon-search"></i></span>
                <input type="text" placeholder="Buscar en The Med Universe" name="buscapro" id="buscapro" value="" autocomplete="off">
            </form>
            <div class="sliders" id="idsliders"><i class="fa-solid fa-sliders" id="icon-sliders"></i></div>
            <h1><a href="<?php echo $_ENV['APP_URL'];?>activos" class="logo" id="logo">The Med Universe</a></h1>
            <nav class="navigation">
                <ul>
                    <li><a href="<?php echo $_ENV['APP_URL'];?>activos" class="house-medical"><i class="fa-solid fa-house-medical" id="house-medical"></i></a></li>

                    <li><a href="<?php echo $_ENV['APP_URL']; ?>inactivos" class="heart"><i class="fa-solid fa-circle-pause" id="heart"></i></a></li>

                    <li onclick="actualizarNotificacionesLeidasNoLeidas()" style="position: relative;">
                        <div id="nuevasNotificaciones">
                            
                        </div>
                        <a class="comment-medical"  id="i-noti"><i class="fa-solid fa-comment-medical" id="comment-medical"></i></a>
                        <ul id='box-noti'>
                        </ul>
                    </li>

                    <li><a class="caret-down" id="i-more"><i class="fa-solid fa-caret-down" id="caret-down"></i></a>
                        <ul id="more">
                            <li><a href="<?php echo $_ENV['APP_URL'].'perfiladmin/'.$_SESSION["idAdmin"]; ?>" class="i-profile" id="userprof"><i class="fa-solid fa-user" id="i-profile"><p>Mi perfil</p></i></a></li>
                            <li><a href="<?php echo $_ENV['APP_URL'];?>cerrar-sesionadmin" class="i-logout" id="cerrar-sesion"><i class="fa-solid fa-right-from-bracket" id="i-logout"><p>Cerrar sesión</p></i></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="box_filter">
        <form method="POST" class="formulario__filtro" id="formulario-filtro">
            <div class="ctn-profesion">
                <label><p>Género:</p></label>
                <div class="ctn-elegirpro">
                    <select name="ssexo" id="profesion">
                        <option class="select-opt" selected disabled>Género</option>
                        <?php 

                        include 'conexion_paciente.php';

                        $selectm = "SELECT distinct sexopro FROM usuariospro";
                        $ejecutar = mysqli_query($conexion,$selectm) or die(mysqli_error($conexion));

                    ?>

                    <?php foreach ($ejecutar as $opciones): ?>

                        <option name="so" id="so" value="<?php echo $opciones['sexopro'] ?>"><?php echo $opciones['sexopro'] ?></option>

                    <?php endforeach?>
                    </select>
                </div>
            </div>
        
            <div class="ctn-especialidad">
                <label><p>Especialidad:</p></label>
                <div class="ctn-elegiresp">
                    <select name="sespecialidad" id="especialidad">
                        <option class="select-opt" selected disabled>Especialidad</option>
                    <?php 

                        include 'conexion_paciente.php';

                        $selectm = "SELECT distinct especialidad FROM usuariospro";
                        $ejecutar = mysqli_query($conexion,$selectm) or die(mysqli_error($conexion));

                    ?>

                    <?php foreach ($ejecutar as $opciones): ?>

                        <option name="so" id="so" value="<?php echo $opciones['especialidad'] ?>"><?php echo $opciones['especialidad'] ?></option>

                    <?php endforeach?>
                    </select>
                </div>
            </div>
            <div class="ctn-pais">
                <label><p>País:</p></label>
        
                <div class="ctn-elegirpais">
                    <select name="spais" id="pais">
                        <option class="select-opt" selected disabled>País</option>
                    <?php 

                        $selectm = "SELECT distinct paispro FROM usuariospro";
                        $ejecutar = mysqli_query($conexion,$selectm) or die(mysqli_error($conexion));
                    ?>

                    <?php foreach ($ejecutar as $opciones): ?>

                        <option value="<?php echo $opciones['paispro'] ?>"><?php echo $opciones['paispro'] ?></option>

                    <?php endforeach?>
                    </select>
                </div>
            </div>
            <div class="ctn-idioma">
                <label><p>Idioma:</p></label>
                <div class="ctn-elegiridi">
                    <select name="sidioma" id="idioma">
                        <option class="select-opt" selected disabled>Idioma</option>
                    <?php 


                        $selectm = "SELECT distinct idiomapro FROM usuariospro";
                        $ejecutar = mysqli_query($conexion,$selectm) or die(mysqli_error($conexion));

                    ?>

                    <?php foreach ($ejecutar as $opciones): ?>

                        <option value="<?php echo $opciones['idiomapro'] ?>"><?php echo $opciones['idiomapro'] ?></option>

                    <?php endforeach?>
                    </select>
                </div>
            </div>
            <div class="ctn-precio">
                <label><p>Precio:</p></label>
                <?php

                    $query = "SELECT MAX(precio) AS maxPrecio FROM usuariospro";
                    $result = mysqli_query($conexion,$query) or die(mysqli_error($conexion));

                    while ($row = $result->fetch_object()){
                        $precios = $row;
                    }
                
                ?>
                <div class="values">
                    <span id="range1">
                        0
                    </span> 
                    <span> &dash; </span>
                    <span id="range2">
                        100
                    </span> 
                </div>
                <div class="ctn-elegirpre">
                    <div class="slider-track"></div>
                    <input type="range" name="rangeStart" id="slider-1" oninput="slideOne()" min="0" max="<?= $precios->maxPrecio ?>" step="1" value="0">
                    <input type="range" name="rangeEnd" id="slider-2" oninput="slideTwo()" min="0" max="<?= $precios->maxPrecio ?>" step="1" value="<?= $precios->maxPrecio ?>">
                </div>
            </div>
            <button name="buscar" type="submit" id="busfilter">Buscar</button>
            <script src="<?php echo $_ENV['APP_URL'];?>js/range.js"></script>
        </form>
        </div>
    </header>
<?php
}
?>  