<?php

include './php/conexion_paciente.php';
include './configuracion.php';
class Seguridad
{

  public $path;
  public $conexion;

  public $tipoUsuario;

  public $rutasSiempreAccesibles = [
    "lreclamos",
    "hreclamos",
    "terycon",
    "teryconpro",
    "privacidad",
    "cookies",
    "cayuda",
    "404",
    /* agregar mas rutas... */
  ];

  public $rutasPublicas = [
    "login",
    "loginpro",
    "loginadmin",
    "register",
    "registerpro",
    "recuperarc",
    "recuperarcadmin",
    "recuperarcpro",
    "restablecerc",
    "restablecercadmin",
    "restablecercpro",
    "cambiarc",
    "cambiarcadmin",
    "cambiarcpro",
    "verificar",
    "verificarpro",
    "login.php",
    "loginpro.php",
    "loginadmin.php",
    "register.php",
    "registerpro.php",
    "recuperarc.php",
    "recuperarcadmin.php",
    "recuperarcpro.php",
    "restablecerc.php",
    "restablecercadmin.php",
    "restablecercpro.php",
    "cambiarc.php",
    "cambiarcadmin.php",
    "cambiarcpro.php",
    "verificar.php",
    "verificarpro.php",
    /* agregar mas rutas... */
  ];

  public $rutasPaciente = [
    "home",
    "favoritos",
    "perfilproo",
    "cita",
    "hclinica",
    "agenda",
    "historial",
    "perfil",
    /* agregar mas rutas... */
  ];

  public $rutasMedico = [
    "perfilpro",
    "horario",
    "hpacientes",
    "hclinicapro",
    "historialpro",
    /* agregar mas rutas... */
  ];

  public $rutasAdministrador = [
    "activos",
    "inactivos",
    "perfilrevision",
    "perfiladmin",
    "libroreclamaciones",
    "hojareclamacion",
    "historialadmin",
    "agendaadmin",
    "pacientes",
    "perfilpaciente",
    "administradores",
    "perfiladministrador",
    "pagospro",
    "abonospro",
    "pagosadmin",
    "abonosadmin",
    "lreclamos"
    /* agregar mas rutas... */
  ];

  function __construct($conexion, $tipoUsuario = "")
  {
    $this->conexion = $conexion;
    $this->tipoUsuario = $tipoUsuario;
    $this->path = explode("/", parse_url($_SERVER['REQUEST_URI'])['path']);
  }

  function init()
  {

    /* $previous = $_SERVER['HTTP_REFERER']; */

    if ($this->tipoUsuario == "PACIENTE") {
      if (!$this->verificarInicioDeSesionPaciente()) {
        header("Location: " . $_ENV['APP_URL']);
      } else {
        if (!$this->verificarRutasPaciente()) {
          echo "<script>window.history.back();</script>";
          exit();
        }

        /* $isRutaValid = false;
        for ($i = 0; $i < count($this->rutasPublicas); $i++) {
          if (in_array($this->rutasPublicas[$i], $this->path)) {
            $isRutaValid = true;
            break;
          }
        }

        if ($isRutaValid) {
          echo "<script>window.history.back();</script>";
          exit();
        } */
      }
    } else if ($this->tipoUsuario == "MEDICO") {
      if (!$this->verificarInicioDeSesionMedico()) {

        if ($this->verificarInicioDeSesionPaciente()) {
          echo "<script>window.history.back();</script>";
          exit();
        } else {
          header("Location: " . $_ENV['APP_URL'] . "loginpro");
        }
      } else {
        if (!$this->verificarRutasMedico()) {
          echo "<script>window.history.back();</script>";
          exit();
        }
      }
    } else if ($this->tipoUsuario == "ADMINISTRADOR") {

      if (!$this->verificarInicioDeSesionAdminisrador()) {
        header("Location: " . $_ENV['APP_URL'] . "loginadmin");
      } else {
        if (!$this->verificarRutasAdministrador()) {
          echo "<script>window.history.back();</script>";
          exit();
        }
      }
    } else {
      echo "Aqui agregar html de mesanje de estado 404";
      exit();
    }
  }

