<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $doctor . ' ' . $nombrespro . ' ' . $apellidospro ?> - The Med Universe | Administrador</title>
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/perfilpro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>css/footer.css">
    <script src="<?php echo $_ENV['APP_URL']; ?>js/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- Latest compiled and minified CSS -->

</head>

<body id="body">
    <?php echo headernav() ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/buscadorAdmin.js"></script>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/m&ob.js"></script>
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
                        if (!indice) {
                            htmlComentarios += `<p class="ctn-comentario">`;
                            htmlComentarios += `<label id="labelx" onclick="new Valoraciones().eliminarComentario(${currentValue.id})"><i class="fa-solid fa-square-xmark"></i></label>`;
                            htmlComentarios += ` <strong>${comentario.nombres}:</strong><br> ${comentario.comentario}</p>`;
                            if ( /* !indice &&  */ currentValue.comentarios.length == 2) {
                                htmlComentarios += `<a class="verrespuesta" href="" onclick="mostrarRespuestas(event, ${currentValue.id})">Ver ${(currentValue.comentarios.length - 1)} respuesta</a>`;
                            } else if ( /* !indice &&  */ currentValue.comentarios.length > 2) {
                                htmlComentarios += `<a class="verrespuesta" href="" onclick="mostrarRespuestas(event, ${currentValue.id})">Ver ${(currentValue.comentarios.length - 1)} respuestas</a>`;
                            }
                        } else {
                            htmlComentarios += `<p class="ctn-comentario comentario${currentValue.id}" style="display:none;">`;
                            htmlComentarios += `<label id="labelx" onclick="new Valoraciones().eliminarRespuesta(${currentValue.id}, ${indice})"><i class="fa-solid fa-square-xmark"></i></label>`;
                            htmlComentarios += ` <strong>${comentario.nombres}:</strong><br> ${comentario.comentario}</p>`;
                        }


                    }
                    htmlComentarios += `</div>`;

                    /* const htmlComentarios = currentValue.comentarios.reverse().reduce((pV, cV) => {
                        let html = `<p class="ctn-comentario"><strong>${cV.nombres}:</strong><br> ${cV.comentario}</p>`;
                        
                        return `${pV}${html}`;
                    }, ""); */


                    return `${previousValue} <hr id="hrvc"><div class="box-comentario">${htmlComentarios}</div>`;
                }, "");

            return 3;

        };

        Valoraciones.prototype.responseComentario = async function(e, idComentario) {
            try {

                if (!new RegExp("\\S{1,}").test(e.target.value)) {
                    // quizas se agrega alguna laerta o texto
                    return;
                }

                <?php
                $nombresMedico = $sexopro == "Masculino" ? "Dr. " : "Dra. ";
                $nombresMedico .= $nombrespro . " ";
                $nombresMedico .= $apellidospro;
                ?>
                if (e.keyCode == 13 || e.which == 13) {
                    const formData = new FormData();
                    formData.append("method", "responseComentario");
                    formData.append("idComentario", idComentario);
                    formData.append("comentario", JSON.stringify({
                        idUser: <?= $_GET['id'] ?>,
                        nombres: "<?= $nombresMedico ?>",
                        esMedicoOPaciente: "MEDICO",
                        comentario: e.target.value.trim(),
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
        };

        Valoraciones.prototype.registrarComentario = async function(e) {

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

            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Comentario',
                text: "¿Está seguro de eliminar el comentario? Ya no lo podrá recuperar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00d418',
                cancelButtonColor: '#0052d4',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No'
            });

            if (isConfirmed) {
                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                    method: "post",
                    body: formData
                });

                const text = await Swal.fire({
                    title: 'Comentario eliminado',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#0052d4',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    window.location.reload();
                });
            };
        };

        Valoraciones.prototype.eliminarRespuesta = async function(id, indice) {

            const formData = new FormData();
            formData.append("method", "eliminarRespuesta");
            formData.append("id", id);
            formData.append("indice", indice);

            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Comentario',
                text: "¿Está seguro de eliminar el comentario? Ya no lo podrá recuperar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00d418',
                cancelButtonColor: '#0052d4',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No'
            });

            if (isConfirmed) {
                const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/classValoraciones.php", {
                    method: "post",
                    body: formData
                });

                const text = await Swal.fire({
                    title: 'Comentario eliminado',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#0052d4',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    window.location.reload();
                });
            };
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
    </script>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            const formAprobar = document.getElementById("formAprobar");

            formAprobar.addEventListener("submit", async function(e) {
                e.preventDefault();
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Cuenta',
                    text: "¿Está seguro de aprobar esta cuenta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00d418',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, aprobar',
                    cancelButtonText: 'No'
                });

                if (isConfirmed) {
                    const formData = new FormData(this);
                    formData.append("idpro", <?php echo $idpro; ?>);
                    formData.append("idadmin", <?php echo $_SESSION['idAdmin']; ?>);
                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/aprobarCuentaPro.php", {
                        method: "post",
                        body: formData
                    });
                    const json = await response.json();

                    const [primerCorreo] = json;
                    await enviarCorreo(primerCorreo);

                    const text = await Swal.fire({
                        title: 'Cuenta aprobada',
                        text: '',
                        icon: 'success',
                        confirmButtonColor: '#0052d4',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        window.location.reload();
                    });
                };
            });
        });
        window.addEventListener("DOMContentLoaded", function() {
            const formDesbloquear = document.getElementById("formDesbloquear");

            formDesbloquear.addEventListener("submit", async function(e) {
                e.preventDefault();
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Cuenta',
                    text: "¿Está seguro de desbloquear esta cuenta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#00d418',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, desbloquear',
                    cancelButtonText: 'No'
                });

                if (isConfirmed) {
                    const formData = new FormData(this);
                    formData.append("idpro", <?php echo $idpro; ?>);
                    formData.append("idadmin", <?php echo $_SESSION['idAdmin']; ?>);
                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/desbloquearCuentaPro.php", {
                        method: "post",
                        body: formData
                    });
                    const text = await Swal.fire({
                        title: 'Cuenta desbloqueada',
                        text: '',
                        icon: 'success',
                        confirmButtonColor: '#0052d4',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        window.location.reload();
                    });
                };
            });
        });
        window.addEventListener("DOMContentLoaded", function() {
            const formBloquear = document.getElementById("formBloquear");

            formBloquear.addEventListener("submit", async function(e) {
                e.preventDefault();
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'Cuenta',
                    text: "¿Está seguro de bloquear esta cuenta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0000',
                    cancelButtonColor: '#0052d4',
                    confirmButtonText: 'Sí, bloquear',
                    cancelButtonText: 'No'
                });

                if (isConfirmed) {
                    const formData = new FormData(this);
                    formData.append("idpro", <?php echo $idpro; ?>);
                    formData.append("idadmin", <?php echo $_SESSION['idAdmin']; ?>);
                    const response = await fetch("<?php echo $_ENV['APP_URL']; ?>php/bloquearCuentaPro.php", {
                        method: "post",
                        body: formData
                    });
                    const text = await Swal.fire({
                        title: 'Cuenta bloqueada',
                        text: '',
                        icon: 'success',
                        confirmButtonColor: '#0052d4',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        window.location.reload();
                    });
                };
            });
        });

        const sendForm = async ($event, $this, idForm) => {
            $event.preventDefault();

            const form = document.getElementById(idForm);

            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Información Profesional',
                text: "¿Está seguro de eliminar la información profesional? Ya no la podrá recuperar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00d418',
                cancelButtonColor: '#0052d4',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No'
            });

            if (isConfirmed) {
                const formData = new FormData(form);
                formData.append($this.getAttribute("name"), $this.getAttribute("name"));
                const response = await fetch("", {
                    method: "post",
                    body: formData
                });
                await response.text();
                const text = await Swal.fire({
                    title: 'Información Profesional eliminada',
                    text: '',
                    icon: 'success',
                    confirmButtonColor: '#0052d4',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    window.location.reload();
                });
            };
        }
    </script>
    <main>
        <div class="filauno" id="filamedico">
            <?php
            if ($estado == '1') {
            ?>
                <div class="ctn-sideperfil ctn-bloquear" id="sidemedico">
                <?php
            } else {
                ?>
                    <div class="ctn-sideperfil" id="sidemedico">
                    <?php
                } ?>
                    <div class="ctn-fotoperfil">
                        <img src="<?php echo $_ENV['APP_URL'] . "fotoperfilpro/mini_" . $fotoperfilpro . "?v=" . rand() ?>" id="fppro" alt="Foto de perfil"><br>
                    </div>
                    <a href="<?php echo $boton; ?>" target="_blank" class="colegiatura" id="comprob-coleg"><button><?php echo $verificar; ?></button></a>
                    <?php
                    if ($estado == '0') {
                    ?>
                        <div class="ctn-guardarfp" id="ctn-editfoto" style="display:block;">
                            <form id="formAprobar" method="post">
                                <input type="submit" name="editfoto" id="editfoto" value="Aprobar" style="margin-top:0px"><br>
                            </form>
                        </div>
                    <?php
                    } else if ($estado == '2') {
                    ?>
                        <div class="ctn-guardarfp" id="ctn-editfoto" style="display:block;">
                            <form id="formDesbloquear" method="post">
                                <input class="btndesbloquear" type="submit" name="desbloquearfoto" id="editfoto" value="Desbloquear" style="margin-top:0px"><br>
                            </form>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="ctn-guardarfp" id="ctn-editfoto" style="display:block;">
                            <form id="formBloquear" method="post">
                                <input class="btnbloquear" type="submit" name="bloquear" id="editfoto" value="Bloquear" style="margin-top:0px">
                                <hr id="edit-infb">
                                <textarea style="margin-bottom:0px" name="observaciones" onkeypress="return validarn(event)" placeholder='Observaciones a corregir por el profesional.' rows="3" required></textarea>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                    <div class="ctn-perfil ctnrev">
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
                            ?>
                            <p id="nacimientoperfil"><span>Fecha de Nacimiento (Edad):</span> <?php echo $newDateNac ?> (<?php echo $edad ?> años)</p>
                            <p id="sexoperfil"><span>Género:</span> <?php echo $sexopro ?></p><br>
                            <p id="paisperfil"><span>País (Idioma):</span> <?php echo $paispro ?> (<?php echo $idiomapro ?>)</p>
                            <p id="ciudadperfil"><span>Ciudad:</span> <?php echo $ciudadpro ?></p><br>
                            <hr>
                            <p id="profesionperfil"><span>Profesión:</span> <?php echo $profesion ?></p>
                            <p id="especialidadperfil"><span>Especialidad:</span> <?php echo $especialidad ?></p><br>
                            <p id="enmudesde"><span>En The Med Universe desde:</span> <?php echo $newDateEnmu ?></p>
                            <p id="consultasperfil"><span>Citas en The Med Universe:</span> <?php echo $nrocitas ?></p><br>
                            <hr>
                            <p id="precioperfil"><span>Precio de Cita:</span> S/ <?php echo $precio ?></p>
                            <p id="colegiaturaperfil"><span>N° de Colegiatura:</span> <?php echo $colegiatura ?></p>
                        </div>
                    </div>
                </div>
                <?php
                if ($estado == '0') {
                ?>
                    <div class="revision cuentarev">
                        <h2>CUENTA EN ESTADO DE REVISIÓN...</h2>
                        <p>El proceso puede tardar hasta dos (2) días hábiles posteriores a la última modificación de la información. Asegúrese de revisar que los datos personales sean exactos, actuales y veraces.</p>
                    </div>
                    <div class="filatres">
                        <div class="ctn-perfil observaciones observa" id="perfil1">
                            <?php
                            if ($indicaciones == '') {
                            ?>
                                <form action="" method="post">
                                    <div class="ctn-editarp">
                                        <h2>OBSERVACIONES DE LA CUENTA</h2>
                                        <div class="divinper">
                                            <div class="ctn-guardarip" id="ctn-editip">
                                                <input type="submit" name="editip" id="editip" value="Guardar">
                                            </div>
                                        </div>
                                    </div>
                                    <hr id="edit-infb">
                                    <textarea name="observaciones" onkeypress="return validarn(event)" placeholder='Observaciones a corregir por el profesional.' rows="3" required></textarea>
                                </form>
                            <?php
                            } else {
                            ?>
                                <div class="ctn-editarp">
                                    <h2>OBSERVACIONES DE LA CUENTA</h2>
                                    <div class="divinper">
                                        <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                                    </div>
                                </div>
                                <hr id="edit-infb">
                                <ul>
                                    <li><?php echo $indicaciones; ?></li>
                                </ul>
                                <p style="width:100%">Para recibir mayor orientación sobre cómo establecer las observaciones de esta cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:ayuda@themeduniverse.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : ayuda@themeduniverse.com</a></p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="ctn-perfil2 observaciones observa" id="perfil2">
                            <form action="" method="post">
                                <div class="ctn-editarp">
                                    <h2>OBSERVACIONES DE LA CUENTA</h2>
                                    <div class="divinper">
                                        <div class="ctn-guardarip" id="ctn-editip">
                                            <input type="submit" name="editip2" id="editip" value="Guardar">
                                        </div>
                                    </div>
                                </div>
                                <hr id="edit-infb">
                                <textarea name="observaciones2" id="txtobserva" rows="3" required><?php echo $indica ?></textarea>
                                <p style="width:100%">Para recibir mayor orientación sobre cómo establecer las observaciones de esta cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:ayuda@themeduniverse.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : ayuda@themeduniverse.com</a></p>
                            </form>
                        </div>
                        <div class="ctn-fotos" style="margin-top:25px">
                            <div class="boxfotos reviadmin">
                                <p class="previ"><span>Diploma de título profesional:</span></p><br>
                                <div class="fotorevision ctn-fototit">
                                    <img src="<?php echo $_ENV['APP_URL']; ?>titulos/<?php echo $fototitulo ?>" id="fptit" alt="Diploma de título profesional">
                                </div><br>
                                <p class="previa"><a href="../titulos/<?php echo $fototitulo; ?>" download="../titulos/<?php echo $fototitulo; ?>">Descargar archivo</a></p><br>
                            </div>
                            <div class="boxfotos reviadmin">
                                <p class="previ"><span>Diploma de colegiatura:</span></p><br>
                                <div class="fotorevision ctn-fotofirma">
                                    <img src="<?php echo $_ENV['APP_URL']; ?>colegiaturas/<?php echo $fotocolegiatura ?>" id="fpfirma" alt="Diploma de Colegiatura">
                                </div><br>
                                <p class="previa"><a href="../colegiaturas/<?php echo $fotocolegiatura; ?>" download="../colegiaturas/<?php echo $fotocolegiatura; ?>">Descargar archivo</a></p><br>
                            </div>
                            <div class="boxfotos reviadmin">
                                <p class="previ"><span>Documento de identidad (ambos lados):</span></p><br>
                                <div class="fotorevision ctn-fotohuella">
                                    <img src="<?php echo $_ENV['APP_URL']; ?>documentos/<?php echo $fotodocumento ?>" id="fphuella" alt="Documento de Identidad">
                                </div><br>
                                <p class="previa"><a href="../documentos/<?php echo $fotodocumento; ?>" download="../documentos/<?php echo $fotodocumento; ?>">Descargar archivo</a></p><br>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST['editip'])) {
                            $observaciones = nl2br(ucfirst($_POST['observaciones']));

                            $sql2 = mysqli_query($conexion, "UPDATE usuariospro SET indicaciones = '$observaciones' WHERE idpro = '" . $idpro . "' ");
                            if ($sql2) {
                                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                                echo $url . "perfilrevision/" . $idpro . "'</script>";
                            }
                        }

                        if (isset($_POST['editip2'])) {
                            $observaciones2 = nl2br(ucfirst($_POST['observaciones2']));

                            $sql4 = mysqli_query($conexion, "UPDATE usuariospro SET indicaciones = '$observaciones2' WHERE idpro = '" . $idpro . "' ");
                            if ($sql4) {
                                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                                echo $url . "perfilrevision/" . $idpro . "'</script>";
                            }
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    if ($estado == '2') {
                    ?>
                        <div class="revision">
                            <h2>CUENTA BLOQUEADA...</h2>
                            <p>The Med Universe se reserva la posibilidad de bloquear al profesional, por cuestiones de seguridad y/o alguna infracción de los Términos y Condiciones Profesionales de uso de la plataforma.</p>
                        </div>
                        <div class="filatres">
                            <div class="ctn-perfil observaciones" id="perfil1">
                                <div class="ctn-editarp">
                                    <h2>OBSERVACIONES DE LA CUENTA</h2>
                                    <div class="divinper">
                                        <label name="bbfiled" class="bbfiled" id="bbfiled1">Editar</label>
                                    </div>
                                </div>
                                <hr id="edit-infb">
                                <ul>
                                    <li><?php echo $indicaciones; ?></li>
                                </ul>
                                <p style="width:100%">Para recibir mayor orientación sobre cómo establecer las observaciones de esta cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:ayuda@themeduniverse.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : ayuda@themeduniverse.com</a></p>
                            </div>
                            <div class="ctn-perfil2 observaciones" id="perfil2">
                                <form action="" method="post">
                                    <div class="ctn-editarp">
                                        <h2>OBSERVACIONES DE LA CUENTA</h2>
                                        <div class="divinper">
                                            <div class="ctn-guardarip" id="ctn-editip">
                                                <input type="submit" name="editip3" id="editip" value="Guardar">
                                            </div>
                                        </div>
                                    </div>
                                    <hr id="edit-infb">
                                    <textarea class="txtobserva3" name="observaciones3" id="txtobserva" rows="3" required><?php echo $indica ?></textarea>
                                    <p style="width:100%">Para recibir mayor orientación sobre cómo establecer las observaciones de esta cuenta, puede contactarnos por correo o WhatsApp.<br><a id="awsp" href="https://wa.me/51986206045?text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><a id="acorreo" href="mailto:ayuda@themeduniverse.com" target="_blank"><i class="fa-regular fa-envelope"></i></i> : ayuda@themeduniverse.com</a></p>
                                </form>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST['editip3'])) {
                            $observaciones3 = nl2br(ucfirst($_POST['observaciones3']));

                            $sql8 = mysqli_query($conexion, "UPDATE usuariospro SET indicaciones = '$observaciones3' WHERE idpro = '" . $idpro . "' ");
                            if ($sql8) {
                                $url = "<script>window.location.href='" . $_ENV['APP_URL'];
                                echo $url . "perfilrevision/" . $idpro . "'</script>";
                            }
                        }
                        ?>
                    <?php
                    }
                    ?>

                    <div class="filados" style="padding-top:0px">
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
                                    <p id="nrovalor"><span>Total: </span><span id="totalValoraciones"></span></p>
                                </div>

                                <div id="valoracionEstrellas" class="ctn-barperfil">
                                    <!-- <p id="nrobar5" style="display: block;">5 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar4" style="display: block;">4 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar3" style="display: block;">3 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar2" style="display: block;">2 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p>
                    <p id="nrobar1" style="display: block;">1 <progress id="file" value="32" max="100" style="width:100%;"> 32% </progress></p> -->
                                </div>

                            </div>
                            <div id="rateYo" style="margin:auto;padding: 10px 0px;"></div>
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
                                        $n = rand();
                                    ?>
                                        <div class="box-body">
                                            <hr>
                                            <form action="" method="post" name="form3" id="form3<?= $n ?>">
                                                <input type="number" name="eliminar" id="eliminar" value="<?php echo $lista['idpub']; ?>">
                                                <label id="labelequis" for="equis<?php echo $lista['idpub']; ?>"><i class="fa-solid fa-square-xmark"></i></label>
                                                <input type="button" onclick="sendForm(event, this, 'form3<?= $n ?>')" name="equis" class="equis" id="equis<?php echo $lista['idpub']; ?>">
                                            </form>
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
                                        if (isset($_POST['equis'])) {
                                            $idpub = $_POST['eliminar'];
                                            $sql3 = mysqli_query($conexion, "DELETE FROM publicaciones WHERE idpub = '" . $idpub . "' ");
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
    </main>
    <script src="<?php echo $_ENV['APP_URL']; ?>js/previewobservaciones.js"></script>
</body>
<?php echo footermed(); ?>

</html>