<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Agenda - The Med Universe | Paciente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/calendar.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>

<body id="body">
    <?php echo headernav();
    include './php/navbar.php'; ?>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/buscador.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/m&ob.js"></script>
    <main>
        <div class="ctn-fullc">
            <div class="container">
                <div class="ctn-editarpc">
                    <h2>AGENDA DE CITAS</h2>
                </div>
                <hr id="edit-pc">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-7">
                        <div id="CalendarioWeb"></div>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
            <script>
                async function initAgenda() {
                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/eventoss.php?id=<?php echo $id ?>");
                    const json = await response.json();

                    const calendar = $('#CalendarioWeb').fullCalendar('getCalendar');
                    // extend object (could be its own function, etc.)
                    calendar.refresh = function() {
                        calendar.removeEvents();
                        calendar.addEventSource(json);
                    }

                    // finish setting up calendar
                    calendar.refresh();
                }

                socket.on("cita", function(msg) {
                    initAgenda();
                });

                async function cancelarSolicitud() {

                    const {
                        isConfirmed
                    } = await Swal.fire({
                        title: 'Solicitud de cita',
                        text: "¿Estás seguro de cancelar tu solicitud de cita? No podrás revertir esta acción.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ff0800',
                        cancelButtonColor: '#0052d4',
                        confirmButtonText: 'Sí, cancelar',
                        cancelButtonText: 'No'
                    });

                    if (isConfirmed) {
                        const formData = new FormData();
                        formData.append("idcita", $("#idCita").val());

                        const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/cancelarSolicitudCita.php", {
                            method: "post",
                            body: formData
                        });
                        const text = await Swal.fire({
                            title: 'Solicitud de cita cancelada',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            socket.emit("cita", "cancelarSolicitud");
                            $('#exampleModal').modal('hide');
                            /* window.location.reload(); */
                        });
                    }
                }
            </script>
            <script>
                $(document).ready(async function() {


                    await new Promise((resolve) => {
                        if (!document.querySelector('[src="https://sdk.mercadopago.com/js/v2"]')) {
                            let script = document.createElement('script');
                            script.addEventListener('load', (e) => {
                                console.log('mercadopago is loading...');
                                resolve();
                            });
                            script.src = 'https://sdk.mercadopago.com/js/v2';
                            script.async = true;
                            document.body.appendChild(script);
                        }
                    });

                    await new Promise((resolve) => {
                        if (!document.querySelector('[src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.js"]')) {
                            let script = document.createElement('script');
                            script.addEventListener('load', (e) => {
                                console.log('fullcalendar is loading...');
                                resolve();
                            });
                            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.js';
                            script.async = true;
                            document.body.appendChild(script);
                        }
                    });

                    await new Promise((resolve) => {
                        if (!document.querySelector('[src="<?php echo $_ENV['APP_URL']; ?>js/es.js"]')) {
                            let script = document.createElement('script');
                            script.addEventListener('load', (e) => {
                                console.log('esCalendar is loading...');
                                resolve();
                            });
                            script.src = '<?php echo $_ENV['APP_URL']; ?>js/es.js';
                            script.async = true;
                            document.body.appendChild(script);
                        }
                    });

                    let params = new URLSearchParams(location.search);
                    if (params.get('ws') === "62c0e72bf038366388783650") {

                        socket.emit("cita", "pagarCita");

                        await new Promise((resolve) => {
                            setTimeout(() => resolve(true), 5000);
                        });
                        window.location.replace(`${window.location.origin}${window.location.pathname}`);
                    }


                    const MERCADO_PAGO = new MercadoPago('TEST-585234f9-d099-4007-99ad-cdbb0757471b', {
                        locale: 'es-PE'
                    });

                    async function send({
                        idcita
                    }) {
                        const formData = new FormData();
                        formData.append("idcita", idcita);
                        formData.append("url", "agenda");

                        const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/test.php", {
                            method: "post",
                            body: formData,
                        });

                        const {
                            id
                        } = await response.json();

                        document.querySelector(".checkout-btn").innerHTML = "";

                        MERCADO_PAGO.checkout({
                            preference: {
                                id
                            },
                            render: {
                                container: '.checkout-btn',
                                label: 'Pagar con Tarjeta',
                            },
                        });

                    }

                    const $checkoutBtn = $("#btnpago");
                    $checkoutBtn.css('visibility', 'hidden');

                    $('#CalendarioWeb').fullCalendar({
                        events: '<?php echo $_ENV['APP_URL']; ?>php/eventoss.php?id=<?php echo $id ?>',
                        eventClick: async function(calEvent, jsEvent, view) {

                            const titulos = [
                                "Programada... Únete con el link en la fecha y hora correspondientes."
                            ];
                            $cancelarSolicitud = $("#cancelarSolicitud");
                            if (titulos.includes(calEvent.title)) {
                                $cancelarSolicitud.css('visibility', 'hidden');
                            } else {
                                $cancelarSolicitud.css('visibility', 'visible');
                            }

                            if (calEvent.sexoMedico == 'Femenino') {
                                var doctor = [
                                    "Dra."
                                ];
                            } else {
                                var doctor = [
                                    "Dr."
                                ];
                            }

                            if (calEvent.title == "<?= $_ENV['CITA_ENVIADA'] ?>") {
                                var titcita = [
                                    "SOLICITUD DE CITA ENVIADA"
                                ];
                            } else if (calEvent.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
                                var titcita = [
                                    "SOLICITUD DE CITA CONFIRMADA"
                                ];
                            } else if (calEvent.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
                                var titcita = [
                                    "CITA PROGRAMADA"
                                ];
                            } else if (calEvent.title == "<?= $_ENV['CITA_VENCIDA'] ?>") {
                                var titcita = [
                                    "CITA VENCIDA"
                                ];
                            }
                            var psico = [
                                calEvent.especialidad
                            ];
                            var idpac = [
                                calEvent.id
                            ];
                            if (calEvent.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
                                $('#informes').css('display', 'flex');
                            } else {
                                $('#informes').css('display', 'none');
                            }
                            $('#pasistencia').html(calEvent.asistencia);
                            $('#pasistenciapac').html(calEvent.asistenciapac);
                            $("#idCita").val(calEvent.idcita);
                            $('#tituloEvento').html(`${titcita}`);
                            $('#titEvento').html(calEvent.title);
                            $('#nombrecita').html(`${calEvent.nombresPaciente} ${calEvent.apellidosPaciente}`);
                            $('#nombreprocita').html(`${doctor} ${calEvent.nombresMedico} ${calEvent.apellidosMedico}`);
                            $('#profcita').html(`${psico}`);
                            $('#preciocita').html(`S/ ${calEvent.localizacion}`);
                            $('#bcfiled2').attr('href', 'https://www.themeduniverse.com/hclinica/' + idpac + '/' + calEvent.idpay);
                            if (calEvent.asistencia != "No asistió" && calEvent.asistenciapac != "No asistió") {
								$('#bcfiled2').css('display', 'block');
							} else {
								$('#bcfiled2').css('display', 'none');
							}
                            $('#linkcita').html(calEvent.ubicacion);
                            $("#linkcita").click(function() {
                                window.open(calEvent.ubicacion, '_blank');
                            });

                            const [fecha, hora] = calEvent.start._i.split(" ");
                            const [tinicial, tfinal] = hora.split(":00");
                            $('#fechacita').html(`${moment(fecha).format('L')} a las ${tinicial}:00`);
                            if (calEvent.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
                                $cancelarSolicitud.css('display', 'none');
                            } else {
                                $cancelarSolicitud.css('display', 'block');
                            }
                            if (calEvent.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
                                $checkoutBtn.css('visibility', 'visible');
                                $checkoutBtn.css('display', 'block');
                            } else {
                                $checkoutBtn.css('visibility', 'hidden');
                                $checkoutBtn.css('display', 'none');
                            }

                            $("#exampleModal").modal();

                            const isConfirm = (calEvent.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>");
                            if (isConfirm) {
                                await send(calEvent);
                            }
                            $("#exampleModal").on("hidden.bs.modal", function() {
                                $('.modal-backdrop').css('background-color', 'transparent');
                                $('#modalPagar').modal('hide');
                            });
                        },
                    });
                });
            </script>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titEvento"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="confirmarcita">
                                <h5 class="modal-title" id="tituloEvento"></h5>
                                <hr>
                                <div id="descripcionEvento">
                                    <p><span>Paciente:</span>
                                    <p id="nombrecita"></p>
                                    </p><br>
                                    <p><span>Profesional:</span>
                                    <p id="nombreprocita"></p>
                                    </p><br>
                                    <p><span>Especialidad:</span>
                                    <p id="profcita"></p>
                                    </p><br>
                                    <p><span>Fecha y hora de cita:</span>
                                    <p id="fechacita"></p>
                                    </p><br>
                                    <p id="confprecio"><span>Precio de cita:</span>
                                    <p id="preciocita"></p>
                                    </p><br>
                                    <p id="urlcitap"><span>Link de cita: </span><a id="linkcita"></a></p>
                                    <input id="idCita" type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer infooter">
                            <div class="informes infodoble" id="informes">
                                <div class="dentroinforme">
                                    <div class="infinterno">
                                        <span style="margin-right:5px">Asistencia profesional:</span>
                                        <p id="pasistencia"></p>
                                    </div>
                                    <div class="infinterno">
                                        <span style="margin-right:5px">Asistencia paciente:</span>
                                        <p id="pasistenciapac"></p>
                                    </div>
                                </div>
                                <a href="<?php echo $_ENV['APP_URL']; ?>hclinica/" id="bcfiled2">Historia Clínica</a>
                            </div>
                            <!-- onClick="rechazarCita(event)" -->
                            <div class="historia4" id="btnpagar">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" id="btnpago" data-toggle="modal" data-target="#modalPagar" style="background:#00d418;border:1px solid #00d418;font-size:14px;font-weight:500;padding:8px 20px" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';">
                                    Pagar Cita
                                </button>

                                <!-- Modal -->
                                <div class="modal fade modpagar" id="modalPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modsegundo" role="document" id="msegundo">
                                        <div class="modal-content modtercero" id="mtercero">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pagarTitle">Pagar por Yape o Transferencia Directa</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="columnastmu">
                                                    <div class="columnasuno">
                                                        <p><span>Número de Cuenta BCP:</span><br>33575750511084</p><br>
                                                        <p><span>Código de Cuenta Interbancario:</span><br>00233517575051108485</p>
                                                        <hr id="hr-register">
                                                        <div class="filaregister">
                                                            <ul>
                                                                <li>Paga tu cita con cualquiera de estos métodos de pago:<br><br>1. Transferencia bancaria o interbancaria a cualquiera de los números de cuenta que se muestran.<br><br>2. Yape al código QR que aparece en la versión escritorio o al +51 986 206 045.<br><br>Recuerda enviarnos un correo o mensaje de WhatsApp con la imagen del comprobante de pago para actualizar la programación de tu cita.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="columnasdos">
                                                        <div class="columnasimg">
                                                            <img src="<?php echo $_ENV['APP_URL']; ?>images/Yape-TMU.jpg">
                                                        </div>
                                                        <br><a id="awsp" href="https://wa.me/51986206045?text=Hola%2C+realic%C3%A9+el+pago+de+mi+cita+y+adjunto+el+comprobante+de+pago+para+que+puedan+actualizar+su+programaci%C3%B3n.%F0%9F%98%80" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="checkout-btn"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="cancelarSolicitud" onclick="cancelarSolicitud()" class="btn btn-danger" id="botoncancelar" style="background:#ff0000;border:1px solid #ff0000;font-size:14px;font-weight:500;padding:8px 20px;border-radius:5px;" onmouseover="this.style.background='#e10800';this.style.border='1px solid #e10800';" onmouseout="this.style.background='#ff0000';this.style.border='1px solid #ff0000';">
                                Cancelar Cita
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php echo footermed(); ?>

</html>