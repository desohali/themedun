<?php
function iniciomed($pacOpro)
{
?>
<div class="secundi">
    <div class="fraseinic">
        <h2>ESTÉS DONDE ESTÉS</h2>
    </div>
<?php
    if($pacOpro=='paciente'){
?>
<div class="card-deck">
  <div class="card">
    <iframe height="200" src="https://www.youtube.com/embed/XhzVkU6ZnSs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div class="card-body">
      <h5 class="card-title">Crear una cuenta | Paciente</h5>
    </div>
  </div>
  <div class="card">
    <iframe height="200" src="https://www.youtube.com/embed/Ce9Sfhq5WOk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div class="card-body">
      <h5 class="card-title">Programar una cita | Paciente</h5>
    </div>
  </div>
  <div class="card" id="ultimacard">
    <iframe height="200" src="https://www.youtube.com/embed/jNlt4nJ5WPc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div class="card-body">
      <h5 class="card-title">Acceder a mi Historia Clínica | Paciente</h5>
    </div>
  </div>
</div>
<?php
    }else{
?>
<div class="card-deck">
  <div class="card">
    <iframe height="200" src="https://www.youtube.com/embed/mVThaMmNAOY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div class="card-body">
      <h5 class="card-title">Crear una cuenta | Profesional</h5>
    </div>
  </div>
  <div class="card">
    <iframe height="200" src="https://www.youtube.com/embed/OV_PcY1Gxf0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div class="card-body">
      <h5 class="card-title">Programar una cita | Profesional</h5>
    </div>
  </div>
  <div class="card" id="ultimacard">
    <iframe height="200" src="https://www.youtube.com/embed/Bl1C636KATw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div class="card-body">
      <h5 class="card-title">Acceder a la Historia Clínica de mi paciente | Profesional</h5>
    </div>
  </div>
</div>
<?php
    }
?>
    <div class="divdatos" id="divque">
        <div class="queestmu">
            <h2>¿Qué es The Med Universe?</h2>
        </div>
        <h2 class="saludtit">TELECONSULTA - <span id="spanmedio">TELEMONITOREO</span> - TELEORIENTACIÓN</h2>
        <div class="datosmisvis" id="datosquees">
            <div class="datosclave">
                <p>Aquí encontrarás una amplia gama de médicos y psicólogos de todas las especialidades, entre los cuales podrás elegir y programar citas atendidas vía Zoom en la fecha, hora y el lugar que quieras.</p>
            </div>
            <div class="datosclave" id="espaciodatos">
                <div class="datosmisvis funciones">
                    <h2 class="misyvis">FUNCIONES</h2>
                    <div class="dosparrafos">
                        <p>Encuentra tu médico o psicólogo ideal</p>
                        <p>Programa citas en la fecha y hora que desees</p>
                    </div>
                    <div class="unparrafo">
                        <p>Atiéndete desde el lugar que quieras</p>
                    </div>
                    <div class="dosparrafos">
                        <p>Accede a las grabaciones de tus citas</p>
                        <p>Accede a tu historia clínica electrónica</p>
                    </div>
                </div>
                <div class="datosmisvis beneficios">
                    <h2 class="misyvis">BENEFICIOS</h2>
                    <div class="dosparrafos">
                        <p>Diagnósticos y tratamientos más rápidos</p>
                        <p class="parrafored">Reduce costos, tiempos de espera y traslados</p>
                    </div>
                    <div class="unparrafo">
                        <p id="parrafomedio">Cuenta con una segunda opinión médica</p>
                    </div>
                    <div class="dosparrafos">
                        <p class="parrafored">Evita consultas presenciales innecesarias</p>
                        <p id="automedica">Evita la automedicación</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divdatos" id="divpor">
        <div class="porquetmu">
            <h2>¿Por Qué The Med Universe?</h2>
        </div>
        <h2 class="saludtit">SALUD UNIVERSAL - OPS/OMS</h2>
        <div class="datosclave">
            <ul>
                <li><p>Alrededor de una tercera parte de las personas en los países de las Américas (29.3%) reportaron no buscar atención en salud cuando lo necesitaron debido a múltiples barreras de acceso.</p></li>
                <li><p>Entre los que reportaron no buscar atención, el 17.2% atribuyó su decisión a barreras organizativas (ej. largos tiempos de espera, horas de atención inadecuadas, requisitos administrativos engorrosos).</p></li>                
                <li><p>La disponibilidad inadecuada de recursos (ej. falta personal de salud) fue reportada en el 8.4% de los casos y las barreras geográficas en el 5.4% de los casos.</p></li>
            </ul>
            <img src="https://www.paho.org/sites/default/files/salud_universal_gif.gif" id="img-salud">
        </div>
    </div>
    <div class="divdatos" id="divpara">
        <div class="paraquetmu">
            <h2>¿Para Qué The Med Universe?</h2>
        </div>
        <div class="datosclave" id="datosclavedos">
            <div class="datosmisvis">
                <h2 class="misyvis">MISIÓN</h2>
                <p>Nuestra misión es romper las barreras geográficas y asegurar el acceso a una atención médica de alta calidad sin importar la ubicación, al mismo tiempo que promovemos la inclusión, la diversidad y la igualdad de acceso a la experiencia médica para todos.</p>
                <h2 class="misyvis" id="vervision">VISIÓN</h2>
                <p>Imaginamos un mundo donde la distancia ya no sea una barrera para recibir atención médica de alta calidad, donde los pacientes puedan consultar con médicos especialistas de cualquier parte del mundo y donde los médicos puedan colaborar y compartir conocimientos sin esfuerzo.</p>
            </div>
            <img src="<?php echo $_ENV['APP_URL'];?>images/med-isfrgb.png" id="logoverde">
        </div>
    </div>
</div>
<?php
}
?>  