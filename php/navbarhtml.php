<?php
include './seguridad.php';
$seguridad = new Seguridad($conexion, "PACIENTE");
$seguridad->init();

function headernav()
{
?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
    <script>
        const isLocal = [window.location.hostname, window.location.hostname].includes("localhost");
        const socket = io( /*isLocal ? "ws://localhost:7000" :*/ "wss://yocreoquesipuedohacerlo.com");

        function tiempoTranscurrido(fechaNotificacion) {

            const fechaNotificacionMilisegundos = (Date.parse(fechaNotificacion));

            const fechaActualMilisegundos = (Date.parse(moment().format("YYYY-MM-DD HH:mm:ss")));

            const segundos = Math.floor((fechaActualMilisegundos - fechaNotificacionMilisegundos) / 1000);
            const minutos = Math.floor(segundos / 60);
            const horas = Math.floor(minutos / 60);
            const dias = Math.floor(horas / 24);
            /*console.log('fechaNotificacion', fechaNotificacion);
            console.log('moment().format("YYYY-MM-DD HH:mm:ss")', moment().format("YYYY-MM-DD HH:mm:ss"));
            console.log('segundos', segundos);
            console.log('minutos', minutos);
            console.log('horas', horas);
            console.log('dias', dias);*/

            const myDate = [
                ['días', dias],
                ['horas', horas],
                ['minutos', minutos],
                ['segundos', segundos]
            ];

            const msg = {};
            for (const [key, value] of myDate) {

                if (value > 0) {
                    msg['nombre'] = key;
                    msg['cantidad'] = value;
                    break;
                }
            }

            if (msg.cantidad == '1' && msg.nombre == 'segundos') {
                msg.nombre = 'segundo';
            } else if (msg.cantidad == '1' && msg.nombre == 'minutos') {
                msg.nombre = 'minuto';
            } else if (msg.cantidad == '1' && msg.nombre == 'horas') {
                msg.nombre = 'hora';
            } else if (msg.cantidad == '1' && msg.nombre == 'días') {
                msg.nombre = 'día';
            }

            return `Hace ${msg.cantidad} ${msg.nombre}`;

        }
    </script>

    <script>
        function notification(message) {
            Notification.requestPermission().then((result) => {
                let n = new Notification("The Med Universe", {
                    icon: '../images/med-isfrgb.png',
                    body: message
                });
            });
        }

        async function initNav(msg) {
            if (!["eliminarFechasDesabilitadas", "registrarFechasDesabilitadas"].includes(msg)) {

                const notificacionesNoLeidas = await mostrarNotificaciones();
                notification(`Tiene ${notificacionesNoLeidas} notificaciones no leídas.`);
            }
        }

        async function listarNotificacionesComentariosPaciente() {
            const formData = new FormData();
            formData.append("method", "listarNotificacionesComentariosPaciente");
            formData.append("id", <?= $_SESSION['id'] ?>);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                    method: "post",
                    body: formData
                }),
                json = await response.json();


            const listaDeComentariosMap = json.map(({
                comentarios,
                ...others
            }) => {

                const comentariosArray = JSON.parse(comentarios) || [];
                return {
                    ...others,
                    comentarios: comentariosArray.filter((comentario) => {
                        const comentarioObject = JSON.parse(comentario) || {};
                        return (comentarioObject.esMedicoOPaciente == "MEDICO");
                    }).map((comentario) => {
                        const comentarioObject = JSON.parse(comentario) || {};
                        const fechaActualMilisegundos = (Date.parse(moment().format("YYYY-MM-DD HH:mm:ss")));
                        const fechaNotificacionMilisegundos = (Date.parse(comentarioObject.fecha));

                        return {
                            ...comentarioObject,
                            notificacion: `<span class='spanbolder'>Respuesta a Comentario:</span> "${comentarioObject.comentario}"<br><span class='spanbolder'>Profesional:</span> ${comentarioObject.nombres}`,
                            tiempo: tiempoTranscurrido(comentarioObject.fecha),
                            tiempoSegundos: ((fechaActualMilisegundos - fechaNotificacionMilisegundos) / 1000),
                            respuestaDeMedico: true
                        };
                    })
                };
            });

            const listaDeComentariosReducer = listaDeComentariosMap.reduce((previousValue, currentValue) => {
                return [...previousValue, ...currentValue.comentarios];
            }, []).filter((comentario) => {
                // DESDE AQUI FILTRAMOS SOLO LAS NOTIFICACIONES DE COMENTARIOS HACE MENOS DE UNA SEMANA
                const fechaActualMilisegundosMenos7Dias = (Date.parse(moment().subtract(30, 'days').format("YYYY-MM-DD hh:mm:ss")));
                const fechaNotificacionMilisegundos = (Date.parse(comentario.fecha));

                return (fechaNotificacionMilisegundos > fechaActualMilisegundosMenos7Dias);
            });

            console.log('listaDeComentariosReducer', listaDeComentariosReducer)
            return listaDeComentariosReducer;

        }

        socket.on("notificaciones", initNav);


        window.addEventListener("DOMContentLoaded", async function() {

            /* _websocketService.ws.addEventListener("message", async function(e) {

                const eventName = await new Promise((resolve) => {

                    const reader = new FileReader();
                    // This fires after the blob has been read/loaded.
                    reader.addEventListener('loadend', (e) => {
                        const text = e.srcElement.result;
                        resolve(text);
                    });

                    // Start reading the blob as text.
                    reader.readAsText(e.data);

                });

                if (!["eliminarFechasDesabilitadas", "registrarFechasDesabilitadas"].includes(eventName)) {
                    const notificacionesNoLeidas = await mostrarNotificaciones();
                    notification(`Tiene ${notificacionesNoLeidas} notificaciones no leídas.`);
                }

            }); */
        });
    </script>

    <script>
        async function listarNotificacionesPaciente() {
            try {
                const formData = new FormData();
                formData.append("method", "listarNotificacionesPaciente");
                formData.append("id", <?= $_SESSION['id'] ?>);

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();

                return json;

            } catch (error) {
                console.log('error', error);
            }
        };

        async function actualizarNotificacionesLeidasNoLeidas() {
            try {

                if (document.getElementById("nuevasNotificaciones").style.display == "none") return;

                const formData = new FormData();
                formData.append("method", "actualizarNotificacionesLeidasNoLeidas");
                formData.append("id", <?= $_SESSION['id'] ?>);
                formData.append("estadoLeido", "SI");

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();

                await mostrarNotificaciones();
                return json;

            } catch (error) {
                console.log('error', error);
            }
        };

        async function mostrarNotificaciones() {
            const listaDeNotificaciones = await listarNotificacionesPaciente();

            const mapNotificacionesPaciente = await listarNotificacionesComentariosPaciente();
            /* console.log('mapNotificacionesPaciente', mapNotificacionesPaciente) */
            /* const mapNotificacionesPaciente = nuevasNotificacionesPaciente.map((comentarioObject) => {

                const fechaActualMilisegundos = (Date.parse(moment().format("YYYY-MM-DD HH:mm:ss")));
                const fechaNotificacionMilisegundos = (Date.parse(comentarioObject.fecha));
                return {
                    ...comentarioObject,
                    notificacion: `<span class='spanbolder'>Respuesta Comentario:</span> "${comentarioObject.comentario}"<br><span class='spanbolder'>Médico:</span> ${comentarioObject.nombres}.`,
                    tiempo: tiempoTranscurrido(comentarioObject.fecha),
                    tiempoSegundos: ((fechaActualMilisegundos - fechaNotificacionMilisegundos) / 1000),
                }
            }); */

            // FILTRAMOS Y ORDEMANOS LAS NOTIFICACIONES DE FORMA ASCENDENTE
            const notificacionesOrdenadas = [...listaDeNotificaciones, ...mapNotificacionesPaciente].filter((notificacion) => {
                return notificacion.tiempoSegundos;
            }).sort(function(a, b) {
                return a.tiempoSegundos - b.tiempoSegundos;
            });
            /* console.log('notificacionesOrdenadas', notificacionesOrdenadas) */
            // UNIMOS TODAS LAS NOTIFICACIONES YA ORDENADAS
            const notificacionesListas = [
                /* ...mapNotificacionesPaciente, */
                ...notificacionesOrdenadas,
                ...listaDeNotificaciones.filter((n) => !n.tiempoSegundos)
            ];

            // FILTRAMOS Y MSOSTRAMOS LAS NOTIFICACIONES NO LEIDAS
            const notificacionesNoLeidas = (notificacionesListas.filter((notificacion) => notificacion.leido == "NO" || notificacion.visto == "NO") || []);
            const _nuevasNotificaciones = document.getElementById("nuevasNotificaciones");
            if (notificacionesNoLeidas.length) {
                Object.assign(_nuevasNotificaciones.style, {
                    display: "block"
                });
                _nuevasNotificaciones.innerHTML = `
                <p>
                    ${notificacionesNoLeidas.length}
                </p>`;
            } else {
                Object.assign(_nuevasNotificaciones.style, {
                    display: "none"
                });
            }

            // FILTRAMOS LAS NOTIFICACIONES VENCIDAS YA QUE NO SE MUESTRAN
            document.getElementById("box-noti").innerHTML = notificacionesListas
                /* .filter(({start, estado}) => (new Date(start) >= new Date()))// SI NO ESTA VENCIDO */
                .filter(({
                    start,
                    estado
                }) => !["CANCELADA"].includes(estado))
                .reduce((previousValue, currentValue) => {
                    /* console.log('currentValue', currentValue) */
                    let urlNotificacion;
                    if (currentValue?.respuestaDeMedico) {
                        urlNotificacion = `<li><a href="<?php echo $_ENV['APP_URL']; ?>perfilproo/${currentValue.idUser}">
                            <p id="pnotif">${currentValue?.notificacion}<br>
                            <small><strong>${currentValue?.tiempo}</strong></small></p>
                        </a></li>`;
                    } else {
                        urlNotificacion = `<li><a href="<?php echo $_ENV['APP_URL']; ?>agenda/${currentValue.id}">
                            <p id="pnotif">${currentValue?.notificacion}<br>
                            <small><strong>${currentValue?.tiempo}</strong></small></p>
                        </a></li>`;
                    }
                    return previousValue + urlNotificacion;
                }, "");

            return notificacionesNoLeidas.length;
        };


        async function verificarCitasProgramadas10MinutosAntes() {
            const formData = new FormData();
            formData.append("method", "verificarCitasProgramadas10MinutosAntes");
            formData.append("id", <?= $_SESSION['id'] ?>);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                method: "post",
                body: formData
            });
            const numeroCitas = await response.text();

            return Number(numeroCitas);
        }


        window.addEventListener("DOMContentLoaded", async () => {

            await mostrarNotificaciones();

            // VERIFICAR Y NOTIFICAR CITAS PROGRAMADAS FALTANDO 10 MINUTOS
            /* let showNotification = true;
            setInterval(async () => {
                const citasEn10 = await verificarCitasProgramadas10MinutosAntes();
                if (citasEn10 > 0) {
                    if (showNotification) {
                        notification('Tu cita empezará en 10 minutos.');
                        showNotification = false;

                        setTimeout(() => {
                            showNotification = true;
                        }, 240000);
                    }
                }
            }, 3000); */

            var source = new EventSource("<?php echo $_ENV['APP_URL']; ?>actualizarCitasVencidas.php");
            source.onmessage = function(event) {
                /* console.log('event.data', JSON.parse(event.data)); */
                if (event.data > 0) {
                    /* notification("en 10 min pasa algo ...!!") */
                    socket.emit("cita", "actualizarCitasVencidas");
                    /* Swal.fire({
                        title: 'Solicitud de Cita Cancelada',
                        text: 'La fecha de tu solicitud de cita ha expirado, selecciona otra fecha disponible.',
                        icon: 'error',
                        confirmButtonColor: '#0052d4',
                        confirmButtonText: 'Ok',
                    }).then(() => {
                        window.location.reload();
                    }); */
                } else {
                    console.log('sse', 'nada que actualizar...');
                }

            };
            /* source.onerror = function(error) {
                console.log('error', error);
            };
            source.onopen = function(event) {
                console.log('open', event);
            }; */

        });
    </script>
    <header class="header" id="header">
        <div class="container-nav">
            <form method="POST" class="formulario__nav" id="formulario-nav">
                <span class="search"><i class="fa-solid fa-magnifying-glass" id="icon-search"></i></span>
                <input type="text" placeholder="Buscar en The Med Universe" name="buscapro" id="buscapro" value="" autocomplete="off">
            </form>
            <div class="sliders" id="idsliders"><i class="fa-solid fa-sliders" id="icon-sliders"></i></div>
            <h1><a href="<?php echo $_ENV['APP_URL']; ?>home" class="logo" id="logo">The Med Universe</a></h1>
            <nav class="navigation">
                <ul>
                    <li><a href="<?php echo $_ENV['APP_URL']; ?>home" class="house-medical"><i class="fa-solid fa-house-medical" id="house-medical"></i></a></li>
                    <li><a href="<?php echo $_ENV['APP_URL']; ?>favoritos" class="heart"><i class="fa-solid fa-heart-pulse" id="heart"></i></a></li>

                    <li onclick="actualizarNotificacionesLeidasNoLeidas()" style="position: relative;">
                        <div id="nuevasNotificaciones">

                        </div>
                        <a class="comment-medical" id="i-noti"><i class="fa-solid fa-comment-medical" id="comment-medical"></i></a>
                        <ul id='box-noti'>
                        </ul>
                    </li>

                    <li><a class="caret-down" id="i-more"><i class="fa-solid fa-caret-down" id="caret-down"></i></a>
                        <ul id="more">
                            <li><a href="<?php echo $_ENV['APP_URL'] . 'perfil/' . $_SESSION["id"]; ?>" class="i-profile" id="userprof"><i class="fa-solid fa-user" id="i-profile">
                                        <p>Mi perfil</p>
                                    </i></a></li>
                            <li><a href="<?php echo $_ENV['APP_URL']; ?>cerrar-sesion" class="i-logout" id="cerrar-sesion"><i class="fa-solid fa-right-from-bracket" id="i-logout">
                                        <p>Cerrar sesión</p>
                                    </i></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="box_filter">
            <form method="POST" class="formulario__filtro" id="formulario-filtro">
                <div class="ctn-profesion">
                    <label>
                        <p>Género:</p>
                    </label>
                    <div class="ctn-elegirpro">
                        <select name="ssexo" id="profesion">
                            <option class="select-opt" selected disabled>Género</option>
                            <?php

                            include 'conexion_paciente.php';

                            $selectm = "SELECT distinct sexopro FROM usuariospro where estado = '1'";
                            $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                            ?>

                            <?php foreach ($ejecutar as $opciones) : ?>

                                <option name="so" id="so" value="<?php echo $opciones['sexopro'] ?>"><?php echo $opciones['sexopro'] ?></option>

                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="ctn-especialidad">
                    <label>
                        <p>Especialidad:</p>
                    </label>
                    <div class="ctn-elegiresp">
                        <select name="sespecialidad" id="especialidad">
                            <option class="select-opt" selected disabled>Especialidad</option>
                            <?php

                            include 'conexion_paciente.php';

                            $selectm = "SELECT distinct especialidad FROM usuariospro where estado = '1'";
                            $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                            ?>

                            <?php foreach ($ejecutar as $opciones) : ?>

                                <option name="so" id="so" value="<?php echo $opciones['especialidad'] ?>"><?php echo $opciones['especialidad'] ?></option>

                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="ctn-pais">
                    <label>
                        <p>País:</p>
                    </label>

                    <div class="ctn-elegirpais">
                        <select name="spais" id="pais">
                            <option class="select-opt" selected disabled>País</option>
                            <?php

                            $selectm = "SELECT distinct paispro FROM usuariospro where estado = '1'";
                            $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));
                            ?>

                            <?php foreach ($ejecutar as $opciones) : ?>

                                <option value="<?php echo $opciones['paispro'] ?>"><?php echo $opciones['paispro'] ?></option>

                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="ctn-idioma">
                    <label>
                        <p>Idioma:</p>
                    </label>
                    <div class="ctn-elegiridi">
                        <select name="sidioma" id="idioma">
                            <option class="select-opt" selected disabled>Idioma</option>
                            <?php


                            $selectm = "SELECT distinct idiomapro FROM usuariospro where estado='1'";
                            $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                            ?>

                            <?php foreach ($ejecutar as $opciones) : ?>

                                <option value="<?php echo $opciones['idiomapro'] ?>"><?php echo $opciones['idiomapro'] ?></option>

                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="ctn-precio">
                    <label>
                        <p>Precio:</p>
                    </label>
                    <?php

                    $query = "SELECT MAX(precio) AS maxPrecio, MIN(precio) AS minPrecio FROM usuariospro WHERE estado = '1'";
                    $result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

                    while ($row = $result->fetch_object()) {
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
                        <input type="range" name="rangeStart" id="slider-1" oninput="slideOne()" min="<?= $precios->minPrecio ?>" max="<?= $precios->maxPrecio ?>" step="1" value="<?= $precios->minPrecio ?>">
                        <input type="range" name="rangeEnd" id="slider-2" oninput="slideTwo()" min="<?= $precios->minPrecio ?>" max="<?= $precios->maxPrecio ?>" step="1" value="<?= $precios->maxPrecio ?>">
                    </div>
                </div>
                <button name="buscar" type="submit" id="busfilter">Buscar</button>
                <script src="<?php echo $_ENV['APP_URL']; ?>js/range.js"></script>
            </form>
        </div>
    </header>
<?php
}
?>