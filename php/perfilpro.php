<?php

$_GET['id'] = explode("/", $_GET['view'])[1];
if (isset($_GET['id']) && @$_GET['id'] == @$_SESSION['idpro']) {
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
            $profesion = "Médico";
            $boton = "https://www.cmp.org.pe/conoce-a-tu-medico/";
            if ($especialidad == "Psicología") {
                $profesion = "Psicólogo";
                $boton = "https://cpsp.pe/colegiados/";
                $verificar = "Comprobar Psicólogo";
            }
            $precio = $row['precio'];
            $telefono = $row['telefono'];
            $fotoperfilpro = $row['fotoperfilpro'];
            $fototitulo = $row['fototitulo'];
            $fotocolegiatura = $row['fotocolegiatura'];
            $fotodocumento = $row['fotodocumento'];
            $estado = $row['estado'];
            $indicaciones = $row['indicaciones'];
            if ($sexopro == "Femenino") {
                $verificar = "Comprobar Médico";
                $doctor = "Dra.";
                if ($especialidad == "Psicología") {
                    $verificar = "Comprobar Psicólogo";
                }
            } else {
                $verificar = "Comprobar Médico";
                $doctor = "Dr.";
                if ($especialidad == "Psicología") {
                    $verificar = "Comprobar Psicólogo";
                }
            }
            $timestampNac = strtotime($nacimientopro);
            $newDateNac = date("d/m/Y", $timestampNac);
            $timestampEnmu = strtotime($enmu);
            $newDateEnmu = date("d/m/Y", $timestampEnmu);
            date_default_timezone_set("America/Lima");
            $fechaHoy = date('Y-m-d');
        }
    }
    $consulta2 = "SELECT COUNT(title) FROM citas WHERE idupro = '" . $_GET['id'] . "' AND idpay <> '0' AND asistencia <> 'No asistió' AND asistenciapac <> 'No asistió' ";
    $resultado2 = mysqli_query($conexion, $consulta2);
    if ($resultado2) {
        while ($row2 = $resultado2->fetch_array()) {
            $nrocitas = $row2['COUNT(title)'];
        }
    }
} else {
    //header("Location: " . $_ENV['APP_URL'] . "perfilpro/" . $_SESSION['idpro']);
    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfilpro/" . $_SESSION['idpro'] . "'</script>";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $doctor . ' ' . $nombrespro . ' ' . $apellidospro ?> - The Med Universe | Profesional</title>
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/navpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/perfilpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        .isMovil {
            display: block !important;
        }

        @media screen and (min-width: 768px) {
            .isMovil {
                display: none !important;
            }
        }
    </style>

</head>

<body id="body">
<a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank" class="btn-wsp"><i class="fa-brands fa-whatsapp"></i></a>
    <?php echo headernav() ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/m&obpro.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        const Valoraciones = function() {};
        Valoraciones.prototype.registrarValoracion = async function({
            valoracion,
            comentarios
        }) {

            const formData = new FormData();
            formData.append("method", "registrarValoracion");
            formData.append("idu", "0");
            formData.append("idupro", <?= $_GET['id'] ?>);
            formData.append("valoracion", valoracion.toString());
            formData.append("comentarios", comentarios);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                method: "post",
                body: formData
            });
            const text = await response.text();
            return text;
        };

        Valoraciones.prototype.listarValoraciones = async function() {
            const formData = new FormData();
            formData.append("method", "listarValoraciones");
            /* formData.append("idu", <?= $_SESSION['id'] ?>); */
            formData.append("idupro", <?= $_GET['id'] ?>);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                method: "post",
                body: formData
            });
            const valoraciones = await response.json();

            let estrellas = [{
                    estrella: 1,
                    total: 0
                },
                {
                    estrella: 2,
                    total: 0
                },
                {
                    estrella: 3,
                    total: 0
                },
                {
                    estrella: 4,
                    total: 0
                },
                {
                    estrella: 5,
                    total: 0
                },
            ];

            valoraciones.forEach(({
                valoracion
            }) => {
                estrellas = estrellas.map((e) => {
                    if (e.estrella == valoracion) {
                        e.total += 1;
                    }
                    return {
                        ...e
                    };
                });
            });

            const totales = estrellas.reduce((previousValue, currentValue) => {
                return previousValue + currentValue.total;
            }, 0);

            /* console.log('estrellas', estrellas) */
            const promedioValoreaciones = estrellas.reduce((previousValue, currentValue) => {
                return previousValue + (currentValue.estrella * currentValue.total);
            }, 0);

            // 
            document.getElementById("promedioValoraciones").innerHTML = ((promedioValoreaciones / totales) || 0).toFixed(1);
            $("#starsValoraciones").rateYo("option", "rating", ((promedioValoreaciones / totales) || 0).toFixed(1));
            $("#rateYo").rateYo("option", "rating", ((promedioValoreaciones / totales) || 0).toFixed(1));
            // 
            document.getElementById("totalValoraciones").innerHTML = totales;

            // 
            document.getElementById("valoracionEstrellas").innerHTML = estrellas
                .reverse()
                .reduce((previousValue, currentValue) => {
                    let html = '<p id="nrobar5">';
                    html += `${currentValue.estrella}`;
                    html += `<progress value="${currentValue.total}" max="${totales}" style="width:100%;">`;
                    html += '</progress>';
                    html += '</p>';

                    return `${previousValue} ${html}`;
                }, "");

            // LISTANDO LOS COMENTARIOS
            document.getElementById("listaDeComentarios").innerHTML = valoraciones
                .filter(({
                    valoracion
                }) => {
                    return valoracion == 0;
                })
                .map(({
                    comentarios,
                    ...others
                }) => {
                    const arrayComentarios = JSON.parse(comentarios);
                    if (!arrayComentarios[0]) return {
                        ...others,
                        comentarios: []
                    };
                    return {
                        ...others,
                        comentarios: arrayComentarios.map((c) => JSON.parse(c))
                    };
                })
                .reduce((previousValue, currentValue) => {

                    let htmlComentarios = `<div class="divcomment">`;

                    for (const [indice, comentario] of currentValue.comentarios /* .reverse() */ .entries()) {
                        moment.locale("es");
                        var fechaReg = moment(comentario.fecha).format('L');
                        if (!indice) {
                            htmlComentarios += `<p class="ctn-comentario">`;
                            if ("<?= $_SESSION['idpro'] ?>" == currentValue.idupro && comentario.esMedicoOPaciente == "MEDICO") {
                                htmlComentarios += `<label id="labelx" onclick="new Valoraciones().eliminarComentario(${currentValue.id})"><i class="fa-solid fa-square-xmark"></i></label>`;
                            }
                            htmlComentarios += ` <strong>${comentario.nombres}:</strong><br> ${comentario.comentario}<br> <span> ${fechaReg}</span></p>`;
                            if ( /* !indice &&  */ currentValue.comentarios.length == 2) {
                                htmlComentarios += `<a class="verrespuesta" href="" onclick="mostrarRespuestas(event, ${currentValue.id})">Ver respuesta</a>`;
                            } else if ( /* !indice &&  */ currentValue.comentarios.length > 2) {
                                htmlComentarios += `<a class="verrespuesta" href="" onclick="mostrarRespuestas(event, ${currentValue.id})">Ver ${(currentValue.comentarios.length - 1)} respuestas</a>`;
                            }
                        } else {
                            htmlComentarios += `<p class="ctn-comentario comentario${currentValue.id}" style="display:none;">`;
                            if ("<?= $_SESSION['idpro'] ?>" == comentario.idUser && comentario.esMedicoOPaciente == "MEDICO") {
                                htmlComentarios += `<label id="labelx" onclick="new Valoraciones().eliminarRespuesta(${currentValue.id}, ${indice})"><i class="fa-solid fa-square-xmark"></i></label>`;
                            }
                            htmlComentarios += ` <strong>${comentario.nombres}:</strong><br> ${comentario.comentario}<br> <span> ${fechaReg}</span></p>`;
                        }


                    }
                    htmlComentarios += `</div>`;

                    /* const htmlComentarios = currentValue.comentarios.reverse().reduce((pV, cV) => {
                        let html = `<p class="ctn-comentario"><strong>${cV.nombres}:</strong><br> ${cV.comentario}</p>`;
                        
                        return `${pV}${html}`;
                    }, ""); */

                    if ("<?= $estado ?>" == '2') {
                        return `${previousValue} <hr id="hrvc"><div class="box-comentario">${htmlComentarios}</div>`;
                    } else {
                        var boxRes = "";
                        if (currentValue.comentarios.length >= 2) {
                            var boxRes = "none";
                        } else {
                            var boxRes = "block";
                        }
                        const inputRespuesta = `<textarea 
                        placeholder="Responder el comentario..." 
                        onkeypress="event.keyCode == 13 && window.innerWidth > 768 ? new Valoraciones().responseComentario(event, ${currentValue.id}) : true" 
                        class="rescomentario" 
                        id="response${currentValue.id}" 
                        rows="3" 
                        style="display:${boxRes}"></textarea>
                        <button class="btn btn-primary btn-block isMovil" onclick="new Valoraciones().responseComentario(event, ${currentValue.id})">Publicar</button>`;
                        return `${previousValue} <hr id="hrvc"><div class="box-comentario">${htmlComentarios}${inputRespuesta}</div>`;
                    }

                }, "");

            return 3;

        };

        Valoraciones.prototype.responseComentario = async function(e, idComentario) {
            try {
                const idComentarioTextarea = document.getElementById(`response${idComentario}`);
                console.log('idComentarioTextarea', idComentarioTextarea)
                if (!new RegExp("\\S{1,}").test(e?.target?.value || idComentarioTextarea?.value)) {
                    // quizas se agrega alguna laerta o texto
                    return;
                }

                <?php
                $nombresMedico = $sexopro == "Masculino" ? "Dr. " : "Dra. ";
                $nombresMedico .= $nombrespro . " ";
                $nombresMedico .= $apellidospro;
                ?>
                const formData = new FormData();
                formData.append("method", "responseComentario");
                formData.append("idComentario", idComentario);
                formData.append("comentario", JSON.stringify({
                    idUser: <?= $_SESSION['idpro'] ?>,
                    nombres: "<?= $nombresMedico ?>",
                    esMedicoOPaciente: "MEDICO",
                    comentario: (e?.target?.value || idComentarioTextarea?.value).trim().replace(/[^\x20-\x7E]/gmi, "").replace(/(\r\n|\n|\r)/gm, ""),// remplazamos los saltos de linea y retornos de carro,
                    visto: "NO",
                    fecha: moment().format("YYYY-MM-DD HH:mm:ss")
                }));

                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                    method: "post",
                    body: formData
                });
                const valoraciones = await response.text();

                await new Valoraciones().listarValoraciones();

                const boxResponse = document.getElementById("response" + idComentario);
                boxResponse.style.display = 'none';
            } catch (error) {
                //R console.log('error', error)
            }
        };

        /*Valoraciones.prototype.registrarComentario = async function(e) {

            if (!new RegExp("\\S{1,}").test(e.target.value)) {
                // quizas se agrega alguna laerta o texto
                return;
            }

            <?php
            $nombresMedico = $sexopro == "Masculino" ? "Dr. " : "Dra. ";
            $nombresMedico .= $nombrespro . " ";
            $nombresMedico .= $apellidospro;
            ?>

            const $comentario = $("#comentario");
            await new Valoraciones().registrarValoracion({
                valoracion: 0,
                comentarios: JSON.stringify({
                    "idUser": <?= $_GET['id'] ?>,
                    "nombres": "<?= $nombresMedico ?>",
                    "esMedicoOPaciente": "MEDICO",
                    "comentario": $comentario.val().trim(),
                    fecha: moment().format("YYYY-MM-DD hh:mm:ss")
                })
            });
            await new Valoraciones().listarValoraciones();

            $comentario.val("");
        };

        Valoraciones.prototype.eliminarComentario = async function(id) {

            const formData = new FormData();
            formData.append("method", "eliminarComentario");
            formData.append("id", id);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                method: "post",
                body: formData
            });
            const text = await response.text();

            await this.listarValoraciones();
        };*/

        Valoraciones.prototype.eliminarRespuesta = async function(id, indice) {

            const formData = new FormData();
            formData.append("method", "eliminarRespuesta");
            formData.append("id", id);
            formData.append("indice", indice);

            const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                method: "post",
                body: formData
            });
            const text = await response.text();

            await this.listarValoraciones();

            const boxResponse = document.getElementById("response" + id);
            boxResponse.style.display = 'block';
        };

        function mostrarRespuestas(e, idComentario) {
            e.preventDefault();
            e.target.style.display = "none";
            $(`.comentario${idComentario}`).toggle();
        }

        $(document).ready(async function() {
            const $rateYo = $("#rateYo");
            $rateYo.rateYo({
                readOnly: true,
                starWidth: "35px",
                normalFill: "#e5e5e5",
                ratedFill: "#fff600",
                spacing: "3px",
                rating: 0,
            });

            $("#starsValoraciones").rateYo({
                starWidth: "18px",
                spacing: "1px",
                rating: 0,
                normalFill: "#e5e5e5",
                ratedFill: "#fff600",
                readOnly: true,
            });

            await new Valoraciones().listarValoraciones();



        });

        const sendForm = async ($event, $this, idForm) => {

            $event.preventDefault();

            const form = document.getElementById(idForm);

            const formElements = form.querySelectorAll("input, textarea, select");
            for (const element of formElements) {
                if (element.hasAttribute("required")) {
                    if (!new RegExp("\\S{1,}").test(element?.value?.trim())) {
                        const {
                            isConfirmed
                        } = await Swal.fire({
                            title: 'Información profesional',
                            text: 'Ingrese información acerca de su trayectoria profesional como estudios, experiencia laboral, investigaciones, etc.',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#0052d4',
                            confirmButtonText: 'Ok',
                        });
                        return false;
                    }
                }
            }

            const formData = new FormData(form);
            formData.append($this.getAttribute("name"), $this.getAttribute("name"));
            const response = await fetch("", {
                method: "post",
                body: formData
            });
            await response.text();

            window.location.reload();
        }
    </script>
    <!-- >>>>>>> 7c75193bd3fdafca32aedd2a0e46eed6ba03a173 -->
    <main>
        <div class="filauno">
            <div class="ctn-sideperfil">
                <form id="formFoto" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                    <div class="ctn-fotoperfil">
                        <img src="<?php echo $_ENV['APP_URL'] . 'fotoperfilpro/mini_' . $fotoperfilpro . "?v=" . rand() ?>" class="zoom-effect" id="fppro" alt="Foto de perfil" data-toggle="modal" data-target="#modalFotoPerfil">
                    </div>
                    <div class="ctn-previeimage" id="previewperfil">
                        <canvas id="canvasPerfil" style="display:none"></canvas>
                    </div>
                    <a href="<?php echo $boton; ?>" target="_blank" class="colegiatura" id="comprob-coleg2"><?php echo $verificar; ?></a>
                    <div class="ctn-editarfp" id="labelfoto">
                        <input type="file" name="bbfile2" id="bbfile2" accept="image/*">
                        <label for="bbfile2" name="bbfile" id="bbfile">Editar</label>
                    </div>
                    <div class="ctn-guardarfp" id="ctn-editfoto">
                        <input type="submit" name="editfoto" id="editfoto" value="Guardar"><br>
                    </div>
                </form>
            </div>
            <!-- Modal -->
