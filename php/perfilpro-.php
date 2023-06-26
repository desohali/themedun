<?php
    $consultaPac = "SELECT id, nombres, apellidos FROM usuarios WHERE id = '" . $_SESSION['id'] . "' ";
    $resultadoPac = mysqli_query($conexion, $consultaPac);
    if ($resultadoPac) {
        while ($rowPac = $resultadoPac->fetch_array()) {
            $id = $rowPac['id'];
            $nombres = $rowPac['nombres'];
            $apellidos = $rowPac['apellidos'];
        }
    }
    $consultaPrevia = "SELECT COUNT(idcita) AS numeroCitas FROM citas WHERE id = '". $id . "' AND idupro = '". $idpro . "' AND idpay <> '0' AND asistenciapac = 'Asistió' AND asistencia = 'Asistió' ";
    $resultadoPrevia = mysqli_query($conexion, $consultaPrevia);
    if ($resultadoPrevia) {
        while ($rowPrevia = $resultadoPrevia->fetch_array()) {
            $numeroCitas = $rowPrevia['numeroCitas'];
        }
    }
    $consultaComen = "SELECT COUNT(idu) as conteoComen FROM valoraciones WHERE idu = '". $id . "' AND idupro = '". $idpro . "' AND valoracion = '0'";
    $resultadoComen = mysqli_query($conexion, $consultaComen);
    if ($resultadoComen) {
        while ($rowComen = $resultadoComen->fetch_array()) {
            $conteoComen = $rowComen['conteoComen'];
        }
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $doctor . ' ' . $nombrespro . ' ' . $apellidospro ?> - The Med Universe | Paciente</title>
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/perfilpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/perfilpro-.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">


</head>

<body id="body">
    <?php echo headernav();
    include './php/navbar.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/buscador.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/m&ob.js"></script>

    <script>
        const Valoraciones = function() {};
        Valoraciones.prototype.registrarValoracion = async function({
            valoracion,
            comentarios
        }) {

            const formData = new FormData();
            formData.append("method", "registrarValoracion");
            formData.append("idu", <?= $_SESSION['id'] ?>);
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
            formData.append("idu", <?= $_SESSION['id'] ?>);
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
                            if ("<?= $_SESSION['id'] ?>" == currentValue.idu && comentario.esMedicoOPaciente == "PACIENTE") {
                                htmlComentarios += `<label id="labelx" onclick="new Valoraciones().eliminarComentario(${currentValue.id})"><i class="fa-solid fa-square-xmark"></i></label>`;
                            }
                            
                            htmlComentarios += ` <strong>${comentario.nombres}:</strong><br> ${comentario.comentario}<br> <span> ${fechaReg}</span></p>`;
                            
                            if ( /* !indice &&  */ currentValue.comentarios.length == 2) {
                                htmlComentarios += `<a class="verrespuesta" href="" onclick="mostrarRespuestas(event, ${currentValue.id})">Ver respuesta</a>`;
                            }else if ( /* !indice &&  */ currentValue.comentarios.length > 2) {
                                htmlComentarios += `<a class="verrespuesta" href="" onclick="mostrarRespuestas(event, ${currentValue.id})">Ver ${(currentValue.comentarios.length - 1)} respuestas</a>`;
                            }
                        } else {

                            htmlComentarios += `<p class="ctn-comentario comentario${currentValue.id}" style="display:none;">`;
                            if ("<?= $_SESSION['id'] ?>" == comentario.idUser && comentario.esMedicoOPaciente == "PACIENTE") {
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

                    /*const inputRespuesta = `<textarea placeholder="Responde el comentario..." onkeypress="new Valoraciones().responseComentario(event, ${currentValue.id})" class="rescomentario" rows="3"></textarea>`;
                        return `${previousValue} <hr id="hrvc"><div class="box-comentario">${htmlComentarios}${inputRespuesta}</div>`; */
                    return `${previousValue} <hr id="hrvc"><div class="box-comentario">${htmlComentarios}</div>`;
                }, "");

            return 3;

        };

        /* Valoraciones.prototype.responseComentario = async function(e, idComentario) {
            try {

                if (!new RegExp("\\S{1,}").test(e.target.value)) {
                    // quizas se agrega alguna laerta o texto
                    return;
                }

                if (e.keyCode == 13 || e.which == 13) {
                    const formData = new FormData();
                    formData.append("method", "responseComentario");
                    formData.append("idComentario", idComentario);
                    formData.append("comentario", JSON.stringify({
                        idUser: <?= $_SESSION['id'] ?>,
                        nombres: "<?= $nombres . " " . $apellidos ?>",
                        esMedicoOPaciente: "PACIENTE",
                        comentario: e.target.value.trim(),
                        leido: 'NO',
                        fecha: moment().format("YYYY-MM-DD hh:mm:ss")
                    }));

                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                        method: "post",
                        body: formData
                    });
                    const valoraciones = await response.text();

                    await new Valoraciones().listarValoraciones();
                }
            } catch (error) {
                console.log('error', error)
            }
        }; */

        Valoraciones.prototype.registrarComentario = async function(e) {

            if (!new RegExp("\\S{1,}").test(e.target.value)) {
                // quizas se agrega alguna laerta o texto
                return;
            }
            const $comentario = $("#comentario");

            await new Valoraciones().registrarValoracion({
                valoracion: 0,
                comentarios: JSON.stringify({
                    "idUser": <?= $_SESSION['id'] ?>,
                    "nombres": "<?= $nombres . " " . $apellidos ?>",
                    "esMedicoOPaciente": "PACIENTE",
                    "comentario": $comentario.val().trim(),
                    leido: "NO",
                    fecha: moment().format("YYYY-MM-DD HH:mm:ss")
                })
            });
            await new Valoraciones().listarValoraciones();

            $comentario.val("");
            
            const boxComen = document.getElementById("boxComen");
            boxComen.style.display = 'none';
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
            
            const boxComen = document.getElementById("boxComen");
            boxComen.style.display = 'block';
        };

        /*Valoraciones.prototype.eliminarRespuesta = async function(id, indice) {

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
        };*/


        function mostrarRespuestas(e, idComentario) {
            e.preventDefault();
            e.target.style.display = "none";
            $(`.comentario${idComentario}`).toggle();
        }

        let ratingCurrent;
        $(document).ready(async function() {

            $rateYo = $("#rateYo");
            /* console.log('moment', moment); */
            /* $rateYo.click((e)=>{
                console.log('$rateYo.rateYo("rating")', $rateYo.next().rateYo("rating"));
            }) */

            $rateYo.rateYo({
                starWidth: "35px",
                normalFill: "#e5e5e5",
                ratedFill: "#fff600",
                spacing: "3px",
                // precision: 2,
                rating: await new Promise(async (resolve) => {

                    const formData = new FormData();
                    formData.append("method", "listarValor");
                    formData.append("idu", <?= $_SESSION['id'] ?>);
                    formData.append("idupro", <?= $_GET['id'] ?>);

                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                        method: "post",
                        body: formData
                    });
                    const valoraciones = await response.json();

                    const findValoracion = valoraciones.find((c) => Number(c.valoracion));
                    if (findValoracion) {
                        resolve(findValoracion.valoracion)
                    } else {
                        resolve(0);
                    }
                }),
                fullStar: true,
                onSet: async function(rating, rateYoInstance) {
                    const response = await new Valoraciones().registrarValoracion({
                        valoracion: rating,
                        comentarios: ''
                    });
                    await new Valoraciones().listarValoraciones();
                    console.log('response', response);
                }
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

            /* $("#publicarComentario").click(async () => {

                const $comentario = $("#comentario");

                await new Valoraciones().registrarValoracion({
                    valoracion: 0, 
                    comentarios: JSON.stringify({
                        "idUser": <?= $_SESSION['id'] ?>,
                        "nombres": "<?= $nombres . " " . $apellidos ?>",
                        "esMedicoOPaciente": "PACIENTE",
                        "comentario": $comentario.val().trim()
                    })
                });
                await new Valoraciones().listarValoraciones();

                $comentario.val("");

            }); */
        });
    </script>
    <main>
        <div class="filauno">
            <div class="ctn-sideperfil">
                <div class="ctn-fotoperfil">
                    <img src="<?php echo $_ENV['APP_URL'] . "fotoperfilpro/mini_" . $fotoperfilpro . "?v=" . rand()?>" id="fppro" alt="Foto de perfil"><br>
                </div>
                <a href="<?php echo $boton;?>" target="_blank" class="colegiatura" id="comprob-coleg"><button><?php echo $verificar;?></button></a><br>
                <a href="<?php echo $_ENV['APP_URL'] . 'cita/' . $idpro; ?>" id="prog-cita"><button>Programar Cita</button></a>
            </div>
            <div class="ctn-perfil" id="perfilpro-">
                <div class="ctn-editarp">
                    <h2>INFORMACIÓN PERSONAL</h2>
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
                    <p id="nacimientoperfil"><span>Fecha de nacimiento<span class="spanedad"> (Edad)</span>:</span> <?php echo $newDateNac?><span class="spanedad" id="idedad"> (<?php echo $edad.$año?>)</span></p>
                    <p id="edadperfil"><span>Edad:</span> <?php echo $edad?> años</p>
                    <p id="sexoperfil"><span>Género:</span> <?php echo $sexopro ?></p><br>
                    <p id="paisperfil"><span>País (Idioma):</span> <?php echo $paispro ?> (<?php echo $idiomapro ?>)</p>
                    <p id="ciudadperfil"><span>Ciudad:</span> <?php echo $ciudadpro ?></p><br>
                    <hr>
                    <p id="profesionperfil"><span>Profesión:</span> <?php echo $profesion; ?></p>
                    <p id="especialidadperfil"><span>Especialidad:</span> <?php echo $especialidad ?></p><br>
                    <p id="enmudesde"><span>En The Med Universe desde:</span> <?php echo $newDateEnmu ?></p>
                    <p id="consultasperfil"><span>Citas en The Med Universe:</span> <?php echo $nrocitas ?></p><br>
                    <hr>
                    <p id="precioperfil"><span>Precio de cita:</span> S/ <?php echo $precio ?></p>
                    <p id="colegiaturaperfil"><span>N° de colegiatura:</span> <?php echo $colegiatura ?></p>
                </div>
            </div>
        </div>
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
                        <!-- <p id="nrobar5" style="display: block;">5 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar4" style="display: block;">4 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar3" style="display: block;">3 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar2" style="display: block;">2 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar1" style="display: block;">1 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p> -->
                    </div>

                </div>
            <?php
            if($numeroCitas >= '1'){
            ?>
                <div id="rateYo" style="margin:auto;padding: 10px 0px 5px 0px;"></div>
                <div class="ctn-commentperfil" id="boxComen" style="display:<?php if($conteoComen == '0'){echo 'block';}else{echo 'none';} ?>">
                    <textarea placeholder="Escribe un comentario..." onkeypress="event.keyCode == 13 ? new Valoraciones().registrarComentario(event): true" id="comentario" class="w-100 form-control" rows="3"></textarea>
                    <!-- <button id="publicarComentario" class="btn btn-primary btn-block">Publicar</button> -->
                </div>
            <?php
            }
            ?>
                <div id="listaDeComentarios">

                </div>
            </div>
            <div class="ctn-pubperfil">
                <div class="ctn-editarip">
                    <h2>INFORMACIÓN PROFESIONAL</h2>
                </div>
                <div class="ctn-infprofesional">
                    <div class="ctn-infprofesional2">
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
                        ?>
                            <div class="box-body">
                                <hr>
                                <div class="boxpubli">
                                    <p><?php echo $lista['contenido']; ?>
                                        <?php
                                        if ($lista['imagen'] != '') {
                                        ?>
                                    <div class="ctn-imagepub">
                                        <img src="<?php echo $_ENV['APP_URL'] . 'fotoprofesional/' . $lista['imagen']; ?>" ALIGN="MIDDLE">
                                    </div>
                                <?php
                                        }
                                ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php echo footermed(); ?>

</html>