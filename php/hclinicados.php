<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="The Med Universe S.A.C.S." />
    <meta name="description" content="The Med Universe es una plataforma en la que encontrarás una amplia gama de médicos y psicólogos distribuidos por todo el mundo que exhiben sus servicios de salud para que los puedas contactar de una manera rápida y sencilla." />
    <title>Historia Clínica - The Med Universe | Paciente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/nav.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/hclinicapro.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/hclinica.css">
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL'];?>css/footer.css">
</head>
<body id="body">
<?php echo headernav();include './php/navbar.php';?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $_ENV['APP_URL'];?>js/m&ob.js"></script>
    <main>
    <div class="boxclini">
            <div class="ctn-sideperfil">
                <div class="ctn-fotoperfil">
                    <img src="<?php echo $_ENV['APP_URL'] . 'fotoperfil/mini_' . $fotoperfil . "?v=" . rand() ?>" id="fppro" alt="Foto de perfil">
                </div>
                <div class="ctn-titrecord">
                    <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5);?></h2>
                </div>
                <div class="ctn-record">
                    <ul class="listarecord">
                    </ul>
                </div>
            </div>
        <div class="ctn-hclinica">
			<div class="ctn-editarpc">
                <h2>HISTORIA CLÍNICA N° <?php echo substr(str_repeat(0, 5).$id, - 5)?></h2>
            </div>
            <div class="box-body">
                <div class="boxhc" id="boxintrocita">
                    <h2>I. REGISTRO DE CITA</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxfiliacion">
                    <h2>II. FILIACIÓN</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxanamnesis">
                    <h2>III. ANAMNESIS</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxantecedentes">
                    <h2>IV. ANTECEDENTES</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxexafisico">
                    <h2>V. EXAMEN FÍSICO</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxexacomple">
                    <h2>VI. EXÁMENES COMPLEMENTARIOS</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxdiagnostico">
                    <h2>VII. DIAGNÓSTICOS</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxtratamiento">
                    <h2>VIII. PLAN DE TRABAJO</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <h2>IX. ANEXOS DEL PROFESIONAL</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxanexos">
                    <h2>X. ANEXOS DEL PACIENTE</h2>
                </div>
                <hr>
                <div class="boxhc" id="boxfiliacion">
                    <h2>XI. PROFESIONAL TRATANTE</h2>
                </div>
                <hr>
                <h2 id="nodatos">Aún no has programado ninguna cita para mostrar en la Historia Clínica.</h2>
            </div>
        </div>
    </div>
    </main>
</body>
<?php echo footermed();?>
</html>