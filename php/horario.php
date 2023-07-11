<?php
$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_GET['id']) && @$_SESSION['idpro'] == @$_GET['id']) {
    $consulta = "SELECT * FROM usuariospro WHERE idpro = '" . $_GET['id'] . "' ";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        while ($row = $resultado->fetch_array()) {
            $idpro = $row['idpro'];
            $nombrespro = $row['nombrespro'];
            $apellidospro = $row['apellidospro'];
            $correopro = $row['correopro'];
            $nacimientopro = $row['nacimientopro'];
            $sexopro = $row['sexopro'];
            $paispro = $row['paispro'];
            $ciudadpro = $row['ciudadpro'];
            $idiomapro = $row['idiomapro'];
            $enmu = $row['enmu'];
            $colegiatura = $row['colegiatura'];
            $especialidad = $row['especialidad'];
            $precio = $row['precio'];
            $estadoMedico = $row['estado'];
            $fotoperfilpro = $row['fotoperfilpro'];
            if ($sexopro == "Femenino") {
                $doctor = "Dra.";
            } else {
                $doctor = "Dr.";
            }
            if (@$estadoMedico != 1) {
                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                echo $url . "perfilpro/" . $_SESSION['idpro'] . "'</script>";
            }
        }
    }
} else {
    //header("Location: " . $_ENV['APP_URL'] . "horario/" . $_SESSION['idpro']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "horario/" . $_SESSION['idpro'] . "'</script>";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Horario y Agenda - The Med Universe | Profesional</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/navpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/horario.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/calendar.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/calendarpro.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <style>
    .accordion-item {
      margin-bottom: 10px;
    }
    .accordion-heading {
      background-color: #f8f9fa;
      padding: 10px;
      cursor: pointer;
    }
    .accordion-content {
      display: none;
      padding: 10px;
    }
  </style>
</head>

<body id="body">
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <?php echo headernav() ?>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/m&obpro.js"></script>
    <script>
        var DATA_FULLCALENDAR = [];
        var DATA_FULLCALENDAR_DISABLED = [];

        async function init() {
            DATA_FULLCALENDAR = await listarCitasCreadas();
            DATA_FULLCALENDAR_DISABLED = await listarFechasDesabilitadas();

            const ALL_DATA = [...DATA_FULLCALENDAR, ...DATA_FULLCALENDAR_DISABLED.map((cita) => {
                return {
                    start: cita.startDate,
                    end: cita.endDate,
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                }
            })];

            const calendar = $('#CalendarioWeb').fullCalendar('getCalendar');
            // extend object (could be its own function, etc.)
            calendar.refresh = function() {
                calendar.removeEvents();
                calendar.addEventSource(ALL_DATA);
            }

            // finish setting up calendar
            calendar.refresh();
        }

        //R console.log('socket', socket);

        socket.on("cita", function(msg) {
            //R console.log('socket listener', 'socket listener')
            init();
        });


        const DATA_INICIAL = [{
                DIAS: ["HORA", "LUNES", "MARTES", "MIÉRCOLES", "JUEVES", "VIERNES", "SÁBADO", "DOMINGO"]
            },
            {
                DIAS: ["00:00 - 01:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["01:00 - 02:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["02:00 - 03:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["03:00 - 04:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["04:00 - 05:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["05:00 - 06:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["06:00 - 07:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["07:00 - 08:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["08:00 - 09:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["09:00 - 10:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["10:00 - 11:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["11:00 - 12:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["12:00 - 13:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["13:00 - 14:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["14:00 - 15:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["15:00 - 16:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["16:00 - 17:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["17:00 - 18:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["18:00 - 19:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["19:00 - 20:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["20:00 - 21:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["21:00 - 22:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["22:00 - 23:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
            {
                DIAS: ["23:00 - 24:00", [false, 1],
                    [false, 2],
                    [false, 3],
                    [false, 4],
                    [false, 5],
                    [false, 6],
                    [false, 7]
                ]
            },
        ];

        async function cambiarDisponibilidad(elininaroAniadir /* enum["ELIMINAR", "AÑADIR"] */ , numeroHora, numeroDia) {

            numeroHora = numeroHora.split("-");

            const [nHora] = numeroHora[1].split(":");
            const formData = new FormData();
            formData.append("ndia", numeroDia);
            formData.append("nhora", nHora);
            formData.append("idupro", <?php echo $idpro ?>);
            formData.append("accion", 'registrarHorarios');
            formData.append("elininaroAniadir", elininaroAniadir);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/registrarHorarios.php", {
                method: "post",
                body: formData
            });
            const text = await response.text();

            await listarDisponibilidad();

        }

        async function listarDisponibilidad() {

            const formData = new FormData();
            formData.append("idupro", <?php echo $idpro ?>);
            formData.append("accion", 'listarDisponibilidad');
            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/registrarHorarios.php", {
                method: "post",
                body: formData
            });
            const json = await response.json();

            const DATA_MAP = DATA_INICIAL.map(({
                DIAS
            }, i) => {
                if (i > 0) {
                    return {
                        DIAS: DIAS.map((HORA, e) => {
                            if (typeof HORA === "string") {
                                return HORA;
                            } else {
                                const [ESTADO, NUMERO_DIA] = HORA;
                                const find = json.find(({
                                    ndia,
                                    nhora
                                }) => {
                                    return (NUMERO_DIA == ndia && nhora == i);
                                });
                                return find ? [true, NUMERO_DIA] : HORA;
                            }
                        })
                    };
                } else {
                    return {
                        DIAS
                    };
                }
            });

            graficarTablaDeDisponibilidad(DATA_MAP);

        }

        function graficarTablaDeDisponibilidad(HORAS_DIAS) {
            let table = '<table>';
            for (const {
                    DIAS,
                    HORA
                }
                of HORAS_DIAS) {
                table += '<tr>';
                for (const DIA of DIAS) {
                    table += '<td>';
                    if (typeof DIA === "string") {
                        table += DIA;
                    } else {
                        const [ESTADO, NUMERO_DIA] = DIA;
                        if (ESTADO) {
                            table += `<div class="ctn-si" >
                                <label class="si">Disponible</label>
                                <label class="labelminus" for="minus" onclick="cambiarDisponibilidad('ELIMINAR', '${DIAS[0]}', '${NUMERO_DIA}')">
                                    <i class="fa-solid fa-square-minus"></i>
                                </label>
                            </div>`;
                        } else {
                            table += `<div class="ctn-no">
                                <label class="no">No disponible</label>
                                <label class="labelmas" for="mas" onclick="cambiarDisponibilidad('AÑADIR', '${DIAS[0]}', '${NUMERO_DIA}')">
                                    <i class="fa-solid fa-square-plus"></i>
                                </label>
                            </div>`;
                        }
                    }
                    table += '</td>';
                }
                table += '</tr>';
            }
            table += '</table>';

            document.getElementById('tablaPrueba').innerHTML = table;
        }

        async function listarFechasDesabilitadas() {
            const formData = new FormData();
            formData.append("idupro", <?php echo $idpro ?>);
            formData.append("method", 'listarFechasDesabilitadas');
            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classDesabilitarAtencionMedica.php", {
                method: "post",
                body: formData
            });
            const json = await response.json();

            return json;
        }

        async function listarCitasCreadas() {
            const response = await fetch("<?= ($_ENV['APP_URL'] . 'php/eventos.php?idpro=' . $idpro) ?>");
            const json = await response.json();

            return json;
        }

        window.addEventListener("DOMContentLoaded", async function() {

            graficarTablaDeDisponibilidad(DATA_INICIAL);
            await listarDisponibilidad();

            DATA_FULLCALENDAR = await listarCitasCreadas();
            DATA_FULLCALENDAR_DISABLED = await listarFechasDesabilitadas();

        });

        /*async function aceptarCita(e){
            e.preventDefault();

            const form = document.getElementById("formocult");
            const formData = new FormData(form);
            formData.append("idcita", sessionStorage.getItem("idcitapro"));
            formData.append("aceptarcita", "true");

            const response = await fetch("", {
                method: "post",
                body: formData
            });
            const text = await response.text();
            /* $("#exampleModal").modal("hide"); */

        /* await listarDisponibilidad(); */

        //window.location.reload();
        //}

        /*async function rechazarCita(e){
            e.preventDefault();

            const form = document.getElementById("formocult");
            const formData = new FormData(form);
            formData.append("idcita", sessionStorage.getItem("idcitapro"));
            formData.append("rechazarcita", "true");

            const response = await fetch("", {
                method: "post",
                body: formData
            });
            const text = await response.text();
            $("#exampleModal").modal("hide");

            await listarDisponibilidad();
        }*/
    </script>
    <script>
        async function rechazarCita() {
            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Solicitud de cita',
                text: "¿Está seguro de rechazar esta solicitud de cita? No podrá revertir esta acción.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ff0800',
                cancelButtonColor: '#0052d4',
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'No'
            });

            if (isConfirmed) {
                const formData = new FormData();
                formData.append("idcita", $("#idCita").val());

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/rechazarSolicitudCita.php", {
                    method: "post",
                    body: formData
                });

                const json = await response.json();

                const [primerCorreo] = json;
                await enviarCorreo(primerCorreo);
                const text = await Swal.fire({
                    title: 'Solicitud de cita rechazada',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#0052d4',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    socket.emit("cita", "rechazarCita");
                    $('#exampleModal').modal('hide');
                    /* window.location.reload(); */
                });
            }
        }

        async function aceptarCita() {
            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Solicitud de cita',
                text: "¿Está seguro de confirmar esta solicitud de cita?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00d418',
                cancelButtonColor: '#0052d4',
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'No'
            });

            if (isConfirmed) {
                const formData = new FormData();
                formData.append("idcita", $("#idCita").val());

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/aceptarSolicitudCita.php", {
                    method: "post",
                    body: formData
                });
                const json = await response.json();

                const [primerCorreo] = json;
                await enviarCorreo(primerCorreo);
                
                const text = await Swal.fire({
                    title: 'Solicitud de cita confirmada',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#0052d4',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    socket.emit("cita", "aceptarCita");
                    $('#exampleModal').modal('hide');
                    /* window.location.reload(); */
                });
            }
        }
    </script>
    <main>
        <div class="ctn-fullc">
  <div class="ctn-horario container mt-3" id="ctn-horario">
    <div class="accordion">
      <div class="accordion-item">
        <div class="accordion-heading">
          <h2>DISPONIBILIDAD HORARIA</h2>
          <i class="fas fa-chevron-down ml-2"></i>
        </div>
        <div class="accordion-content">
          <div id="tablaPrueba"></div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
  <script>
    $(document).ready(function() {
      $('.accordion-heading').click(function() {
        $(this).toggleClass('active');
        $(this).next('.accordion-content').slideToggle();
      });
    });
  </script>
            <div class="ctn-agenda">
                <div class="ctn-editarpc">
                    <h2>AGENDA DE CITAS</h2>
                    <ul id="ulhabilitar">
                        <li>Si desea deshabilitar la programación de citas en días específicos, arrastre el puntero desde el primer al último día a deshabilitar.</li>
                    </ul>
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
                $(document).ready(async function() {

                    await new Promise((resolve) => {
                        if (!document.querySelector('[src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.js"]')) {

                            let script = document.createElement('script');
                            script.addEventListener('load', (e) => {
                                //R console.log('fullcalendar is loading...');
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
                                //R console.log('esCalendar is loading...');
                                resolve();
                            });
                            script.src = '<?php echo $_ENV['APP_URL']; ?>js/es.js';
                            script.async = true;
                            document.body.appendChild(script);
                        }
                    });


                    function formatDate(fechaString) {
                        return fechaString.split("-").reverse().join("-");
                    }
                    /* '<?php echo $_ENV['APP_URL']; ?>php/eventos.php?idpro=<?php echo $idpro ?>' */

                    $('#CalendarioWeb').fullCalendar({
                        events: await new Promise(async (resolve) => {

                            const jsonCitas = await listarCitasCreadas();
                            const jsonCitasDesabilitadas = await listarFechasDesabilitadas();
                            resolve([...jsonCitas, ...jsonCitasDesabilitadas.map((cita) => {
                                return {
                                    start: cita.startDate,
                                    end: cita.endDate,
                                    overlap: false,
                                    rendering: 'background',
                                    color: '#ff9f89'
                                }
                            })]);
                        }),
                        selectable: true,
                        eventClick: function(data, jsEvent, view) {
                            // VERIFICAR LA FECHA ESTA DESABILITADA 

                            if (data.title == "<?= $_ENV['CITA_ENVIADA'] ?>") {
                                data['title'] = "Enviada... Realice la confirmación de esta solicitud de cita.";
                                var titcita = [
                                    "SOLICITUD DE CITA RECIBIDA"
                                ];
                            }

                            if (data.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
                                data['title'] = "Confirmada... Espere a que el paciente realice el pago de esta cita.";
                                var titcita = [
                                    "SOLICITUD DE CITA CONFIRMADA"
                                ];
                            }

                            if (data.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
                                data['title'] = "Programada... Únase con el link en la fecha y hora correspondientes.";
                                var titcita = [
                                    "CITA PROGRAMADA"
                                ];
                            }

                            if (data.title == "<?= $_ENV['CITA_VENCIDA'] ?>") {
                                data['title'] = "Vencida... La fecha de esta cita ha expirado.";
                                var titcita = [
                                    "CITA VENCIDA"
                                ];
                            }

                            const titulos = [
                                "Vencida... La fecha de esta cita ha expirado.",
                                "Confirmada... Espere a que el paciente realice el pago de esta cita.",
                                "Programada... Únase con el link en la fecha y hora correspondientes."
                            ];

                            $aceptarcita = $("#aceptarcita");
                            if (titulos.includes(data.title)) {
                                $aceptarcita.css('visibility', 'hidden');
                            } else {
                                $aceptarcita.css('visibility', 'visible');
                            }

                            const titulospro = [
                                "Programada... Únase con el link en la fecha y hora correspondientes."
                            ];

                            $('#pasistencia').html(data.asistencia);
                            $('#pasistenciapac').html(data.asistenciapac);

                            $rechazarcita = $("#rechazarcita");
                            if (titulospro.includes(data.title)) {
                                $rechazarcita.css('display', 'none');
                                $aceptarcita.css('display', 'none');
                                $('#informes').css('display', 'flex');
                            } else {
                                $rechazarcita.css('display', 'block');
                                $aceptarcita.css('display', 'block');
                                $('#informes').css('display', 'none');
                            }

                            var psico = [
                                data.especialidad
                            ];
                            var idpac = [
                                data.id
                            ];

                            sessionStorage.setItem("idcitapro", data.idcita);
                            $("#idCita").val(data.idcita);
                            $('#tituloEvento').html(`${titcita}`);
                            $('#nombrecita').html(`${data.nombresPaciente} ${data.apellidosPaciente}`);
                            $('#titEvento').html(data.title);

                            // Confirmado... Únase a la teleconsulta en la fecha y hora programada.
                            const isConfirm = (data.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>");
                            $("#formocult").css('display', isConfirm ? 'none' : 'block');

                            $('#nombreprocita').html(`<?= $doctor ?> ${data.nombresMedico} ${data.apellidosMedico}`);
                            $('#profcita').html(`${psico}`);
                            $('#preciocita').html(`S/ ${data.localizacion}`);
                            $('#linkcita').html(data.ubicacion);
                            $('#bcfiled2').attr('href', '<?= $_ENV['APP_URL'] ?>hclinicapro/' + idpac + '/' + data.idpay);
                            if (data.asistencia != "No asistió" && data.asistenciapac != "No asistió") {
                                $('#bcfiled2').css('display', 'block');
                            } else {
                                $('#bcfiled2').css('display', 'none');
                            }
                            $("#linkcita").click(function() {
                                window.open(data.ubicacion, '_blank');
                            });

                            const [fecha, hora] = data.start._i.split(" ");
                            const [tinicial, tfinal] = hora.split(":00");
                            $('#fechacita').html(`${moment(fecha).format('L')} a las ${tinicial}:00`);
                            $('#ocultfeho').val(`${fecha} ${hora}`);

                            $("#exampleModal").modal();
                        },
                        select: async function(startDate, endDate) {

                            // GENERAMOS EL RANGO DE FECHAS SELECCIONADAS
                            const startDateClone = startDate.format().toString();
                            const endDateClone = endDate.format().toString();

                            let fechaInicio = startDate.format();
                            let fechaFinal = endDateClone;

                            const rangoDeFechas = [];
                            while (fechaInicio != fechaFinal) {
                                rangoDeFechas.push(fechaInicio);
                                fechaInicio = startDate.add(1, 'days').format();
                            }

                            // VERIFICAMOS SI SE DESE ELIMINAR LAS FECHAS DESABILITADAS
                            let laCitaIncluyeEnElRangoDeFechasDisabled = false;
                            let index;

                            const citasMapDisabled = DATA_FULLCALENDAR_DISABLED.map((c) => {

                                let startDate = c.startDate;
                                let startDateMoment = moment(c.startDate);

                                const rangoDeFechasRegistradas = [];

                                while (startDate != c.endDate) {
                                    rangoDeFechasRegistradas.push(startDate);
                                    startDate = startDateMoment.add(1, 'days').format("YYYY-MM-DD");
                                }

                                return {
                                    ...c,
                                    rangoDeFechasRegistradas
                                };
                            });

                            for (const [i, fechaDisabled] of citasMapDisabled.entries()) {
                                for (const fecha of rangoDeFechas) {
                                    if (fechaDisabled.rangoDeFechasRegistradas.includes(fecha)) {
                                        laCitaIncluyeEnElRangoDeFechasDisabled = true;
                                        index = i;
                                        break;
                                    }
                                }
                            }

                            if (laCitaIncluyeEnElRangoDeFechasDisabled) {
                                const {
                                    id,
                                    startDate,
                                    endDate
                                } = DATA_FULLCALENDAR_DISABLED[index];

                                const {
                                    isConfirmed
                                } = await Swal.fire({
                                    title: 'Habilitar días',
                                    html: `¿Está seguro de habilitar del día ${formatDate(startDate)} al ${formatDate(moment(endDate).add(-1, 'days').format("YYYY-MM-DD"))}?`,
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#00d418',
                                    cancelButtonColor: '#0052d4',
                                    confirmButtonText: 'Sí, habilitar',
                                    cancelButtonText: 'No'
                                });

                                if (isConfirmed) { // SE CONFIRMA HABILITAR EL RANGO DE FECHAS ANTES DESABILITADO
                                    const formData = new FormData();
                                    formData.append("method", 'eliminarFechasDesabilitadas');
                                    formData.append("id", id);

                                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classDesabilitarAtencionMedica.php", {
                                        method: "post",
                                        body: formData
                                    });
                                    const text = await response.text();

                                    // EMITIR UN MENSAJE AL SOCKET
                                    socket.emit("cita", "eliminarFechasDesabilitadas");
                                }

                                return;
                            }



                            // VERIFICAMOS LA DISPONIBILIDAD EN EL RANGO SELECCIONADO PARA DESABILITAR LA ATENCION
                            const citasMap = DATA_FULLCALENDAR.map((c) => c.start.substring(0, 10));
                            let laCitaIncluyeEnElRangoDeFechas = false;
                            for (const fecha of rangoDeFechas) {
                                if (citasMap.includes(fecha)) {
                                    laCitaIncluyeEnElRangoDeFechas = true;
                                    break;
                                }
                            }

                            if (laCitaIncluyeEnElRangoDeFechas) {
                                Swal.fire({
                                    title: `Deshabilitar días`,
                                    text: 'No puede deshabilitar días con citas pendientes.',
                                    icon: 'error',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                });
                                return false;
                            }

                            const {
                                isConfirmed
                            } = await Swal.fire({
                                title: 'Deshabilitar días',
                                html: `¿Está seguro de deshabilitar del día ${formatDate(startDateClone)} al ${formatDate(endDate.add(-1, 'days').format())}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#ff0800',
                                cancelButtonColor: '#0052d4',
                                confirmButtonText: 'Sí, deshabilitar',
                                cancelButtonText: 'No'
                            });

                            if (isConfirmed) { // SE CONFIRMA DESABILITAR UN RANGO DE FECHAS

                                const formData = new FormData();
                                formData.append("method", 'registrarFechasDesabilitadas');
                                formData.append("idupro", <?php echo $_SESSION['idpro'] ?>);
                                formData.append("startDate", startDateClone);
                                formData.append("endDate", endDateClone);

                                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classDesabilitarAtencionMedica.php", {
                                    method: "post",
                                    body: formData
                                });
                                const text = await response.text();

                                // EMITIR UN MENSAJE AL SOCKET
                                socket.emit("cita", "registrarFechasDesabilitadas");
                            }
                        },
                    });
                });
            </script>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titEvento"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <!-- <form method="POST" id="formocult">
                            <input type="text" id="ocultfeho" name="ocultfeho">
                            <button type="submit" class="btn btn-success" name="aceptarcita" id="aceptarcita">Aceptar</button>
                        </form> -->
                        </div>
                        <?php
                        include 'conexion_paciente.php';
                        ?>
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
                        <div class="modal-footer">

                            <div class="informes" id="informes">
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
                                <a href="<?php echo $_ENV['APP_URL']; ?>hclinicapro/" id="bcfiled2">Historia Clínica</a>
                            </div>
                            <input type="text" id="ocultfeho" name="ocultfeho">
                            <button onClick="aceptarCita()" type="submit" class="btn btn-success" id="aceptarcita" style="background:#00d418;border:1px solid #00d418;position:relative;top:unset;left:unset;font-size:14px;font-weight:500;padding:8px 20px" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';">
                                Confirmar Cita
                            </button>
                            <button onClick="rechazarCita()" type="submit" class="btn btn-danger" id="rechazarcita" style="background:#ff0000;border:1px solid #ff0000;font-size:14px;font-weight:500;padding:8px 20px" onmouseover="this.style.background='#e10800';this.style.border='1px solid #e10800';" onmouseout="this.style.background='#ff0000';this.style.border='1px solid #ff0000';">
                                Rechazar Cita
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