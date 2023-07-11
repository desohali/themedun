<?php
include 'conexion_paciente.php';

$idcita = $_POST['idCitas'];
$consulta = "SELECT * FROM citas WHERE idcita = '" . $idcita . "' ";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado) {
    while ($row = $resultado->fetch_array()) {
        $id = $row['id'];
        $idpro = $row['idupro'];
    }
}

$idpago = 1000000000 + $idcita;
$metodopago = $_POST['tipoPay'];
$estadopago = "approved";

if (isset($idcita)) {
    $insert = "INSERT INTO pagos (idpago, usuario, usuariopro, metodopago, fechahorap, estadopago) VALUES ('$idpago', '$id', '$idpro', '$metodopago', now(), '$estadopago')";
    $sql5 = mysqli_query($conexion, $insert);

    include_once 'zoom_api_new.php';

    $query = "SELECT *, id as idu,";
    $query .= "(select nombrespro from usuariospro where idpro=idupro) as nombresMedico,";
    $query .= "(select apellidospro from usuariospro where idpro=idupro) as apellidosMedico,";
    $query .= "(select sexopro from usuariospro where idpro=idupro) as sexoMedico,";
    $query .= "(select correopro from usuariospro where idpro=idupro) as correoMedico,";
    $query .= "concat('Medicina, ', (select especialidad from usuariospro where idpro=idupro)) as especialidad,";
    $query .= "(select nombres from usuarios where id=idu) as nombresPaciente,";
    $query .= "(select apellidos from usuarios where id=idu) as apellidosPaciente,";
    $query .= "(select sexo from usuarios where id=idu) as sexoPaciente,";
    $query .= "(select correo from usuarios where id=idu) as correoPaciente ";
    $query .= "FROM citas WHERE idcita='" . $idcita . "'";

    $result = mysqli_query($conexion, $query);

    while ($row = $result->fetch_object()) {
        $cita = $row;
    }

    
    $zoom_meeting = new Zoom_Api_New();

    $meetingData = array();
    $meetingData['topic']         = 'Cita The Med Universe';
    $meetingData['timezone']     = 'America/Lima';
    $meetingData['start_time'] = gmdate("Y-m-d\TH:i:s", strtotime($cita->start));
    $meetingData['duration']     = 40;
    $meetingData['type']         = 2;
    $meetingData['password']     = "CITATMU";

    try {
        $response = $zoom_meeting->createMeeting($meetingData);
    } catch (Exception $ex) {
        echo $ex;
    };
    // AQUI SE DEBE DE ACTUALIZAR NO INSERTAR

    $query = "UPDATE citas SET title = 'Programada... Únete con el link en la fecha y hora correspondientes.', color = '#0052d4',";
    $query .= " leido='NO', leidopro='NO', ubicacion = '" . $response->join_url . "', fechanoti=now(), idpay = '" . $idpago . "'";
    $query .= " WHERE idcita = '" . $idcita . "'";
    $result = mysqli_query($conexion, $query);
    // ELIMINAMOS CITAS DE OTROS PACIENTES EN LA MISMA HORA A LOS ESTADOS PENDIENTES Y CONFIRMADOS

    $select = "UPDATE citas SET leido='NO', leidopro='NO', estado='ELIMINADA', fechanoti=NOW() WHERE idupro=" . $idpro;
    $select .= " AND idcita <> " . $idcita;
    $select .= " AND start='" . $cita->start . "'";
    $select .= " AND estado <> 'CANCELADA' AND estado <> 'RECHAZADA'";

    $resultSelect = mysqli_query($conexion, $select);

    $sql7 = mysqli_query($conexion, "INSERT INTO hclinica (idhc, idpx, idmed) VALUES ('$idpago', '$id', '$idpro')");

    if ($cita->sexoPaciente == "Femenino") {
        $estimadoPaciente = "Estimada";
        $elOlaPac = "la";
    } else {
        $estimadoPaciente = "Estimado";
        $elOlaPac = "el";
    }

    if ($cita->sexoMedico == "Femenino") {
        $estimadoMedico = "Estimada, Dra.";
        $elOlaMed = "la Dra.";
    } else {
        $estimadoMedico = "Estimado, Dr.";
        $elOlaMed = "el Dr.";
    }

    $fechapago = $cita->start;
		list($fecha, $hora) = explode(" ", $fechapago);
		$horafinal = explode(":00", $hora);
		$timestamp = strtotime($fecha);
		$newFecha = date("d/m/Y", $timestamp);
		if($horafinal[0]=='01'){
		  $enlace=" a la ";
		}else{
		  $enlace=" a las ";
		}
		$tiempoFinal=$newFecha . $enlace . $horafinal[0] . ":00";

    $titulo = "CITA PROGRAMADA";
    $mensajePaciente = "
		<html>
		<head>
			<title>CITA PROGRAMADA</title>
		</head>
		<body>
			<h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
			<p>" . $estimadoPaciente . ", " . $cita->nombresPaciente . " " . $cita->apellidosPaciente . ":<br><br>Has programado una cita con " . $elOlaMed . " " . $cita->nombresMedico . " " . $cita->apellidosMedico . " para el " . $tiempoFinal . ". Únete con este link <a href='" . $response->join_url . "'>" . $response->join_url . "</a> en la fecha y hora correspondientes.<br><br>Encontrarás mayor información de tu cita en <a href='".$_ENV['APP_URL']."agenda/" . $id . "'>".$_ENV['APP_URL']."agenda/" . $id . "</a>.</p>
		</body>
		</html>
		";

    $mensajeMedico = "
		<html>
		<head>
			<title>CITA PROGRAMADA</title>
		</head>
		<body>
			<h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
			<p>" . $estimadoMedico . " " . $cita->nombresMedico . " " . $cita->apellidosMedico . ":<br><br>Se le ha programado una cita con " . $elOlaPac . " paciente " . $cita->nombresPaciente . " " . $cita->apellidosPaciente . " para el " . $tiempoFinal . ". Únase con el link <a href='" . $response->join_url . "'>" . $response->join_url . "</a> en la fecha y hora correspondientes.<br><br>Encontrará mayor información de su cita en <a href='".$_ENV['APP_URL']."horario/" . $idpro . "'>".$_ENV['APP_URL']."horario/" . $idpro . "</a>.</p>
		</body>
		</html>
		";

    $mensajeAdmin = "
		<html>
		<head>
			<title>CITA PROGRAMADA</title>
		</head>
		<body>
			<h1 style='color:#0052d4; text-align:center'>The Med Universe</h1>
			<p>Estimado, Gerente General Leandro Santiago Bernal Saavedra:<br><br>Se ha programado una cita entre " . $elOlaMed . " " . $cita->nombresMedico . " " . $cita->apellidosMedico . " y " . $elOlaPac . " paciente " . $cita->nombresPaciente . " " . $cita->apellidosPaciente . " para el " . $tiempoFinal . ". El link de unión a la teleconsulta es el siguiente: <a href='" . $response->join_url . "'>" . $response->join_url . "</a><br>Encontrará mayor información de la cita en <a href='".$_ENV['APP_URL']."agendaadmin/1'>".$_ENV['APP_URL']."agendaadmin/1</a></p>
		</body>
		</html>
		";

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    // Cabeceras adicionales
    $cabeceras .= 'From: citas@themeduniverse.com' . "\r\n";

    // mail($cita->correoMedico, $titulo, $mensajeMedico, $cabeceras);
    // mail($cita->correoPaciente, $titulo, $mensajePaciente, $cabeceras);
    // mail('leandrobernal@themeduniverse.com', $titulo, $mensajeAdmin, $cabeceras);
    $script = "<script>";
    $script .= "(async () => {";
    $script .= "await enviarCorreo({to: $cita->correoMedico, subject: $titulo, html: $mensajeMedico});";
    $script .= "await enviarCorreo({to: $cita->correoPaciente, subject: $titulo, html: $mensajePaciente});";
    $script .= "await enviarCorreo({to: 'bernalsaavedraleandro@gmail.com', subject: $titulo, html: $mensajeAdmin});";
    $script .= "window.location.href='" . $_ENV['APP_URL'] . "agendaadmin/" . $_SESSION['idAdmin'] . "'";
    $script .= "})()";
    $script .= "</script>";

    echo $script;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Agenda - The Med Universe | Administrador</title>
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
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <?php echo headernav();
    include './php/navbarAdmin.php'; ?>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/buscadorAdmin.js"></script>
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
                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/eventosadmin.php?idadmin=<?php echo $id ?>");
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
                var _websocketServiceAgenda = new websocketService(initAgenda);
                _websocketServiceAgenda.connection();
                async function aceptarCita() {
                    const {
                        isConfirmed
                    } = await Swal.fire({
                        title: 'Administración de cita',
                        text: "¿Está seguro de administrar esta cita?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00d418',
                        cancelButtonColor: '#0052d4',
                        confirmButtonText: 'Sí, administrar',
                        cancelButtonText: 'No'
                    });

                    if (isConfirmed) {
                        const formData = new FormData();
                        formData.append("idcita", $("#idCita").val());
                        formData.append("idadmin", <?php echo $id; ?>);

                        const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/administrarCita.php", {
                            method: "post",
                            body: formData
                        });
                        const text = await Swal.fire({
                            title: 'Administración de cita confirmada',
                            text: '',
                            icon: 'success',
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            window.location.reload();
                        });
                    }
                }
            </script>
            <script>
                window.addEventListener("DOMContentLoaded", function() {
                    const formInforme = document.getElementById("formInforme");

                    formInforme.addEventListener("submit", async function(e) {
                        e.preventDefault();
                        const {
                            isConfirmed
                        } = await Swal.fire({
                            title: 'Informe de cita',
                            text: "¿Está seguro de enviar el informe de cita? Ya no lo podrá modificar.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#00d418',
                            cancelButtonColor: '#0052d4',
                            confirmButtonText: 'Sí, enviar',
                            cancelButtonText: 'No'
                        });

                        if (isConfirmed) {
                            const formData = new FormData(this);
                            formData.append("idcita", $("#idCita").val());
                            formData.append("idPro", $("#idPro").val());
                            formData.append("idadmin", <?php echo $id; ?>);
                            formData.append("indicaciones", "Usted ha acumulado 2 deudas por inasistencia a sus citas programadas, en el “Historial de Pagos” encontrará los métodos de pago para saldar su deuda y, por consiguiente, desbloquear su cuenta.");
                            if ($("#asistencia").val() != '' && $("#asistenciapac").val() != '') {
                                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/informeCita.php", {
                                    method: "post",
                                    body: formData
                                });
                                const text = await Swal.fire({
                                    title: 'Informe de cita enviado',
                                    text: '',
                                    icon: 'success',
                                    confirmButtonColor: '#0052d4',
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    window.location.reload();
                                });
                            };
                        };
                    });
                });
            </script>
            <script>
                window.addEventListener("DOMContentLoaded", function() {
                    const formProgramar = document.getElementById("formProgramar");

                    formProgramar.addEventListener("submit", async function(e) {
                        e.preventDefault();
                        const {
                            isConfirmed
                        } = await Swal.fire({
                            title: 'Programación de cita',
                            text: "¿Está seguro de programar esta cita?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#00d418',
                            cancelButtonColor: '#0052d4',
                            confirmButtonText: 'Sí, programar',
                            cancelButtonText: 'No'
                        });

                        if (isConfirmed) {
                            formProgramar.submit();
                            const text = await Swal.fire({
                                title: 'Cita programada',
                                text: '',
                                icon: 'success',
                                confirmButtonColor: '#0052d4',
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                window.location.reload();
                            });
                            /* }; */
                        }
                    });
                });
            </script>
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

                    $('#CalendarioWeb').fullCalendar({
                        events: '<?php echo $_ENV['APP_URL']; ?>php/eventosadmin.php?idadmin=<?php echo $id ?>',
                        eventClick: async function(calEvent, jsEvent, view) {
                            if (calEvent.sexoMedico == 'Femenino') {
                                var doctor = [
                                    "Dra."
                                ];
                            } else {
                                var doctor = [
                                    "Dr."
                                ];
                            }
                            $formProgramar = $("#formProgramar");

                            if (calEvent.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
                                $('#formProgramar').css('display', 'none');
                                var titcita = [
                                    "CITA PROGRAMADA"
                                ];
                            } else if (calEvent.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
                                $('#formProgramar').css('display', 'flex');
                                var titcita = [
                                    "CITA CONFIRMADA"
                                ];
                            }
                            var psico = [
                                calEvent.especialidad
                            ];
                            $("#idCita").val(calEvent.idcita);
                            $("#idCitas").val(calEvent.idcita);
                            $("#idPro").val(calEvent.idupro);
                            $("#idPac").val(calEvent.id);
                            $('#tituloEvento').html(`${titcita}`);
                            $('#titEvento').html(calEvent.title);
                            $('#nombrecita').html(`${calEvent.nombresPaciente} ${calEvent.apellidosPaciente}`);
                            $('#nombreprocita').html(`${doctor} ${calEvent.nombresMedico} ${calEvent.apellidosMedico}`);
                            $('#profcita').html(`${psico}`);
                            $('#pasistencia').html(calEvent.asistencia);
                            $('#pasistenciapac').html(calEvent.asistenciapac);
                            $('#preciocita').html(`S/. ${calEvent.localizacion}`);
                            $aceptarcita = $("#aceptarcita");
                            if (calEvent.idadmin == <?php echo $id; ?>) {
                                $('#linkcita').html(calEvent.ubicacion);
                                $("#linkcita").click(function() {
                                    window.open(calEvent.ubicacion, '_blank');
                                });
                                $aceptarcita.css('display', 'none');
                                if (calEvent.asistencia == null || calEvent.asistencia == '') {
                                    $('#formInforme').css('display', 'flex');
                                    $('#informes').css('display', 'none');
                                } else {
                                    $('#formInforme').css('display', 'none');
                                    $('#informes').css('display', 'block');
                                }
                            } else {
                                $('#linkcita').html('');
                                $('#formInforme').css('display', 'none');
                                $('#informes').css('display', 'none');
                                $aceptarcita.css('visibility', 'visible');
                                $aceptarcita.css('display', 'block');
                                if (calEvent.idadmin != '0') {
                                    $aceptarcita.css('visibility', 'hidden');
                                }
                            }
                            if (calEvent.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
                                $aceptarcita.css('display', 'none');
                            }

                            const [fecha, hora] = calEvent.start._i.split(" ");
                            $('#fechacita').html(`${moment(fecha).format('L')} a las ${hora}`);

                            $("#exampleModal").modal();

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
                                    <input id="idPro" type="hidden">
                                    <input id="idPac" type="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form id="formInforme" method="POST">
                                <div class="camposinforme">
                                    <select name="asistencia" id="asistencia" required>
                                        <option class="select-opt" value="">Asistencia pro</option>
                                        <option value="Asistió">Asistió</option>
                                        <option value="No asistió">No asistió</option>
                                    </select>
                                    <select name="asistenciapac" id="asistenciapac" required>
                                        <option class="select-opt" value="">Asistencia pac</option>
                                        <option value="Asistió">Asistió</option>
                                        <option value="No asistió">No asistió</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success" id="informecita" style="background:#00d418;border:1px solid #00d418;font-size:14px;font-weight:600;padding:10px 20px;" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';">
                                    Enviar informe
                                </button>
                            </form>
                            <div class="informes" id="informes">
                                <div class="infinterno">
                                    <span style="margin-right:5px">Asistencia profesional:</span>
                                    <p id="pasistencia"></p>
                                </div>
                                <div class="infinterno">
                                    <span style="margin-right:5px">Asistencia paciente:</span>
                                    <p id="pasistenciapac"></p>
                                </div>
                            </div>
                            <button onClick="aceptarCita()" type="submit" class="btn btn-success" id="aceptarcita" style="background:#00d418;border:1px solid #00d418;position:relative;top:unset;left:unset;font-size:14px;font-weight:600;padding:10px 20px" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';">
                                Administrar cita
                            </button>
                            <form id="formProgramar" method="POST">
                                <div class="camposinforme">
                                    <select name="tipoPay" id="tipoPay" required>
                                        <option class="select-opt" value="">Tipo de pago</option>
                                        <option value="Transferencia bancaria">Transferencia bancaria</option>
                                        <option value="Yape">Yape</option>
                                    </select>
                                    <input id="idCitas" name="idCitas" type="hidden">
                                </div>
                                <button type="submit" class="btn btn-success" id="programarcita" style="background:#00d418;border:1px solid #00d418;font-size:14px;font-weight:600;padding:10px 20px;" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';">
                                    Programar cita
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php echo footermed(); ?>

</html>