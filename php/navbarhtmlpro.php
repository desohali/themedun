<?php
include './seguridad.php';
$seguridad = new Seguridad($conexion, "MEDICO");
$seguridad->init();

function headernav()
{
?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script>
        /* const isLocal = [window.location.hostname, window.location.hostname].includes("localhost"); */
        const socket = io( /* isLocal ? "ws://localhost:7000" :  */ "wss://yocreoquesipuedohacerlo.com");
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
                const todasLasNotificaciones = await mostrarNotificaciones();
                notification(`Tiene ${todasLasNotificaciones} notificaciones no leídas.`);
            }
        }

        socket.on("notificaciones", initNav);

        window.addEventListener("DOMContentLoaded", function() {
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
                    const todasLasNotificaciones = await mostrarNotificaciones();
                    notification(`Tiene ${todasLasNotificaciones} notificaciones no leídas.`);
                }
            }); */
        });
    </script>

    <script>
        async function listarNotificacionesMedico() {
            try {
                const formData = new FormData();
                formData.append("method", "listarNotificacionesMedico");
                formData.append("idupro", <?= $_SESSION['idpro'] ?>);

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();

                return json;

            } catch (error) {
                //R console.log('error', error);
            }
        };

        async function listarNotificationesDeAbonosAlMedico() {
            try {
                const formData = new FormData();
                formData.append("method", "listarNotificationesDeAbonosAlMedico");
                formData.append("idupro", <?= $_SESSION['idpro'] ?>);

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();

                return json;

            } catch (error) {
                //R console.log('error', error);
            }
        };

        async function actualizarNotificacionesLeidasNoLeidasPro() {
            try {

                if (document.getElementById("nuevasNotificaciones").style.display == "none") return;

                const formData = new FormData();
                formData.append("method", "actualizarNotificacionesLeidasNoLeidasPro");
                formData.append("idupro", <?= $_SESSION['idpro'] ?>);
                formData.append("estadoLeido", "SI");

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();

                await mostrarNotificaciones();
                return json;

            } catch (error) {
                //R console.log('error', error);
            }
        };

        function tiempoTranscurrido(fechaNotificacion) {

            const fechaNotificacionMilisegundos = (Date.parse(fechaNotificacion));
            
            const fechaActualMilisegundos = (Date.parse(moment().format("YYYY-MM-DD HH:mm:ss")));
            
            const segundos = Math.floor((fechaActualMilisegundos - fechaNotificacionMilisegundos) / 1000);
            const minutos = Math.floor(segundos / 60);
            const horas = Math.floor(minutos / 60);
            const dias = Math.floor(horas / 24);

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

            if(msg.cantidad=='1' && msg.nombre=='segundos'){
                msg.nombre='segundo';
            }else if(msg.cantidad=='1' && msg.nombre=='minutos'){
                msg.nombre='minuto';
            }else if(msg.cantidad=='1' && msg.nombre=='horas'){
                msg.nombre='hora';
            }else if(msg.cantidad=='1' && msg.nombre=='días'){
                msg.nombre='día';
            }

            return `Hace ${msg.cantidad} ${msg.nombre}`;

        }

        async function mostrarNotificaciones() {
            const listaDeNotificaciones = await listarNotificacionesMedico();
            const listaDeNotificacionesAbonos = await listarNotificationesDeAbonosAlMedico();
            const listaDeValoraciones = await listarNotificacionesValoracionMedico();
            const listaDeComentarios = await listarNotificacionesComentariosMedico();
            //R console.log('listaDeNotificacionesAbonos', listaDeNotificacionesAbonos);

            const listaDeComentariosMap = listaDeComentarios.map(({
                comentarios,
                ...others
            }) => {

                const comentariosArray = JSON.parse(comentarios) || [];
                return {
                    ...others,
                    comentarios: comentariosArray.filter((comentario) => {
                        const comentarioObject = JSON.parse(comentario) || {};
                        return (comentarioObject.esMedicoOPaciente == "PACIENTE");
                    }).map((comentario) => {
                        const comentarioObject = JSON.parse(comentario) || {};
                        const fechaActualMilisegundos = (Date.parse(moment().format("YYYY-MM-DD HH:mm:ss")));
                        const fechaNotificacionMilisegundos = (Date.parse(comentarioObject.fecha));

                        return {
                            ...comentarioObject,
                            notificacion: `<span class='spanbolder'>Nuevo Comentario:</span> "${comentarioObject.comentario}"<br><span class='spanbolder'>Paciente:</span> ${comentarioObject.nombres}`,
                            tiempo: tiempoTranscurrido(comentarioObject.fecha),
                            tiempoSegundos: ((fechaActualMilisegundos - fechaNotificacionMilisegundos) / 1000),
                        };
                    })
                };
            });

                //R console.log('listaDeComentariosMap', listaDeComentariosMap);
            const listaDeComentariosReducer = listaDeComentariosMap.reduce((previousValue, currentValue) => {
                return [...previousValue, ...currentValue.comentarios];
            }, []).filter((comentario) => {
                // DESDE AQUI FILTRAMOS SOLO LAS NOTIFICACIONES DE COMENTARIOS HACE MENOS DE UNA SEMANA
                const fechaActualMilisegundosMenos7Dias = (Date.parse(moment().subtract(30, 'days').format("YYYY-MM-DD hh:mm:ss")));
                const fechaNotificacionMilisegundos = (Date.parse(comentario.fecha));

                return (fechaNotificacionMilisegundos > fechaActualMilisegundosMenos7Dias);
            });

            // FILTRAMOS Y ORDEMANOS LAS NOTIFICACIONES DE FORMA ASCENDENTE
            const notificacionesOrdenadas = listaDeNotificaciones.filter((notificacion) => {
                return notificacion.tiempoSegundos;
            })
            /* .sort(function(a, b) {
                            return a.tiempoSegundos - b.tiempoSegundos;
                        }); */

            // UNIMOS TODAS LAS NOTIFICACIONES YA ORDENADAS
            const notificacionesListas = [
                ...notificacionesOrdenadas,
                ...listaDeNotificaciones.filter((n) => !n.tiempoSegundos)
            ];


            // FILTRAMOS Y MSOSTRAMOS LAS NOTIFICACIONES NO LEIDAS
            const notificacionesNoLeidas = (notificacionesListas.filter((notificacion) => notificacion.leidopro == "NO") || []);
            const valoracionesNoLeidas = (listaDeValoraciones.filter((valoracion) => valoracion.leido == "NO") || []);
            const notificacionesAbonosNoLeidas = (listaDeNotificacionesAbonos.filter((abono) => abono.leidoabono == "NO") || []);
            const todasLasNotificaciones = [
                ...notificacionesAbonosNoLeidas,
                ...notificacionesNoLeidas,
                ...valoracionesNoLeidas,
                ...listaDeComentariosReducer.filter((comentario) => comentario.leido == "NO"),
            ];
            

            const _nuevasNotificaciones = document.getElementById("nuevasNotificaciones");
            if (todasLasNotificaciones.length) {
                Object.assign(_nuevasNotificaciones.style, {
                    display: "block"
                });
                _nuevasNotificaciones.innerHTML = `
                <p>
                    ${todasLasNotificaciones.length}
                </p>`;
            } else {
                Object.assign(_nuevasNotificaciones.style, {
                    display: "none"
                });
            }

            // FILTRAMOS LAS NOTIFICACIONES VENCIDAS YA QUE NO SE MUESTRAN
            const notificacionesFilter = notificacionesListas
                .filter(({
                    start,
                    estado
                }) => !["RECHAZADA"].includes(estado));


            /* console.log('t', t) */
            const todasLasNotificacionesOredenadas = [
                    ...notificacionesFilter,
                    // EN EL CASO DE VALORACIONES AGREGAMOS SU tiempoSegundos
                    ...listaDeValoraciones.map((valoracion) => {
                        const fechaActualMilisegundos = (Date.parse(moment().format("YYYY-MM-DD HH:mm:ss")));
                        const fechaNotificacionMilisegundos = (Date.parse(valoracion.fechanoti));

                        const tiempoSegundos = ((fechaActualMilisegundos - fechaNotificacionMilisegundos) / 1000);
                        
                        return {
                            ...valoracion,
                            tiempoSegundos
                        };
                    }),
                    ...listaDeComentariosReducer,
                    ...listaDeNotificacionesAbonos,
                ]
                .sort(function(a, b) {
                    return a.tiempoSegundos - b.tiempoSegundos;
                });

            document.getElementById("box-noti").innerHTML = todasLasNotificacionesOredenadas
                .reduce((previousValue, currentValue) => {

                    let html = '<li>';

                    let href = "<?= $_ENV['APP_URL'] ?>";

                    if (
                        currentValue?.idupro && ["0", undefined].includes(currentValue?.valoracion) &&
                        !currentValue?.notidicacionDeAbono
                    ) {
                        href += `horario/${currentValue.idupro}`;
                    } else if (currentValue?.notidicacionDeAbono) {
                        href += "historialpro/<?= $_SESSION['idpro'] ?>";
                    } else {
                        href += "perfilpro/<?= $_SESSION['idpro'] ?>";
                    }

                    html += `<a href="${href}">`;

                    if (currentValue?.notificacion) {
                        html += `<p id="pnotif">${currentValue?.notificacion}<br>`;
                    }

                    if (currentValue?.tiempo) {
                        html += `<small><strong>${currentValue?.tiempo}</strong></small>`;
                    }

                    html += '</p></a>';
                    html += '</li>';

                    return `${previousValue} ${html}`;
                }, "");


            return todasLasNotificaciones.length;
        }


        async function verificarCitasProgramadas10MinutosAntes() {
            const formData = new FormData();
            formData.append("method", "verificarCitasProgramadas10MinutosAntes");
            formData.append("idpro", <?= $_SESSION['idpro'] ?>);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                method: "post",
                body: formData
            });
            const numeroCitas = await response.text();

            return Number(numeroCitas);
        }

        window.addEventListener("DOMContentLoaded", async () => {

            await mostrarNotificaciones();
            /* await listarNotificacionesComentariosMedico(); */

            // VERIFICAR Y NOTIFICAR CITAS PROGRAMADAS FALTANDO 10 MINUTOS
            /* let showNotification = true;
            setInterval(async () => {
                const citasEn10 = await verificarCitasProgramadas10MinutosAntes();
                if (citasEn10 > 0) {
                    if (showNotification) {
                        notification('Su cita empezará en 10 minutos.');
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
                    //R console.log('sse', 'nada que actualizar...');
                }

            };

        });

        async function listarNotificacionesValoracionMedico() {
            try {
                const formData = new FormData();
                formData.append("method", "listarNotificacionesValoracionMedico");
                formData.append("idupro", <?= $_SESSION['idpro'] ?>);

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();
                //R console.log('json', json)
                return json;

            } catch (error) {
                //R console.log('error', error);
            }
        }

        async function listarNotificacionesComentariosMedico() {
            try {
                const formData = new FormData();
                formData.append("method", "listarNotificacionesComentariosMedico");
                formData.append("idupro", <?= $_SESSION['idpro'] ?>);

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
                        method: "post",
                        body: formData
                    }),
                    json = await response.json();
                return json;

            } catch (error) {
                //R console.log('error', error);
            }
        }
    </script>
    <header class="header" id="header">
        <div class="container-nav">
            <h1><a href="<?php echo $_ENV['APP_URL']; ?>perfilpro/<?php echo $_SESSION["idpro"]; ?>" class="logo" id="logo">The Med Universe</a></h1>
            <nav class="navigation" id="navigation">
                <ul>
                    <li onclick="actualizarNotificacionesLeidasNoLeidasPro()" style="position: relative;">
                        <div id="nuevasNotificaciones">

                        </div>
                        <a class="comment-medical" id="i-noti"><i class="fa-solid fa-comment-medical" id="comment-medical"></i></a>
                        <ul id='box-noti'>
                        </ul>
                    </li>
                    <!-- <li>
                        <a class="comment-medical"  id="i-noti">
                            <i class="fa-solid fa-comment-medical" id="comment-medical"></i>
                        </a>
                        <ul id='box-noti'>
                        </ul>
                    </li> -->
                    <li><a class="caret-down" id="i-more"><i class="fa-solid fa-caret-down" id="caret-down"></i></a>
                        <ul id="more">
                            <li><a href="<?php echo $_ENV['APP_URL']; ?>perfilpro/<?php echo $_SESSION["idpro"]; ?>" class="i-profile" id="userprof"><i class="fa-solid fa-user" id="i-profile">
                                        <p>Mi perfil</p>
                                    </i></a></li>
                            <li><a href="<?php echo $_ENV['APP_URL']; ?>cerrar-sesionpro" class="i-logout" id="cerrar-sesion"><i class="fa-solid fa-right-from-bracket" id="i-logout">
                                        <p>Cerrar sesión</p>
                                    </i></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
<?php
}
?>