  function verificarSiYaEstoyLogeado()
  {
    // ESTO SE AGREGO DESPUES DE LA REVISION DE LOGIN PACIENTE
    // $this->verificarInicioDeSesionMedico(); 
    // $this->verificarInicioDeSesionAdminisrador();
    if (
      $this->verificarInicioDeSesionPaciente() ||
      $this->verificarInicioDeSesionMedico() ||
      $this->verificarInicioDeSesionAdminisrador()
    ) {
      $isRutaValid = false;
      for ($i = 0; $i < count($this->rutasPublicas); $i++) {
        if (in_array($this->rutasPublicas[$i]/* historialpro */, $this->path)) {
          $isRutaValid = true;
          break;
        }
      }

      if ($isRutaValid) {
        if ($this->verificarInicioDeSesionPaciente()) {
          //header("Location: " . $_ENV['APP_URL'] .  "home");
          echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "home');</script>";
        } else if ($this->verificarInicioDeSesionMedico()) {
          //header("Location: " . $_ENV['APP_URL'] .  "perfilpro/" . $_SESSION['idpro']);
          echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "perfilpro/" . $_SESSION['idpro'] . "');</script>";
        } else if ($this->verificarInicioDeSesionAdminisrador()) {
          //header("Location: " . $_ENV['APP_URL'] .  "activos");
          echo "<script>window.location.replace('" . $_ENV['APP_URL'] . "activos');</script>";
        }
      }

      /* if ($isRutaValid) {
        echo "<script>window.history.back();</script>";
        exit();
      } */
    }
  }

  function verificarInicioDeSesionPaciente(): bool
  {
    try {
      $id = @$_SESSION['id'];

      $isSesionValid = true;
      for ($i = 0; $i < count($this->rutasPublicas); $i++) {
        if (in_array($this->rutasPublicas[$i], $this->path)) {
          continue;
        } else {
          if (empty($id)) {
            $isSesionValid = false;
          }
        }
      }

      return $isSesionValid;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  function verificarInicioDeSesionMedico(): bool
  {
    try {
      $idpro = @$_SESSION['idpro'];

      $isSesionValid = true;
      for ($i = 0; $i < count($this->rutasPublicas); $i++) {
        if (in_array($this->rutasPublicas[$i], $this->path)) {
          continue;
        } else {
          if (empty($idpro)) {
            $isSesionValid = false;
          }
        }
      }

      return $isSesionValid;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  function verificarInicioDeSesionAdminisrador(): bool
  {

    try {
      $idAdmin = @$_SESSION['idAdmin'];

      $isSesionValid = true;
      for ($i = 0; $i < count($this->rutasPublicas); $i++) {
        if (in_array($this->rutasPublicas[$i], $this->path)) {
          continue;
        } else {
          if (empty($idAdmin)) {
            $isSesionValid = false;
          }
        }
      }

      return $isSesionValid;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  function verificalIdGetUsuario($idUser)
  {

    $path = parse_url($_SERVER['REQUEST_URI'])['path'];
    if (preg_match('/^[0-9]{1,}$/', $path)) {
      $path = preg_replace('/^[0-9]{1,}$/', $idUser, $path);
    } else {
      $path = "";
      $arrayPath = explode("/", $path);
      foreach ($arrayPath as $key => $value) {
        if ((count($arrayPath) - 1) == $key) {
          $path .= $_SESSION['id'];
        } else {
          $path .= $value . "/";
        }
      }
    }

    header("Location: " . $path);
  }

  function verificarRutasPaciente(): bool
  {
    try {
      $isRutaValid = false;
      for ($i = 0; $i < count($this->rutasPaciente); $i++) {
        if (in_array($this->rutasPaciente[$i]/* historialpro */, $this->path)) {
          $isRutaValid = true;
        }
      }

      return $isRutaValid;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  function verificarRutasMedico(): bool
  {
    try {
      $isRutaValid = false;
      for ($i = 0; $i < count($this->rutasMedico); $i++) {
        if (in_array($this->rutasMedico[$i]/* historialpro */, $this->path)) {
          $isRutaValid = true;
        }
      }

      return $isRutaValid;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  function verificarRutasAdministrador(): bool
  {
    try {
      $isRutaValid = false;
      for ($i = 0; $i < count($this->rutasAdministrador); $i++) {
        if (in_array($this->rutasAdministrador[$i]/* historialpro */, $this->path)) {
          $isRutaValid = true;
        }
      }

      return $isRutaValid;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}


