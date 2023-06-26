<?php
function footermed()
{
?>
    <footer>
        <div class="footmed">
            <div class="divfoot" id="divflogo">
                <div class="flogo">
                    <img src="<?php echo $_ENV['APP_URL']; ?>images/med-sbsf.png" id="logofoot">
                </div>
            </div>
            <div class="divfoot">
                <h2 class="hfoot">Síguenos</h2>
                <div class="divicons">
                    <a href="https://www.facebook.com/themeduniverse" target="_blank"><i class="fa-brands fa-facebook"></i> : The Med Universe</a><br><br>
                    <a href="https://www.instagram.com/the_med_universe/" target="_blank"><i class="fa-brands fa-instagram"></i> : @the_med_universe</a><br><br>
                    <!--<a href="https://www.tiktok.com/@the_med_universe" target="_blank"><i class="fa-brands fa-tiktok"></i> : @the_med_universe</a><br><br>-->
                    <a href="https://api.whatsapp.com/send?phone=51986206045&text=Hola,%20tengo%20una%20consulta%20%C2%BFpueden%20ayudarme?%20%F0%9F%A4%94" target="_blank"><i class="fa-brands fa-whatsapp"></i> : +51 986 206 045</a><br><br>
                    <a href="https://www.youtube.com/@the_med_universe" target="_blank"><i class="fa-brands fa-youtube"></i> : The Med Universe</a>
                </div>
            </div>
            <div class="divfoot">
                <h2 class="hfoot">Servicios</h2>
                <div class="divuni">
                    <a href="<?php echo $_ENV['APP_URL']; ?>">Soy Paciente</a><br><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>loginpro">Soy Médico/Psicólogo</a><br><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>cayuda">Centro de Ayuda</a><br><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>lreclamos">Libro de Reclamaciones<img src="<?php echo $_ENV['APP_URL']; ?>images/reclamaciones.png" id="saludfoot"></a>
                </div>
            </div>
            <div class="divfoot" id="divnos">
                <h2 class="hfoot">Nosotros</h2>
                <div class="divuni">
                    <a href="<?php echo $_ENV['APP_URL']; ?>terycon">Términos y Condiciones</a><br><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>teryconpro">Términos y Condiciones Profesionales</a><br><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>privacidad">Política de Privacidad</a><br><br>
                    <a href="<?php echo $_ENV['APP_URL']; ?>cookies">Política de Cookies</a>
                </div>
            </div>
        </div>
        <div class="copyr">
            <p class="cright">The Med Universe 2023 © Todos los derechos reservados</p>
        </div>
    </footer>
<?php
}
?>