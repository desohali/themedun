<?php
include 'conexion_paciente.php';

if (explode("/", $_GET['view'])[1] == '') {
	echo "<script>window.location.href='" . $_ENV['APP_URL'] . "home'</script>";
}
$_GET['id'] = explode("/", $_GET['view'])[1];
$medicosRegistrados = '';
$consultavistas = "SELECT idpro FROM usuariospro WHERE idpro = '" . $_GET['id'] . "' AND estado='1'";
$consultares = mysqli_query($conexion, $consultavistas);
while ($lista = mysqli_fetch_array($consultares)) {
	$medicosRegistrados = $lista['idpro'];
}
if (isset($_GET['id']) && @$_GET['id'] == @$medicosRegistrados) {
	$consultapro = "SELECT * FROM usuariospro WHERE idpro = '" . $_GET['id'] . "' ";
	$resultadopro = mysqli_query($conexion, $consultapro);
	if ($resultadopro) {
		while ($rowpro = $resultadopro->fetch_array()) {
			$idpro = $rowpro['idpro'];
			$nombrespro = $rowpro['nombrespro'];
			$apellidospro = $rowpro['apellidospro'];
			$sexopro = $rowpro['sexopro'];
			$especialidad = $rowpro['especialidad'];
			$precio = $rowpro['precio'];
			$fotoperfilpro = $rowpro['fotoperfilpro'];
			if ($sexopro == "Femenino") {
				$doctor = "Dra.";
			} else {
				$doctor = "Dr.";
			}
		}
	}
} else {
	//header("Location: " . $_ENV['APP_URL'] . "home");
	echo "<script>window.location.href='" . $_ENV['APP_URL'] . "home'</script>";
}
?>

<?php
include 'conexion_paciente.php';