<div class="modal fade" id="modalFotoPerfil" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $_ENV['APP_URL'] . "fotoperfilpro/" . $fotoperfilpro . "?v=" . rand()?>" alt="Foto de perfil agrandada" id="modalFotoAgrandada">
            </div>
        </div>
    </div>
</div>
            <?php
            if (isset($_POST['editfoto'])) {
                $tips = 'jpg';
                $type = array('image/jpeg' => 'jpg');

                $nombrefoto1 = $_FILES['bbfile2']['name'];
                $ruta1 = $_FILES['bbfile2']['tmp_name'];
                $name = $_SESSION["idpro"] . '.' . $tips;
                $destino1 = "fotoperfilpro/" . $name;
                $destinoMini = "fotoperfilpro/mini_" . $name;

                file_put_contents($destinoMini, base64_decode($_POST['fotoMini']));

                if (is_uploaded_file($ruta1)) {
                    copy($ruta1, $destino1);
                }
                $sql = mysqli_query($conexion, "UPDATE usuariospro SET fotoperfilpro = '$name', ultimaedicion = '$fechaHoy' WHERE idpro = '" . $idpro . "' ");
                if ($sql) {
                    header("location: perfilpro/" . $idpro . "");
                }
            }
            ?>
            <div class="ctn-perfil perfilpro-" id="perfil1">

                <div class="ctn-editarp">
                    <h2>INFORMACIÓN PERSONAL</h2>
                    <div class="divinper">
                        <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                    </div>
                </div>
                <hr id="edit-infb">
                <div class="ctn-infbasica">
                    <h2 id="nombreperfil"><?php echo $doctor . ' ' . $nombrespro . ' ' . $apellidospro ?></h2>
                    <hr>
                    <?php
                    $fecha = time() - strtotime($nacimientopro);
                    $edad = floor($fecha / 31556926);
                    if($edad=='1'){
                        $año=" año";
                    }else{
                        $año=" años";
                    }
                    ?>
                    <p id="nacimientoperfil"><span>Fecha de nacimiento<span class="spanedad"> (Edad)</span>:</span> <?php echo $newDateNac ?><span class="spanedad" id="idedad"> (<?php echo $edad.$año ?>)</span></p>
                    <p id="edadperfil"><span>Edad:</span> <?php echo $edad ?> años</p>
                    <p id="sexoperfil"><span>Género:</span> <?php echo $sexopro ?></p><br>
                    <p id="paisperfil"><span>País (Idioma):</span> <?php echo $paispro ?> (<?php echo $idiomapro ?>)</p>
                    <p id="ciudadperfil"><span>Ciudad:</span> <?php echo $ciudadpro ?></p><br>
                    <hr>
                    <p id="profesionperfil"><span>Profesión:</span> <?php echo $profesion ?></p>
                    <p id="especialidadperfil"><span>Especialidad:</span> <?php echo $especialidad ?></p><br>
                    <p id="enmudesde"><span>En The Med Universe desde:</span> <?php echo $newDateEnmu ?></p>
                    <p id="consultasperfil"><span>Citas en The Med Universe:</span> <?php echo $nrocitas ?></p><br>
                    <hr>
                    <p id="precioperfil"><span>Precio de cita:</span> S/ <?php echo $precio ?></p>
                    <p id="colegiaturaperfil"><span>N° de colegiatura:</span> <?php echo $colegiatura ?></p>
                </div>
            </div>
            <div class="ctn-perfil2" id="perfil2">
                <form action="" method="post" name="form2" id="form2">
                    <div class="ctn-editarp">
                        <h2>INFORMACIÓN PERSONAL</h2>
                        <div class="divinper">
                            <div class="ctn-guardarip" id="ctn-editip">
                                <input type="submit" name="editip" id="editip" value="Guardar">
                            </div>
                        </div>
                    </div>
                    <hr id="edit-infb">
                    <div class="ctn-infbasica">
                        <h2 id="nombreperfil"><?php echo $doctor ?><input type="text" placeholder="Nombres" value="<?php echo $nombrespro ?>" name="nombres" id="nombres" maxlength="50" required><input type="text" placeholder="Apellidos" value="<?php echo $apellidospro ?>" name="apellidos" id="apellidos" maxlength="50"></h2>
                        <hr>
                        <p id="nacimientoperfil"><span>Fecha de nacimiento:</span><input type="date" name="nacimiento" id="nacimiento" min="1905-01-01" value="<?php echo $nacimientopro ?>"></p>
                        <p id="sexoperfil"><span>Género:</span><select name="sexo" id="sexo">
                                <option class="select-opt" selected><?php echo $sexopro ?></option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select></p><br>
                        <p id="paisperfil2"><span>País (Idioma):</span><select name="pais" id="pais">
                                <option class="select-opt" selected><?php echo $paispro ?></option>
                                <?php

                                include 'conexion_paciente.php';

                                $selectm = "SELECT * FROM paises";
                                $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                                ?>

                                <?php foreach ($ejecutar as $opciones) : ?>

                                    <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>

                                <?php endforeach ?>
                            </select>(<select name="idioma" id="idioma">
                                <option class="select-opt" selected><?php echo $idiomapro ?></option>
                                <?php

                                include 'conexion_paciente.php';

                                $selectm = "SELECT * FROM idiomas";
                                $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                                ?>

                                <?php foreach ($ejecutar as $opciones) : ?>

                                    <option value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>

                                <?php endforeach ?>
                            </select>)</p>
                        <p id="ciudadperfil2"><span>Ciudad:</span><input type="text" placeholder="Ciudad" name="ciudad" id="ciudad" value="<?php echo $ciudadpro ?>" maxlength="50"></p><br>
                        <hr>
                        <p id="profesionperfil"><span>Profesión:</span> <?php echo $profesion ?></p>
                        <?php
                        if ($especialidad == "Psicología") {
                            $_POST['especialidad'] = "Psicología";
                        ?>
                            <p id="especialidadperfil"><span>Especialidad:</span> <?php echo $especialidad ?></p><br>
                        <?php
                        } else {
                        ?>
                            <p id="especialidadperfil"><span>Especialidad:</span><select name="especialidad" id="especialidad">
                                    <option class="select-opt" selected><?php echo $especialidad ?></option>
                                    <?php

                                    include 'conexion_paciente.php';

                                    $selectm = "SELECT * FROM especialidades WHERE nombre <> 'Psicología'";
                                    $ejecutar = mysqli_query($conexion, $selectm) or die(mysqli_error($conexion));

                                    ?>

                                    <?php foreach ($ejecutar as $opciones) : ?>

                                        <option name="so" id="so" value="<?php echo $opciones['nombre'] ?>"><?php echo $opciones['nombre'] ?></option>

                                    <?php endforeach ?>
                                </select></p><br>
                        <?php
                        }
                        ?>
                        <p id="enmudesde2"><span>En The Med Universe desde:</span> <?php echo $newDateEnmu ?></p>
                        <p id="consultasperfil2"><span>Citas en The Med Universe:</span> <?php echo $nrocitas ?></p><br>
                        <hr>
                        <p id="precioperfil"><span>Precio de cita:</span><input type="number" placeholder="(S/) Precio de cita" id="precio" min="0" name="precio" value="<?php echo $precio ?>"></p>
                        <p id="colegiaturaperfil"><span>N° de colegiatura:</span><input type="number" placeholder="N° de colegiatura" id="colegiatura" min="0" name="colegiatura" value="<?php echo $colegiatura ?>"></p><br>
                    </div>
                </form>
            </div>
            <?php
            if (isset($_POST['editip'])) {
                if ($_POST['nombres'] != '') {
                    $nombrespronew = ucwords($_POST['nombres']);
                } else {
                    $nombrespronew = $nombrespro;
                };
                if ($_POST['apellidos'] != '') {
                    $apellidospronew = ucwords($_POST['apellidos']);
                } else {
                    $apellidospronew = $apellidospro;
                }
                if ($_POST['nacimiento'] != '') {
                    $nacimientopronew = $_POST['nacimiento'];
                } else {
                    $nacimientopronew = $nacimientopro;
                }
                if ($_POST['sexo'] != '') {
                    $sexopronew = $_POST['sexo'];
                } else {
                    $sexopronew = $sexopro;
                }
                if ($_POST['pais'] != '') {
                    $paispronew = $_POST['pais'];
                } else {
                    $paispronew = $paispro;
                }
                if ($_POST['idioma'] != '') {
                    $idiomapronew = $_POST['idioma'];
                } else {
                    $idiomapronew = $idiomapro;
                }
                if ($_POST['ciudad'] != '') {
                    $ciudadpronew = ucwords($_POST['ciudad']);
                } else {
                    $ciudadpronew = $ciudadpro;
                }
                if ($_POST['especialidad'] != '') {
                    $especialidadnew = $_POST['especialidad'];
                } else {
                    $especialidadnew = $especialidad;
                }
                if ($_POST['precio'] != '') {
                    $precionew = $_POST['precio'];
                } else {
                    $precionew = $precio;
                }
                if ($_POST['colegiatura'] != '') {
                    $colegiaturanew = $_POST['colegiatura'];
                } else {
                    $colegiaturanew = $colegiatura;
                }

                $sql2 = mysqli_query($conexion, "UPDATE usuariospro SET nombrespro = '$nombrespronew', apellidospro = '$apellidospronew', nacimientopro = '$nacimientopronew', sexopro = '$sexopronew', paispro = '$paispronew', idiomapro = '$idiomapronew', ciudadpro = '$ciudadpronew', especialidad = '$especialidadnew', precio = '$precionew', colegiatura = '$colegiaturanew', ultimaedicion = '$fechaHoy' WHERE idpro = '" . $idpro . "' ");
                if ($sql2) {
                    header("location: perfilpro/" . $idpro . "");
                }
            }
            ?>
        </div>
        <?php
        if ($estado == '0') {
        ?>
            <div class="revision cuentarev">
                <h2>CUENTA EN ESTADO DE REVISIÓN...</h2>
                <p>El proceso puede tardar hasta dos (2) días hábiles posteriores a la última modificación de su información. Asegúrese de haber registrado sus datos personales exactos, actuales y veraces para agilizar el proceso de aprobación de su cuenta.</p>
            </div>
            <div class="filatres">
                <div class="ctn-perfil observaciones observa" id="perfil1">
                    <div class="ctn-editarp">
                        <h2>OBSERVACIONES DE LA CUENTA</h2>
                    </div>
                    <hr id="edit-infb">
                    <ul>
                        <li><?php echo $indicaciones; ?></li>
                    </ul>
                    <p style="width:100%">Para recibir mayor orientación sobre cómo resolver las observaciones de su cuenta, puede contactarnos por correo o WhatsApp.<br><br><a id="awsp" href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a></p>
                </div>
                <div class="ctn-fotos" id="ctnfotos" style="margin-top:25px">
                    <form action="" method="post" enctype="multipart/form-data" name="formfotos1" id="formfotos1">
                        <span>Diploma de título profesional:</span>
                        <div class="boxfotos">
                            <div class="fotorevision ctn-fototit">
                                <img src="<?php echo $_ENV['APP_URL']; ?>titulos/<?php echo $fototitulo . "?v=" . rand() ?>" id="fptit" alt="Diploma de título profesional" class="zoom-effect" data-toggle="modal" data-target="#modalFotoTit">
                            </div>
                            <div class="ctn-previe" id="previewtit"></div>
                            <div class="ctn-editartit">
                                <input type="file" name="filetit" id="filetit" accept="image/*">
                                <label for="filetit" name="lbltit" class="lblguardar" id="lbltit">Editar</label>
                            </div>
                            <div class="ctn-guardartit" id="ctn-edittit">
                                <input type="submit" name="edittit" class="lblguardar lblbtn" id="edittit" value="Guardar"><br>
                            </div>
                        </div>
                        <!-- Modal -->
<div class="modal fade" id="modalFotoTit" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $_ENV['APP_URL']; ?>titulos/<?php echo $fototitulo . "?v=" . rand() ?>" alt="Foto de título agrandada" id="modalFotoAgrandada"><br>
            </div>
        </div>
    </div>
</div>
                    </form>
                    <form action="" method="post" enctype="multipart/form-data" name="formfotos2" id="formfotos2">
                        <span>Diploma de colegiatura:</span>
                        <div class="boxfotos">
                            <div class="fotorevision ctn-fotofirma">
                                <img src="<?php echo $_ENV['APP_URL']; ?>colegiaturas/<?php echo $fotocolegiatura . "?v=" . rand() ?>" id="fpfirma" alt="Diploma de colegiatura" class="zoom-effect" data-toggle="modal" data-target="#modalFotoCole">
                            </div>
                            <div class="ctn-previe" id="previewfirma"></div>
                            <div class="ctn-editarfirma">
                                <input type="file" name="filefirma" id="filefirma" accept="image/*">
                                <label for="filefirma" name="lblfirma" class="lblguardar" id="lblfirma">Editar</label>
                            </div>
                            <div class="ctn-guardarfirma" id="ctn-editfirma">
                                <input type="submit" name="editfirma" class="lblguardar lblbtn" id="editfirma" value="Guardar"><br>
                            </div>
                        </div>
                        <!-- Modal -->
<div class="modal fade" id="modalFotoCole" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $_ENV['APP_URL']; ?>colegiaturas/<?php echo $fotocolegiatura . "?v=" . rand() ?>" alt="Foto de colegiatura agrandada" id="modalFotoAgrandada"><br>
            </div>
        </div>
    </div>
</div>
                    </form>
                    <form action="" method="post" enctype="multipart/form-data" name="formfotos3" id="formfotos3">
                        <span>Documento de identidad (ambos lados):</span>
                        <div class="boxfotos">
                            <div class="fotorevision ctn-fotohuella">
                                <img src="<?php echo $_ENV['APP_URL']; ?>documentos/<?php echo $fotodocumento . "?v=" . rand() ?>" id="fphuella" alt="Documento de identidad" class="zoom-effect" data-toggle="modal" data-target="#modalFotoDoc">
                            </div>
                            <div class="ctn-previe" id="previewhuella"></div>
                            <div class="ctn-editarhuella">
                                <input type="file" name="filehuella" id="filehuella" accept="image/*">
                                <label for="filehuella" name="lblhuella" class="lblguardar" id="lblhuella">Editar</label>
                            </div>
                            <div class="ctn-guardarhuella" id="ctn-edithuella">
                                <input type="submit" name="edithuella" class="lblguardar lblbtn" id="edithuella" value="Guardar"><br>
                            </div>
                        </div>
                        <!-- Modal -->
<div class="modal fade" id="modalFotoDoc" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $_ENV['APP_URL']; ?>documentos/<?php echo $fotodocumento . "?v=" . rand() ?>" alt="Foto de documento agrandada" id="modalFotoAgrandada"><br>
            </div>
        </div>
    </div>
</div>
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST['edittit'])) {
                $elitit = "titulos/" . $fototitulo;
                unlink($elitit);
                $nombretit = $_FILES['filetit']['name'];
                $rutatit = $_FILES['filetit']['tmp_name'];
                $nametit = $correopro . '' . $nombretit;
                $destinotit = "titulos/" . $nametit;
                if (is_uploaded_file($rutatit)) {
                    copy($rutatit, $destinotit);
                }
                $sqltit = mysqli_query($conexion, "UPDATE usuariospro SET fototitulo = '$nametit', ultimaedicion = '$fechaHoy' WHERE idpro = '" . $idpro . "' ");
                if ($sqltit) {
                    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfilpro/" . $idpro . "'</script>";
                }
            }
            if (isset($_POST['editfirma'])) {
                $elifirma = "colegiaturas/" . $fotocolegiatura;
                unlink($elifirma);
                $nombrefirma = $_FILES['filefirma']['name'];
                $rutafirma = $_FILES['filefirma']['tmp_name'];
                $namefirma = $correopro . '' . $nombrefirma;
                $destinofirma = "colegiaturas/" . $namefirma;
                if (is_uploaded_file($rutafirma)) {
                    copy($rutafirma, $destinofirma);
                }
                $sqlfirma = mysqli_query($conexion, "UPDATE usuariospro SET fotocolegiatura = '$namefirma', ultimaedicion = '$fechaHoy' WHERE idpro = '" . $idpro . "' ");
                if ($sqlfirma) {
                    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfilpro/" . $idpro . "'</script>";
                }
            }
            if (isset($_POST['edithuella'])) {
                $elihuella = "documentos/" . $fotohuella;
                unlink($elihuella);
                $nombrehuella = $_FILES['filehuella']['name'];
                $rutahuella = $_FILES['filehuella']['tmp_name'];
                $namehuella = $correopro . '' . $nombrehuella;
                $destinohuella = "documentos/" . $namehuella;
                if (is_uploaded_file($rutahuella)) {
                    copy($rutahuella, $destinohuella);
                }
                $sqlhuella = mysqli_query($conexion, "UPDATE usuariospro SET fotodocumento = '$namehuella', ultimaedicion = '$fechaHoy' WHERE idpro = '" . $idpro . "' ");
                if ($sqlhuella) {
                    echo "<script>window.location.href='" . $_ENV['APP_URL'] . "perfilpro/" . $idpro . "'</script>";
                }
            }
            ?>
            <?php
        }
            if ($estado == '2') {
            ?>
                <div class="revision" style="margin-bottom:0px">
                    <h2>CUENTA BLOQUEADA...</h2>
                    <p>The Med Universe ha bloqueado su cuenta, por cuestiones de seguridad y/o alguna infracción de los Términos y Condiciones Profesionales de uso de la plataforma. Revise las observaciones de su cuenta y haga las correcciones necesarias.</p>
                </div>
                <div class="filatres" id="filatrespro" style="padding-bottom:0px">
                    <div class="ctn-perfil observaciones observapro" id="perfil1">
                        <div class="ctn-editarp">
                            <h2>OBSERVACIONES DE LA CUENTA</h2>
                        </div>
                        <hr id="edit-infb">
                        <ul>
                            <li><?php echo $indicaciones; ?></li>
                        </ul>
                        <p style="width:100%">Para recibir mayor orientación sobre cómo resolver las observaciones de su cuenta, puede contactarnos por correo o WhatsApp.<br><br><a id="awsp" href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:themeduniverse@gmail.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : themeduniverse@gmail.com</a></p>
                    </div>
                    <div class="ctn-herramientasperfil" id="herramientas">
                        <a href="<?php echo $_ENV['APP_URL']; ?>historialpro/<?php echo $idpro ?>" id="bcfiled4">Historial de Pagos</a>
                    </div>
                </div>
            <?php
            } else if ($estado == '1'){
            ?>
                <div class="ctn-herramientasperfil">
                    <a href="<?php echo $_ENV['APP_URL']; ?>horario/<?php echo $idpro ?>" id="bcfiled1">Horario y Agenda</a>
                    <a href="<?php echo $_ENV['APP_URL']; ?>hpacientes/<?php echo $idpro ?>" id="bcfiled2">Historial de Pacientes</a>
                    <a href="<?php echo $_ENV['APP_URL']; ?>historialpro/<?php echo $idpro ?>" id="bcfiled4">Historial de Pagos</a>
                </div>
            <?php
            }
            ?>
            <div class="filados">
                <div class="ctn-valorcomment">
                    <div class="ctn-valorperfil">
                        <div class="ctn-starperfil">
                            <h2 id="promedioValoraciones">
                                <!-- 4.0 -->
                            </h2>
                            <div class="stars" id="starsValoraciones">
                                <!-- <i class="fa-solid fa-star" id=star1></i>
                        <i class="fa-solid fa-star" id=star2></i>
                        <i class="fa-solid fa-star" id=star3></i>
                        <i class="fa-solid fa-star" id=star4></i>
                        <i class="fa-solid fa-star" id=star5></i> -->
                            </div>
                            <p id="nrovalor"><span id="spantotal">Total: </span><span id="totalValoraciones"></span></p>
                        </div>
                        <div id="valoracionEstrellas" class="ctn-barperfil">
                            <!-- <p id="nrobar5">5</p>
                    <div class="bar"><div id="bar5"></div></div><br>
                    <p id="nrobar4">4</p>
                    <div class="bar"><div id="bar4"></div></div><br>
                    <p id="nrobar3">3</p>
                    <div class="bar"><div id="bar3"></div></div><br>
                    <p id="nrobar2">2</p>
                    <div class="bar"><div id="bar2"></div></div><br>
                    <p id="nrobar1">1</p>
                    <div class="bar"><div id="bar1"></div></div> -->
                        </div>
                    </div>
                    <div id="listaDeComentarios" style="max-height:546px">

                    </div>
                </div>
                <div class="ctn-pubperfil">
                    <div class="ctn-editarip">
                        <h2>INFORMACIÓN PROFESIONAL</h2>
                    </div>
                    <hr id="hrpub">
                    <div class="ctn-infprofesional">
                        <?php
                        if ($estado == '2') {
                        } else {
                        ?>
                            <div class="box-footer">
                                <form action="" method="post" enctype="multipart/form-data" id="formGuardar">
                                    <!-- <input type="hidden" name="publicar" value="publicar" /> -->
                                    <div class="contpub">
                                        <div class="ctn-trayec">
                                            <p id="anadir">Información profesional:</p>
                                            <!-- onkeypress="return validarn(event)" -->
                                            <textarea id="publicacion" name="publicacion" placeholder='"Egresado(a) en medicina humana por la universidad ....."
"Jefe(a) del departamento de ..... en el hospital ....."
"Autor(a) de ..... publicado en la revista ....."' class="form-control" rows="6" maxlength="300" required></textarea>
                                            <br>
                                        </div>
                                        <div class="ctn-imagend">
                                            <input type="file" name="foto" id="file-1" class="inputfile inputfile-1" accept="image/*" data-multiple-caption="{count} files selected" />
                                            <p id="comprobar">Imagen evidencial (opcional):</p>
                                            <div class="ctn-previeimage" id="previewimage"></div>
                                            <label id="labelimage" for="file-1"><i id="icon-image" class="fa-solid fa-image"></i></label>
                                        </div>
                                    </div>
                                    <script src="<?php echo $_ENV['APP_URL']; ?>js/previewimage.js"></script>
                                    <!-- END Input file nuevo diseño .-->
                                    <br>

                                    <!-- <button type="button" onclick="test(event)">guardar 2</button> -->
                                    <button id="publicar" onclick="sendForm(event, this, 'formGuardar')" type="button" name="publicar" class="btn btn-primary btn-flat">Guardar</button>
                                    <label id="guardar" for="publicar"><span>Guardar</span></label>
                                </form>
                                <?php
                                if (isset($_POST['publicar'])) {
                                    $publicacion = nl2br(ucfirst($_POST['publicacion']));

                                    $result = mysqli_query($conexion, "SHOW TABLE STATUS WHERE `Name` = 'publicaciones'");
                                    $data = mysqli_fetch_assoc($result);
                                    $next_increment = $data['Auto_increment'];

                                    $alea = substr(strtoupper(md5(microtime(true))), 0, 12);
                                    $code = $next_increment . $alea;

                                    $type = 'jpg';
                                    $rfoto = $_FILES['foto']['tmp_name'];
                                    $name = $code . "." . $type;

                                    if (is_uploaded_file($rfoto)) {
                                        $destino = "fotoprofesional/" . $name;
                                        $nombre = $name;
                                        copy($rfoto, $destino);
                                    } else {
                                        $nombre = '';
                                    }

                                    $subir = mysqli_query($conexion, "INSERT INTO publicaciones (usuario,imagen,contenido) values ('" . $_SESSION['idpro'] . "','$nombre','$publicacion')");
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="ctn-infprofesional3">
                            <?php
                            $CantidadMostrar = 1000;
                            // Validado  la variable GET
                            $compag         = (int)(!isset($_GET['pag'])) ? 1 : $_GET['pag'];
                            $TotalReg       = mysqli_query($conexion, "SELECT * FROM publicaciones");
                            $totalr = mysqli_num_rows($TotalReg);
                            //Se divide la cantidad de registro de la BD con la cantidad a mostrar 
                            $TotalRegistro  = ceil($totalr / $CantidadMostrar);
                            //Operacion matematica para mostrar los siquientes datos.
                            $IncrimentNum = (($compag + 1) <= $TotalRegistro) ? ($compag + 1) : 0;
                            //Consulta SQL
                            $consultavistas = "SELECT * FROM publicaciones WHERE usuario = '" . $idpro . "' ORDER BY idpub ASC LIMIT " . (($compag - 1) * $CantidadMostrar) . " , " . $CantidadMostrar;
                            $consulta = mysqli_query($conexion, $consultavistas);

                            while ($lista = mysqli_fetch_array($consulta)) {
                                $n = rand();
                            ?>
                                <div class="box-body">
                                    <hr>
                                    <form action="" method="post" name="form3" id="form3<?= $n ?>">
                                        <input type="number" name="eliminar" id="eliminar" value="<?php echo $lista['idpub']; ?>">
                                        <input type="text" name="nameImage" id="nameImage" value="<?php echo $lista['imagen']; ?>">
                                        <label id="labelequis" for="equis<?php echo $lista['idpub']; ?>"><i class="fa-solid fa-square-xmark"></i></label>
                                        <input type="button" onclick="sendForm(event, this, 'form3<?= $n ?>')" name="equis" class="equis" id="equis<?php echo $lista['idpub']; ?>">
                                    </form>
                                    <div class="boxpubli">
                                        <p><?php echo $lista['contenido']; ?>
                                            <?php
                                            if ($lista['imagen'] != '') {
                                            ?>
                                        <div class="ctn-imagepub">
                                            <img src="<?php echo $_ENV['APP_URL']; ?>fotoprofesional/<?php echo $lista['imagen']; ?>" ALIGN="MIDDLE" class="zoom-effect" data-toggle="modal" data-target="#modalFotoPub<?php echo $lista['idpub']; ?>">
                                        </div>
                                        <!-- Modal -->
<div class="modal fade" id="modalFotoPub<?php echo $lista['idpub']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalFotoPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $_ENV['APP_URL'] . 'fotoprofesional/' . $lista['imagen']; ?>" alt="Foto de pub agrandada" id="modalFotoAgrandada"><br>
            </div>
        </div>
    </div>
</div>
                                    <?php
                                            }
                                    ?>
                                    </div>
                                </div>
                                <?php
                                if (isset($_POST['equis'])) {
                                    $idpub = $_POST['eliminar'];
                                    $nameImage = $_POST['nameImage'];
                                    $sql3 = mysqli_query($conexion, "DELETE FROM publicaciones WHERE idpub = '" . $idpub . "' ");
                                    unlink(getcwd() . "/fotoprofesional/" . $nameImage);
                                }
                                ?>
                            <?php
                            }
                            ?>




                        </div>
                    </div>
                </div>
            </div>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/previewperfil.js?v=<?php echo rand(); ?>"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/previewrevision.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/guardar.js"></script>
</body>
<?php echo footermed(); ?>

</html>