if (isset(explode("/", $_GET['view'])[2]) && isset(explode("/", $_GET['view'])[3]) && isset(explode("/", $_GET['view'])[4]) && isset(explode("/", $_GET['view'])[5])) {
	$_GET['payment_id'] = explode("/", $_GET['view'])[2];
	$_GET['status'] = explode("/", $_GET['view'])[3];
	$_GET['payment_type'] = explode("/", $_GET['view'])[4];
	$_GET['merchant_order_id'] = explode("/", $_GET['view'])[5];
	$_GET['url'] = explode("/", $_GET['view'])[6];
}
if (isset($_GET['payment_id']) && isset($_GET['status']) && isset($_GET['payment_type']) && isset($_GET['merchant_order_id'])) {

	/* setcookie("ws", "pagarCita", time() + (86400 * 30), "*"); */

	$idpago = $_GET['payment_id'];
	$estadopago = $_GET['status'];
	$metodopago = $_GET['payment_type'];
	$merchantorder = $_GET['merchant_order_id'];
	if ($metodopago == "credit-card") {
		$metodopago = "Tarjeta de crédito";
	} else if ($metodopago == "debit-card") {
		$metodopago = "Tarjeta de débito";
	}
	if ($estadopago = "approved") {
		$sql5 = mysqli_query($conexion, "INSERT INTO pagos (idpago, usuario, usuariopro, metodopago, fechahorap, estadopago) VALUES ('$idpago', '$id', '$idpro', '$metodopago', now(), '$estadopago')");

		include_once 'Zoom_Api.php';
		include_once 'getOrderMercadoPago.php';

		$order =  getItem($merchantorder);

		$idpro = $_GET['id'];
		/* $ocultfehonew = $_GET['fecha'];// fecha y hora */


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
		$query .= "FROM citas WHERE idcita='" . $order['firstItem']['id'] . "'";

		$result = mysqli_query($conexion, $query);

		while ($row = $result->fetch_object()) {
			$cita = $row;
		}

		$zoom_meeting = new Zoom_Api();

		$data = array();
		$data['topic'] 		= 'Cita The Med Universe';
		$data['timezone'] 	= 'America/Lima';
		$comienzo = strtotime('-6 hours', strtotime($cita->start));
		$data['start_time'] = date('Y-m-d H:i:s', $comienzo);
		$data['duration'] 	= 40;
		$data['type'] 		= 2;
		$data['password'] 	= "12345";

		try {
			$response = $zoom_meeting->createMeeting($data);
		} catch (Exception $ex) {
			echo $ex;
		};
		// AQUI SE DEBE DE ACTUALIZAR NO INSERTAR

		$query = "UPDATE citas SET title = 'Programada... Únete con el link en la fecha y hora correspondientes.', color = '#0052d4',";
		$query .= " leido='NO', leidopro='NO', ubicacion = '" . $response->join_url . "', fechanoti=now(), idpay = '" . $idpago . "' ";
		$query .= " WHERE idcita = '" . $order['firstItem']['id'] . "'";
		$result = mysqli_query($conexion, $query);
		// ELIMINAMOS CITAS DE OTROS PACIENTES EN LA MISMA HORA A LOS ESTADOS PENDIENTES Y CONFIRMADOS

		$select = "UPDATE citas SET leido='NO', leidopro='NO', estado='ELIMINADA', fechanoti=NOW() WHERE idupro=" . $idpro;
		$select .= " AND idcita <> " . $order['firstItem']['id'];
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
			<h1 style='color:#0052d4; text-align:center'>TheMedUniverse</h1>
			<p>" . $estimadoPaciente . ", " . $cita->nombresPaciente . " " . $cita->apellidosPaciente . ":<br><br>Has programado una cita con " . $elOlaMed . " " . $cita->nombresMedico . " " . $cita->apellidosMedico . " para el " . $tiempoFinal . ". Únete con este link <a href='" . $response->join_url . "'>" . $response->join_url . "</a> en la fecha y hora correspondientes.<br><br>Encontrarás mayor información de tu cita en <a href='".$_ENV['APP_URL']."agenda/" . $_SESSION['id'] . "'>".$_ENV['APP_URL']."cita/" . $_SESSION['id'] . "</a>.</p>
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
			<p>Estimado, Gerente General Leandro Santiago Bernal Saavedra:<br><br>Se ha programado una cita entre " . $elOlaMed . " " . $cita->nombresMedico . " " . $cita->apellidosMedico . " y " . $elOlaPac . " paciente " . $cita->nombresPaciente . " " . $cita->apellidosPaciente . " para el " . $tiempoFinal . ". El link de unión a la teleconsulta es el siguiente: <a href='" . $response->join_url . "'>" . $response->join_url . "</a><br><br>Encontrará mayor información de la cita en <a href='".$_ENV['APP_URL']."agendaadmin/1'>".$_ENV['APP_URL']."agendaadmin/1</a></p>
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
		// mail('bernalsaavedraleandro@gmail.com', $titulo, $mensajeAdmin, $cabeceras);
		$urlReplace = $_ENV['APP_URL'] . $_GET['url'] . "/" . $idpro . "?ws=62c0e72bf038366388783650";

		$script = "<script>";
		$script .= "await enviarCorreo({to: $cita->correoMedico, subject: $titulo, html: $mensajeMedico});";
		$script .= "await enviarCorreo({to: $cita->correoPaciente, subject: $titulo, html: $mensajePaciente});";
		$script .= "await enviarCorreo({to: 'bernalsaavedraleandro@gmail.com', subject: $titulo, html: $mensajeAdmin});";
		$script .= "window.location.replace('" . $urlReplace . "')";
		$script .= "</script>";

		echo $script;
	}
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Work Universe Platforms S.A.C." />
	<meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
	<title>Programar cita - The Med Universe | Paciente</title>
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
	<!-- <script async src="https://sdk.mercadopago.com/js/v2"></script> -->

</head>

<body id="body">
	<?php echo headernav();
	include './php/navbar.php'; ?>
	<script src="<?php echo $_ENV['APP_URL']; ?>js/buscador.js"></script>
	<script src="<?php echo $_ENV['APP_URL']; ?>js/m&ob.js"></script>
	<script>
		async function initCita() {

			const DATA_FULLCALENDAR = await listarCitasCreadas();
			const DATA_FULLCALENDAR_DISABLED = await listarFechasDesabilitadas();

			const ALL_DATA = [...DATA_FULLCALENDAR, ...DATA_FULLCALENDAR_DISABLED.map((cita) => {
				return {
					start: cita.startDate,
					end: cita.endDate,
					overlap: false,
					rendering: 'background',
					color: '#ff9f89'
				}
			})];
			/* const json = await listarCitasCreadas() */
			const calendar = $('#CalendarioWeb').fullCalendar('getCalendar');
			// extend object (could be its own function, etc.)
			calendar.refresh = function() {
				calendar.removeEvents();
				calendar.addEventSource(ALL_DATA);
			}

			// finish setting up calendar
			calendar.refresh();
		}

		console.log('socket', socket);
		socket.on("cita", function(msg) {
			initCita();
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

		async function listarDisponibilidad() {

			const formData = new FormData();
			formData.append("idupro", <?php echo $_GET['id'] ?>);
			formData.append("accion", 'listarDisponibilidad');
			const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/registrarHorarios.php", {
				method: "post",
				body: formData
			});
			const json = await response.json();
			console.log('json', json)

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

			await graficarTablaDeDisponibilidad(DATA_MAP);

		}

		const setTimeCurrent = (hora, findMergeCita) => {
			if (findMergeCita) return false;

			const [horaInicial /* , horaFinal */ ] = hora.split("-");
			const horaActual = new Date().getHours();
			const dateCurrent = moment().format("YYYY-MM-DD");
			if (horaActual >= Number(horaInicial.split(":")[0]) && dateCurrent == sessionStorage.getItem("dateCurrent")) {
				return false;
			}

			sessionStorage.setItem("timeCurrent", horaInicial?.trim());
			document.getElementById("hora").innerHTML = `${horaInicial?.trim()}`;
		}

		async function graficarTablaDeDisponibilidad(HORAS_DIAS) {

			const dateCurrentSession = sessionStorage.getItem('dateCurrent') || "";
			const dayCurrent = new Date(dateCurrentSession).getUTCDay() || 7; // CERO CORRESPONDE AL DOMINGO
			const horaActual = new Date().getHours();

			const listaCitasMedico = await listarCitasDeUnMedico();

			let table = '<table class="table-day">';
			for (const {
					DIAS
				}
				of HORAS_DIAS) {
				table += '<tr>';
				for (const [i, DIA] of DIAS.entries()) {

					if (typeof DIA === "string") {
						if (i != dayCurrent && i > 0) {
							continue;
						}
						table += '<td>';
						table += DIA;
					} else {
						const [ESTADO, NUMERO_DIA] = DIA;
						if (NUMERO_DIA != dayCurrent) {
							continue;
						}
						table += '<td>';
						if (ESTADO) {

							const dateCurrent = moment().format("YYYY-MM-DD");

							const [horaInicial /* , horaFinal */ ] = DIAS[0].split("-");
							const isSelect = (
								horaActual >= Number(horaInicial.split(":")[0]) &&
								dateCurrent == sessionStorage.getItem("dateCurrent")
							);

							const findMergeCita = listaCitasMedico.find(({
								fecha,
								hora
							}) => {
								const [horas /* , minutos, segundos */ ] = hora.split(":");
								const siLasFechasSonIguales = (dateCurrentSession?.trim() == fecha?.trim());
								const siLasHorasSonIguales = (Number(horas) == Number(horaInicial.split(":")[0]));
								return siLasFechasSonIguales && siLasHorasSonIguales;
							});

							console.log('isSelect', isSelect);
							console.log('findMergeCita', findMergeCita);

							table += `<div class="ctn-1 ${ isSelect || findMergeCita ? 'ctn' : "ctn-si"}" onclick="setTimeCurrent('${DIAS[0]}', ${findMergeCita ? true : false})">
															<label class="${ isSelect || findMergeCita ? 'si-disabled' : "si"}">Disponible</label>
														</div>`;
						} else {
							table += `<div class="ctn-no" id="no13">
															<label class="no">No disponible</label>
														</div>`;
						}
					}
					table += '</td>';
				}
				table += '</tr>';
			}
			table += '<table>';

			document.getElementById('tablaPrueba2').innerHTML = table;
		}


		window.addEventListener("DOMContentLoaded", async function() {

			/* await graficarTablaDeDisponibilidad(DATA_INICIAL); */
			/* await listarDisponibilidad(); */

			let params = new URLSearchParams(location.search);
			if (params.get('ws') === "62c0e72bf038366388783650") {

				socket.emit("cita", "pagarCita");

				await new Promise((resolve) => {
					setTimeout(() => resolve(true), 2000);
				});
				window.location.replace(`${window.location.origin}${window.location.pathname}`);
			}


		});

		async function listarCitasDeUnMedico() {

			const json = await listarCitasCreadas();
			const jsonMap = (json || []).filter(({
				title
			}) => {
				return title == "Programada... Únete con el link en la fecha y hora correspondientes.";
			}).map(({
				start
			}) => {
				const [fecha, hora] = start.split(" ");
				return {
					fecha,
					hora
				};
			});

			console.log('jsonMap', jsonMap);
			return jsonMap;
		}
	</script>
	<script>
		async function enviarSolicitud(nombrePaciente, apellidosPaciente) {


			const dateCurrent = sessionStorage.getItem("dateCurrent");
			const timeCurrent = sessionStorage.getItem("timeCurrent");
			const fullDate = `${dateCurrent} ${timeCurrent}:00`;

			if (!dateCurrent || !timeCurrent) {
				Swal.fire({
					title: 'Hora no seleccionada',
					text: 'Selecciona una hora disponible.',
					icon: 'error',
					confirmButtonColor: '#0052d4',
					confirmButtonText: 'Ok',
				});
				return;
			}

			const {
				isConfirmed
			} = await Swal.fire({
				title: 'Solicitud de cita',
				text: "¿Estás seguro de enviar tu solicitud de cita?",
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#00d418',
				cancelButtonColor: '#0052d4',
				confirmButtonText: 'Sí, enviar',
				cancelButtonText: 'No'
			});

			if (isConfirmed) {
				const formData = new FormData();
				formData.append("idpro", <?php echo $_GET['id'] ?>);
				formData.append("id", <?php echo $_SESSION['id'] ?>);
				formData.append("fullDate", fullDate);

				const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/enviarSolicitudCita.php", {
					method: "post",
					body: formData
				});

				const json = await response.json();

				const [primerCorreo] = json;
				await enviarCorreo(primerCorreo);

				const text = await Swal.fire({
					title: 'Solicitud de cita enviada',
					text: 'Espera la confirmación del médico.',
					icon: 'success',
					confirmButtonColor: '#0052d4',
					confirmButtonText: 'Ok',
				}).then((result) => {

					socket.emit("cita", "enviarSolicitud");
					$('#ModalEventos').modal('hide');
					/* window.location.reload(); */
				});
			}

		}

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
				
				const json = await response.json();

				const [primerCorreo] = json;
				await enviarCorreo(primerCorreo);

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

		async function listarFechasDesabilitadas() {
			const formData = new FormData();
			formData.append("idupro", <?php echo $idpro; ?>);
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
	</script>

	<main>
		<div class="ctn-fullc">
			<div class="container">
				<div class="ctn-editarpc">
					<h2>SELECCIONA UNA FECHA</h2>
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
				/* async function verificarCitasVencidas({
					idupro,
					start: fecha
				}) {

					const formData = new FormData();
					formData.append("method", "verificarCitaProgramada");
					formData.append("idupro", idupro);
					formData.append("fecha", fecha);

					const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
						method: "post",
						body: formData
					});
					const json = await response.json();
					return json;
				}
 */

				async function verificarCitaProgramada({
					idupro,
					start: fecha
				}) {

					const formData = new FormData();
					formData.append("method", "verificarCitaProgramada");
					formData.append("idupro", idupro);
					formData.append("fecha", fecha);

					const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classNotificaciones.php", {
						method: "post",
						body: formData
					});
					const json = await response.json();
					return json;
				}

				var interval;

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


					const MERCADO_PAGO = new MercadoPago('TEST-585234f9-d099-4007-99ad-cdbb0757471b', {
						locale: 'es-PE'
					});


					async function send({
						idcita,
						title,
						idupro,
						start
					}) {
						const formData = new FormData();
						formData.append("idcita", idcita);
						formData.append("url", 'cita');

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
							}
						});

						// VERIFICACION DE COMPRA O PAGO DE CITA
						if (title == "Confirmada... Realiza el pago de tu cita lo antes posible.") {
							let mostrarNotificacion = true;
							interval = setInterval(async () => {
								const {
									mensajePacienteRealizoElPagoAntes,
									mensajeCitaAcabaDeVencer,
									mensajeCitaVencida
								} = await verificarCitaProgramada({
									idupro,
									start: start?.format()?.replace("T", " ")
								});

								if (mensajePacienteRealizoElPagoAntes) {

									if (mostrarNotificacion) {
										Swal.fire({
											title: 'Solicitud de cita cancelada',
											text: 'Otro paciente realizó el pago antes, selecciona otra fecha disponible.',
											icon: 'error',
											confirmButtonColor: '#0052d4',
											confirmButtonText: 'Ok',
										}).then(() => {
											window.location.reload();
										});

										mostrarNotificacion = false;
									}

								}

								if (mensajeCitaAcabaDeVencer) {
									if (mostrarNotificacion) {
										Swal.fire({
											title: 'Solicitud de cita cancelada',
											text: 'La fecha de tu solicitud de cita ha expirado, selecciona otra fecha disponible.',
											icon: 'error',
											confirmButtonColor: '#0052d4',
											confirmButtonText: 'Ok',
										}).then(() => {
											window.location.reload();
										});

										mostrarNotificacion = false;
									}
								}

								if (mensajeCitaVencida) {
									if (mostrarNotificacion) {
										Swal.fire({
											title: 'Solicitud de cita cancelada',
											text: 'La fecha de tu solicitud de cita ha expirado, selecciona otra fecha disponible.',
											icon: 'error',
											confirmButtonColor: '#0052d4',
											confirmButtonText: 'Ok',
										}).then(() => {
											window.location.reload();
										});

										mostrarNotificacion = false;
									}
								}
							}, 3000);
						}
					}

					$('#exampleModal').on('hidden.bs.modal', function(event) {
						clearInterval(interval);
					});

					const calendar = $('#CalendarioWeb').fullCalendar({
						dayClick: async function(date, jsEvent, view, resourceObj) {

							/* const calendar = $('#CalendarioWeb').fullCalendar('getCalendar');
							const [data] = calendar.getEventSources();
							const DATA_FULLCALENDAR_DISABLED = (data.rawEventDefs || []).filter((d) => d.rendering); */
							const DATA_FULLCALENDAR_DISABLED = await listarFechasDesabilitadas();
							console.log('DATA_FULLCALENDAR_DISABLED', DATA_FULLCALENDAR_DISABLED);

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

							console.log('citasMapDisabled', citasMapDisabled);

							for (const [i, fechaDisabled] of citasMapDisabled.entries()) {
								for (const fecha of [date.format()]) {
									if (fechaDisabled.rangoDeFechasRegistradas.includes(fecha)) {
										laCitaIncluyeEnElRangoDeFechasDisabled = true;
										index = i;
										break;
									}
								}
							}
							console.log('laCitaIncluyeEnElRangoDeFechasDisabled', laCitaIncluyeEnElRangoDeFechasDisabled)
							if (laCitaIncluyeEnElRangoDeFechasDisabled) {
								Swal.fire({
									title: 'Fecha no disponible',
									text: 'El profesional deshabilitó las citas para este día.',
									icon: 'error',
									confirmButtonColor: '#0052d4',
									confirmButtonText: 'Ok',
								});
								return;
							}


							document.getElementById("hora").innerHTML = "";
							sessionStorage.removeItem("dateCurrent");
							sessionStorage.removeItem("timeCurrent");

							const dateCurrent = new Date();
							const [year, month, day] = [dateCurrent.getFullYear(), dateCurrent.getMonth(), dateCurrent.getDate()];

							if (Date.parse(date.add(5, 'hours')) < Date.parse(new Date(year, month, day))) {

								Swal.fire({
									title: 'Fecha pasada',
									text: 'Selecciona un día a partir de la fecha actual.',
									icon: 'error',
									confirmButtonColor: '#0052d4',
									confirmButtonText: 'Ok',
								});

								return;

							}


							// GUARDAMOS LA FECHA SELECCIONADA EN LA SESSION
							sessionStorage.setItem("dateCurrent", date.format());

							$('.fechahoy').html(moment(date.format()).format('L'));
							$('#fechacitap').val(date.format());
							await listarDisponibilidad();
							$("#ModalEventos").modal();

							$(".ctn-si").click(function() {
								$(".ctn-si").css('background-color', 'white');
								$(this).css('background-color', '#F2F2F2');
							});

						},
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
						//"<?= ($_ENV['APP_URL'] . 'php/eventos.php?idpro=' . $idpro) ?>",
						eventClick: async function(data, jsEvent, view) {

							const isCancel = [
								"Programada... Únete con el link en la fecha y hora correspondientes.",
							];

							console.log('data.title', data.title);

							const $cancelarSolicitud = $("#cancelarSolicitud");
							if (isCancel.includes(data.title)) {
								$cancelarSolicitud.css('visibility', 'hidden');
							} else {
								$cancelarSolicitud.css('visibility', 'visible');
							}

							const isEquals = (data.id == "<?php echo $id ?>");
							if (isEquals) {
								$(".modal-dialog").css('display', 'block');
							} else {
								Swal.fire({
									title: 'Cita de otro paciente',
									text: 'Solo puedes ver la información de tus propias citas.',
									icon: 'error',
									confirmButtonColor: '#0052d4',
									confirmButtonText: 'Ok',
								});
								return;
							}
							/* $(".modal-dialog").css('display', isEquals ? 'block' : 'none');  */

							if (data.title == "<?= $_ENV['CITA_ENVIADA'] ?>") {
								var titcita = [
									"SOLICITUD DE CITA ENVIADA"
								];
							} else if (data.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
								var titcita = [
									"SOLICITUD DE CITA CONFIRMADA"
								];
							} else if (data.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
								var titcita = [
									"CITA PROGRAMADA"
								];
							} else if (data.title == "<?= $_ENV['CITA_VENCIDA'] ?>") {
								var titcita = [
									"CITA VENCIDA"
								];
							}

							if (data.sexoMedico == 'Femenino') {
								var doctor = [
									"Dra."
								];
							} else {
								var doctor = [
									"Dr."
								];
							}
							var psico = [
								data.especialidad
							];
							var idpac = [
								data.id
							];
							$("#idCita").val(data.idcita);
							$('#tituloEvento').html(`${titcita}`);
							$('#titEvento').html(data.title);
							const isConfirm = (data.title == "Confirmada... Realiza el pago de tu cita lo antes posible.");
							const $checkoutBtn = $("#btnpagar");
							$checkoutBtn.css('visibility', 'hidden');
							$('#nombrecita').html(`${data.nombresPaciente} ${data.apellidosPaciente}`);
							$('#nombreprocita').html(`${doctor} ${data.nombresMedico} ${data.apellidosMedico}`);
							$('#profcita').html(`${psico}`);
							$('#preciocita').html(`S/ ${data.localizacion}`);
							$('#bcfiled2').attr('href', '<?= $_ENV['APP_URL'] ?>hclinica/' + idpac + '/' + data.idpay);
							$('#linkcita').html(data.ubicacion);
							if (data.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
								$('#informes').css('display', 'flex');
							} else {
								$('#informes').css('display', 'none');
							}
							if (data.asistencia != "No asistió" && data.asistenciapac != "No asistió") {
								$('#bcfiled2').css('display', 'block');
							} else {
								$('#bcfiled2').css('display', 'none');
							}
							$('#pasistencia').html(data.asistencia);
							$('#pasistenciapac').html(data.asistenciapac);
							$("#linkcita").click(function() {
								window.open(data.ubicacion, '_blank');
							});
							const [fecha, hora] = data.start._i.split(" ");
							const [tinicial, tfinal] = hora.split(":00");
							$('#fechacita').html(`${moment(fecha).format('L')} a las ${tinicial}:00`);
							if (data.title == "<?= $_ENV['CITA_PROGRAMADA'] ?>") {
								$cancelarSolicitud.css('display', 'none');
							} else {
								$cancelarSolicitud.css('display', 'block');
							}
							if (data.title == "<?= $_ENV['CITA_CONFIRMADA'] ?>") {
								$checkoutBtn.css('visibility', 'visible');
								$checkoutBtn.css('display', 'block');
							} else {
								$checkoutBtn.css('visibility', 'hidden');
								$checkoutBtn.css('display', 'none');
							}

							$("#exampleModal").modal();

							if (isConfirm) {
								await send(data);
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
						<div class="modal-body modal-body2">
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
								<a id="bcfiled2">Historia Clínica</a>
							</div>

							<div class="historia4" id="btnpagar">
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-success" id="btnpago" data-toggle="modal" data-target="#modalPagar" style="background:#00d418;border:1px solid #00d418;font-size:14px;font-weight:500;padding:8px 20px" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';">
									Pagar Cita
								</button>

								<!-- Modal -->
								<div class="modal fade modpagar" id="modalPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modsegundo" role="document" id="msegundo">
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
														<br><a id="awsp" href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a>
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
							<button id="cancelarSolicitud" onclick="cancelarSolicitud()" class="btn btn-danger" style="background:#ff0800;border:1px solid #ff0000;font-size:14px;font-weight:500;padding:8px 20px" onmouseover="this.style.background='#e10800';this.style.border='1px solid #e10800';" onmouseout="this.style.background='#ff0000';this.style.border='1px solid #ff0000';">
								Cancelar Cita
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Modal (Agregar, modificar, eliminar) -->
			<div class="modal fade modal-selcon" id="ModalEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body modal-body2">
							<div class="selhora">
								<h5 class="modal-title" id="tituloEvento">SELECCIONA UNA HORA</h5>
								<hr>



								<div id="descripcionEvento">

									<div id="tablaPrueba2"></div>

									<?php
									include 'conexion_paciente.php';
									$idhor11 = $idhor12 = $idhor13 = $idhor14 = $idhor15 = $idhor16 = $idhor17 = $idhor21 = $idhor22 = $idhor23 = $idhor24 = $idhor25 = $idhor26 = $idhor27 =
										$idhor31 = $idhor32 = $idhor33 = $idhor34 = $idhor35 = $idhor36 = $idhor37 = $idhor41 = $idhor42 = $idhor43 = $idhor44 = $idhor45 = $idhor46 = $idhor47 =
										$idhor51 = $idhor52 = $idhor53 = $idhor54 = $idhor55 = $idhor56 = $idhor57 = $idhor61 = $idhor62 = $idhor63 = $idhor64 = $idhor65 = $idhor66 = $idhor67 =
										$idhor71 = $idhor72 = $idhor73 = $idhor74 = $idhor75 = $idhor76 = $idhor77 = $idhor81 = $idhor82 = $idhor83 = $idhor84 = $idhor85 = $idhor86 = $idhor87 =
										$idhor91 = $idhor92 = $idhor93 = $idhor94 = $idhor95 = $idhor96 = $idhor97 = $idhor101 = $idhor102 = $idhor103 = $idhor104 = $idhor105 = $idhor106 = $idhor107 =
										$idhor111 = $idhor112 = $idhor113 = $idhor114 = $idhor115 = $idhor116 = $idhor117 = $idhor121 = $idhor122 = $idhor123 = $idhor124 = $idhor125 = $idhor126 = $idhor127 =
										$idhor131 = $idhor132 = $idhor133 = $idhor134 = $idhor135 = $idhor136 = $idhor137 = $idhor141 = $idhor142 = $idhor143 = $idhor144 = $idhor145 = $idhor146 = $idhor147 =
										$idhor151 = $idhor152 = $idhor153 = $idhor154 = $idhor155 = $idhor156 = $idhor157 = $idhor161 = $idhor162 = $idhor163 = $idhor164 = $idhor165 = $idhor166 = $idhor167 =
										$idhor171 = $idhor172 = $idhor173 = $idhor174 = $idhor175 = $idhor176 = $idhor177 = $idhor181 = $idhor182 = $idhor183 = $idhor184 = $idhor185 = $idhor186 = $idhor187 =
										$idhor191 = $idhor192 = $idhor193 = $idhor194 = $idhor195 = $idhor196 = $idhor197 = $idhor201 = $idhor202 = $idhor203 = $idhor204 = $idhor205 = $idhor206 = $idhor207 =
										$idhor211 = $idhor212 = $idhor213 = $idhor214 = $idhor215 = $idhor216 = $idhor217 = $idhor221 = $idhor222 = $idhor223 = $idhor224 = $idhor225 = $idhor226 = $idhor227 =
										$idhor231 = $idhor232 = $idhor233 = $idhor234 = $idhor235 = $idhor236 = $idhor237 = $idhor241 = $idhor242 = $idhor243 = $idhor244 = $idhor245 = $idhor246 = $idhor247 = '';
									$CantidadMostrar = 192;
									// Validado  la variable GET
									$compag         = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag'];
									$TotalReg       = mysqli_query($conexion, "SELECT * FROM horarios");
									$totalr = mysqli_num_rows($TotalReg);
									//Se divide la cantidad de registro de la BD con la cantidad a mostrar 
									$TotalRegistro  = ceil($totalr / $CantidadMostrar);
									//Operacion matematica para mostrar los siquientes datos.
									$IncrimentNum = (($compag + 1) <= $TotalRegistro) ? ($compag + 1) : 0;
									//Consulta SQL
									$consultah = "SELECT * FROM horarios WHERE idupro = '" . $_GET['id'] . "' ORDER BY nhora ASC LIMIT " . (($compag - 1) * $CantidadMostrar) . " , " . $CantidadMostrar;
									$resultadoh = mysqli_query($conexion, $consultah);
									while ($rowh = mysqli_fetch_array($resultadoh)) {

										$rowh['idhor'] = $rowh['nhora'];
										if ($rowh['idhor'] == 11) {
											$idhor11 = '11';
										} else if ($rowh['idhor'] == 12) {
											$idhor12 = '12';
										} else if ($rowh['idhor'] == 13) {
											$idhor13 = '13';
										} else if ($rowh['idhor'] == 14) {
											$idhor14 = '14';
										} else if ($rowh['idhor'] == 15) {
											$idhor15 = '15';
										} else if ($rowh['idhor'] == 16) {
											$idhor16 = '16';
										} else if ($rowh['idhor'] == 17) {
											$idhor17 = '17';
										} else if ($rowh['idhor'] == 21) {
											$idhor21 = '21';
										} else if ($rowh['idhor'] == 22) {
											$idhor22 = '22';
										} else if ($rowh['idhor'] == 23) {
											$idhor23 = '23';
										} else if ($rowh['idhor'] == 24) {
											$idhor24 = '24';
										} else if ($rowh['idhor'] == 25) {
											$idhor25 = '25';
										} else if ($rowh['idhor'] == 26) {
											$idhor26 = '26';
										} else if ($rowh['idhor'] == 27) {
											$idhor27 = '27';
										} else if ($rowh['idhor'] == 31) {
											$idhor31 = '31';
										} else if ($rowh['idhor'] == 32) {
											$idhor32 = '32';
										} else if ($rowh['idhor'] == 33) {
											$idhor33 = '33';
										} else if ($rowh['idhor'] == 34) {
											$idhor34 = '34';
										} else if ($rowh['idhor'] == 35) {
											$idhor35 = '35';
										} else if ($rowh['idhor'] == 36) {
											$idhor36 = '36';
										} else if ($rowh['idhor'] == 37) {
											$idhor37 = '37';
										} else if ($rowh['idhor'] == 41) {
											$idhor41 = '41';
										} else if ($rowh['idhor'] == 42) {
											$idhor42 = '42';
										} else if ($rowh['idhor'] == 43) {
											$idhor43 = '43';
										} else if ($rowh['idhor'] == 44) {
											$idhor44 = '44';
										} else if ($rowh['idhor'] == 45) {
											$idhor45 = '45';
										} else if ($rowh['idhor'] == 46) {
											$idhor46 = '46';
										} else if ($rowh['idhor'] == 47) {
											$idhor47 = '47';
										} else if ($rowh['idhor'] == 51) {
											$idhor51 = '51';
										} else if ($rowh['idhor'] == 52) {
											$idhor52 = '52';
										} else if ($rowh['idhor'] == 53) {
											$idhor53 = '53';
										} else if ($rowh['idhor'] == 54) {
											$idhor54 = '54';
										} else if ($rowh['idhor'] == 55) {
											$idhor55 = '55';
										} else if ($rowh['idhor'] == 56) {
											$idhor56 = '56';
										} else if ($rowh['idhor'] == 57) {
											$idhor57 = '57';
										} else if ($rowh['idhor'] == 61) {
											$idhor61 = '61';
										} else if ($rowh['idhor'] == 62) {
											$idhor62 = '62';
										} else if ($rowh['idhor'] == 63) {
											$idhor63 = '63';
										} else if ($rowh['idhor'] == 64) {
											$idhor64 = '64';
										} else if ($rowh['idhor'] == 65) {
											$idhor65 = '65';
										} else if ($rowh['idhor'] == 66) {
											$idhor66 = '66';
										} else if ($rowh['idhor'] == 67) {
											$idhor67 = '67';
										} else if ($rowh['idhor'] == 71) {
											$idhor71 = '71';
										} else if ($rowh['idhor'] == 72) {
											$idhor72 = '72';
										} else if ($rowh['idhor'] == 73) {
											$idhor73 = '73';
										} else if ($rowh['idhor'] == 74) {
											$idhor74 = '74';
										} else if ($rowh['idhor'] == 75) {
											$idhor75 = '75';
										} else if ($rowh['idhor'] == 76) {
											$idhor76 = '76';
										} else if ($rowh['idhor'] == 77) {
											$idhor77 = '77';
										} else if ($rowh['idhor'] == 81) {
											$idhor81 = '81';
										} else if ($rowh['idhor'] == 82) {
											$idhor82 = '82';
										} else if ($rowh['idhor'] == 83) {
											$idhor83 = '83';
										} else if ($rowh['idhor'] == 84) {
											$idhor84 = '84';
										} else if ($rowh['idhor'] == 85) {
											$idhor85 = '85';
										} else if ($rowh['idhor'] == 86) {
											$idhor86 = '86';
										} else if ($rowh['idhor'] == 87) {
											$idhor87 = '87';
										} else if ($rowh['idhor'] == 91) {
											$idhor91 = '91';
										} else if ($rowh['idhor'] == 92) {
											$idhor92 = '92';
										} else if ($rowh['idhor'] == 93) {
											$idhor93 = '93';
										} else if ($rowh['idhor'] == 94) {
											$idhor94 = '94';
										} else if ($rowh['idhor'] == 95) {
											$idhor95 = '95';
										} else if ($rowh['idhor'] == 96) {
											$idhor96 = '96';
										} else if ($rowh['idhor'] == 97) {
											$idhor97 = '97';
										} else if ($rowh['idhor'] == 101) {
											$idhor101 = '101';
										} else if ($rowh['idhor'] == 102) {
											$idhor102 = '102';
										} else if ($rowh['idhor'] == 103) {
											$idhor103 = '103';
										} else if ($rowh['idhor'] == 104) {
											$idhor104 = '104';
										} else if ($rowh['idhor'] == 105) {
											$idhor105 = '105';
										} else if ($rowh['idhor'] == 106) {
											$idhor106 = '106';
										} else if ($rowh['idhor'] == 107) {
											$idhor107 = '107';
										} else if ($rowh['idhor'] == 111) {
											$idhor111 = '111';
										} else if ($rowh['idhor'] == 112) {
											$idhor112 = '112';
										} else if ($rowh['idhor'] == 113) {
											$idhor113 = '113';
										} else if ($rowh['idhor'] == 114) {
											$idhor114 = '114';
										} else if ($rowh['idhor'] == 115) {
											$idhor115 = '115';
										} else if ($rowh['idhor'] == 116) {
											$idhor116 = '116';
										} else if ($rowh['idhor'] == 117) {
											$idhor117 = '117';
										} else if ($rowh['idhor'] == 121) {
											$idhor121 = '121';
										} else if ($rowh['idhor'] == 122) {
											$idhor122 = '122';
										} else if ($rowh['idhor'] == 123) {
											$idhor123 = '123';
										} else if ($rowh['idhor'] == 124) {
											$idhor124 = '124';
										} else if ($rowh['idhor'] == 125) {
											$idhor125 = '125';
										} else if ($rowh['idhor'] == 126) {
											$idhor126 = '126';
										} else if ($rowh['idhor'] == 127) {
											$idhor127 = '127';
										} else if ($rowh['idhor'] == 131) {
											$idhor131 = '131';
										} else if ($rowh['idhor'] == 132) {
											$idhor132 = '132';
										} else if ($rowh['idhor'] == 133) {
											$idhor133 = '133';
										} else if ($rowh['idhor'] == 134) {
											$idhor134 = '134';
										} else if ($rowh['idhor'] == 135) {
											$idhor135 = '135';
										} else if ($rowh['idhor'] == 136) {
											$idhor136 = '136';
										} else if ($rowh['idhor'] == 137) {
											$idhor137 = '137';
										} else if ($rowh['idhor'] == 141) {
											$idhor141 = '141';
										} else if ($rowh['idhor'] == 142) {
											$idhor142 = '142';
										} else if ($rowh['idhor'] == 143) {
											$idhor143 = '143';
										} else if ($rowh['idhor'] == 144) {
											$idhor144 = '144';
										} else if ($rowh['idhor'] == 145) {
											$idhor145 = '145';
										} else if ($rowh['idhor'] == 146) {
											$idhor146 = '146';
										} else if ($rowh['idhor'] == 147) {
											$idhor147 = '147';
										} else if ($rowh['idhor'] == 151) {
											$idhor151 = '151';
										} else if ($rowh['idhor'] == 152) {
											$idhor152 = '152';
										} else if ($rowh['idhor'] == 153) {
											$idhor153 = '153';
										} else if ($rowh['idhor'] == 154) {
											$idhor154 = '154';
										} else if ($rowh['idhor'] == 155) {
											$idhor155 = '155';
										} else if ($rowh['idhor'] == 156) {
											$idhor156 = '156';
										} else if ($rowh['idhor'] == 157) {
											$idhor157 = '157';
										} else if ($rowh['idhor'] == 161) {
											$idhor161 = '161';
										} else if ($rowh['idhor'] == 162) {
											$idhor162 = '162';
										} else if ($rowh['idhor'] == 163) {
											$idhor163 = '163';
										} else if ($rowh['idhor'] == 164) {
											$idhor164 = '164';
										} else if ($rowh['idhor'] == 165) {
											$idhor165 = '165';
										} else if ($rowh['idhor'] == 166) {
											$idhor166 = '166';
										} else if ($rowh['idhor'] == 167) {
											$idhor167 = '167';
										} else if ($rowh['idhor'] == 171) {
											$idhor171 = '171';
										} else if ($rowh['idhor'] == 172) {
											$idhor172 = '172';
										} else if ($rowh['idhor'] == 173) {
											$idhor173 = '173';
										} else if ($rowh['idhor'] == 174) {
											$idhor174 = '174';
										} else if ($rowh['idhor'] == 175) {
											$idhor175 = '175';
										} else if ($rowh['idhor'] == 176) {
											$idhor176 = '176';
										} else if ($rowh['idhor'] == 177) {
											$idhor177 = '177';
										} else if ($rowh['idhor'] == 181) {
											$idhor181 = '181';
										} else if ($rowh['idhor'] == 182) {
											$idhor182 = '182';
										} else if ($rowh['idhor'] == 183) {
											$idhor183 = '183';
										} else if ($rowh['idhor'] == 184) {
											$idhor184 = '184';
										} else if ($rowh['idhor'] == 185) {
											$idhor185 = '185';
										} else if ($rowh['idhor'] == 186) {
											$idhor186 = '186';
										} else if ($rowh['idhor'] == 187) {
											$idhor187 = '187';
										} else if ($rowh['idhor'] == 191) {
											$idhor191 = '191';
										} else if ($rowh['idhor'] == 192) {
											$idhor192 = '192';
										} else if ($rowh['idhor'] == 193) {
											$idhor193 = '193';
										} else if ($rowh['idhor'] == 194) {
											$idhor194 = '194';
										} else if ($rowh['idhor'] == 195) {
											$idhor195 = '195';
										} else if ($rowh['idhor'] == 196) {
											$idhor196 = '196';
										} else if ($rowh['idhor'] == 197) {
											$idhor197 = '197';
										} else if ($rowh['idhor'] == 201) {
											$idhor201 = '201';
										} else if ($rowh['idhor'] == 202) {
											$idhor202 = '202';
										} else if ($rowh['idhor'] == 203) {
											$idhor203 = '203';
										} else if ($rowh['idhor'] == 204) {
											$idhor204 = '204';
										} else if ($rowh['idhor'] == 205) {
											$idhor205 = '205';
										} else if ($rowh['idhor'] == 206) {
											$idhor206 = '206';
										} else if ($rowh['idhor'] == 207) {
											$idhor207 = '207';
										} else if ($rowh['idhor'] == 211) {
											$idhor211 = '211';
										} else if ($rowh['idhor'] == 212) {
											$idhor212 = '212';
										} else if ($rowh['idhor'] == 213) {
											$idhor213 = '213';
										} else if ($rowh['idhor'] == 214) {
											$idhor214 = '214';
										} else if ($rowh['idhor'] == 215) {
											$idhor215 = '215';
										} else if ($rowh['idhor'] == 216) {
											$idhor216 = '216';
										} else if ($rowh['idhor'] == 217) {
											$idhor217 = '217';
										} else if ($rowh['idhor'] == 221) {
											$idhor221 = '221';
										} else if ($rowh['idhor'] == 222) {
											$idhor222 = '222';
										} else if ($rowh['idhor'] == 223) {
											$idhor223 = '223';
										} else if ($rowh['idhor'] == 224) {
											$idhor224 = '224';
										} else if ($rowh['idhor'] == 225) {
											$idhor225 = '225';
										} else if ($rowh['idhor'] == 226) {
											$idhor226 = '226';
										} else if ($rowh['idhor'] == 227) {
											$idhor227 = '227';
										} else if ($rowh['idhor'] == 231) {
											$idhor231 = '231';
										} else if ($rowh['idhor'] == 232) {
											$idhor232 = '232';
										} else if ($rowh['idhor'] == 233) {
											$idhor233 = '233';
										} else if ($rowh['idhor'] == 234) {
											$idhor234 = '234';
										} else if ($rowh['idhor'] == 235) {
											$idhor235 = '235';
										} else if ($rowh['idhor'] == 236) {
											$idhor236 = '236';
										} else if ($rowh['idhor'] == 237) {
											$idhor237 = '237';
										} else if ($rowh['idhor'] == 241) {
											$idhor241 = '241';
										} else if ($rowh['idhor'] == 242) {
											$idhor242 = '242';
										} else if ($rowh['idhor'] == 243) {
											$idhor243 = '243';
										} else if ($rowh['idhor'] == 244) {
											$idhor244 = '244';
										} else if ($rowh['idhor'] == 245) {
											$idhor245 = '245';
										} else if ($rowh['idhor'] == 246) {
											$idhor246 = '246';
										} else if ($rowh['idhor'] == 247) {
											$idhor247 = '247';
										}
									}
									?>
									<script>
										$(document).ready(() => {
											$(".fc-past").click(function() {
												/* $(".modal-dialog").css('display','none');  */
											});
											$(".fc-today").click(function() {
												/* $(".modal-dialog").css('display','none');  */
											});
											$(".fc-future").click(function() {
												/* $(".modal-dialog").css('display','block'); */
												$(".table-day").css('display', 'none');
												/* $(".confhora").css('display','none');*/
												/* $(".checkout-btn").css('display','none');  */
											});
											$(".fc-mon.fc-future").click(function() {
												$("#table-mon").css('display', 'block');
											});
											$(".fc-tue.fc-future").click(function() {
												$("#table-tue").css('display', 'block');
											});
											$(".fc-wed.fc-future").click(function() {
												$("#table-wed").css('display', 'block');
											});
											$(".fc-thu.fc-future").click(function() {
												$("#table-thu").css('display', 'block');
											});
											$(".fc-fri.fc-future").click(function() {
												$("#table-fri").css('display', 'block');
											});
											$(".fc-sat.fc-future").click(function() {
												$("#table-sat").css('display', 'block');
											});
											$(".fc-sun.fc-future").click(function() {
												$("#table-sun").css('display', 'block');
											});
										});
									</script>

								</div>
							</div>

							<?php
							/* require 'vendor/autoload.php';
								MercadoPago\SDK::setAccessToken('TEST-710512657271520-052718-c160d571a6b513642b0d251479e8d9c8-1122427376');
								$preference = new MercadoPago\Preference();

								$productos_mp = array();

								$item = new MercadoPago\Item();
								$item -> id = $idpro;
								$item -> title = 'Dr. '.$nombrespro.' '.$apellidospro;
								$item -> picture_url = "./fotoperfilpro/$fotoperfilpro";
								$item -> description = "$profesion.', '.$especialidad";
								$item -> quantity = 1;
								$item -> unit_price = $precio;
								$item -> currency_id = 'PEN';

								array_push($productos_mp, $item);
								unset($item); */
							?>
							<div class="confirmarcita">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title" id="tituloEvento">SOLICITUD DE CITA</h5>
								<hr>
								<div id="descripcionEvento">
									<p><span>Paciente:</span><br><?php echo $nombres . ' ' . $apellidos ?></p><br>
									<p><span>Profesional:</span><br><?php echo $doctor . ' ' . $nombrespro . ' ' . $apellidospro ?></p><br>
									<p><span>Especialidad:</span><br><?php echo $especialidad ?></p><br>
									<p><span>Fecha de cita:</span>
									<div class="fechahoy"></div>
									</p><br>
									<p id="horacita"><span>Hora de cita:</span></p>
									<p class="confhora" id="hora"></p><br>
									<p id="confprecio"><span>Precio de cita:</span><br>S/ <?php echo $precio ?></p><br>
								</div>
								<div class="modal-footer">
									<!-- data-dismiss="modal"  -->
									<button type="button" class="btn btn-primary" id="btnenviar" style="background:#00d418;border:1px solid #00d418;font-size:14px;font-weight:500;padding:8px 20px" onmouseover="this.style.background='#00ee1b';this.style.border='1px solid #00ee1b';" onmouseout="this.style.background='#00d418';this.style.border='1px solid #00d418';" onclick="enviarSolicitud('<?php echo $nombres ?>', '<?php echo $apellidos ?>')">Enviar Solicitud</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<?php
	/* $preference -> items = $productos_mp;
	$preference -> back_urls = array(
		"success" => "http://localhost/themeduni/cita.php/$idpro",
		"failure" => "http://localhost/themeduni/cita.php/$idpro",
		"pending" => "http://localhost/themeduni/cita.php/$idpro"
	);ol
	$preference -> auto_return = "approved";
	$preference -> save(); */


	?>
	<script>
		/* const mp = new MercadoPago('TEST-5f67ff03-8642-4858-b58f-e6b465bb0e6f', {
			locale: 'es-PE'
		});
		mp.checkout({
			preference: {
				id: '<?php echo $preference->id; ?>'
			},
			render: {
				container: '.checkout-btn',
				label: 'Confirmar y Pagar',
			},
		}) */
	</script>
</body>
<?php echo footermed(); ?>

</html>