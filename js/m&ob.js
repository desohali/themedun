//BUSCADOR
document.getElementById("formulario-nav").addEventListener("click", mostrar_buscador);
document.getElementById("body").addEventListener("click", ocultar_buscador);

buscapro = document.getElementById("buscapro");
box_search = document.getElementById("box-search");

function mostrar_buscador() {
  buscapro.focus();
  if (buscapro.value === "") {
    box_search.style.display = "none";
  }
}

function ocultar_buscador() {
  buscapro.value = "";
  box_search.style.display = "none";
}

/* i-noti
i-more
idsliders */

//BUSCADOR INTERNO
document.getElementById("buscapro").addEventListener("keyup", buscador_interno);

function buscador_interno() {
  filter = buscapro.value.toUpperCase();
  li = box_search.getElementsByTagName("li");

  //Recorriendo elementos a filtrar mediante los "li"
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    textValue = a.textContent || a.innerText;
    if (textValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
      box_search.style.display = "block";
      if (buscapro.value === "") {
        box_search.style.display = "none";
      }
    } else {
      li[i].style.display = "none";
    }
  }
}



$(document).ready(function () {

  //FILTRADOR
  $boxFilter = $("#box_filter");
  $("#idsliders").click(function () {

    $boxNoti.css("display", "none");
    $more.css("display", "none");

    if ($boxFilter.css("display") == "block") {
      $boxFilter.css("display", "none");
    } else {
      $boxFilter.css("display", "block");
    }

  });

  //NOTIFICACIONES
  $boxNoti = $("#box-noti");
  $("#i-noti").click(function () {
    $boxNoti.css("display", ($boxNoti.css("display") == "block") ? "none" : "block");
    $boxFilter.css("display", "none");
    $more.css("display", "none");
  });

  //MORE
  $more = $("#more");
  $("#i-more").click(function () {
    $more.css("display", ($more.css("display") == "block") ? "none" : "block");
    $boxFilter.css("display", "none");
    $boxNoti.css("display", "none");
  });

  function listenBody({ target }) {
    const buttons = [
      "i-noti",
      "comment-medical",
      "idsliders",
      "icon-sliders",
      "i-more",
      "caret-down",
    ];

    if (!buttons.includes(target?.id)) {
      $boxFilter.css("display", "none");
      $boxNoti.css("display", "none");
      $more.css("display", "none");
    }
  }


  /* $("#box_filter").click(() => {

    document.querySelector("body").removeEventListener("click", listenBody);

  }); */


  document.querySelector("body").addEventListener("click", listenBody);

  document.querySelector("body").addEventListener("click", ({ target }) => {
    const isParent = target.getAttribute("id");// box_filter
    if (isParent == "box_filter") {
      target.style.display = "block";
    } else {
      try {
        let profundidad = 5;
        let parent = target['parentNode'];
        while (profundidad) {

          if (parent?.getAttribute("id") == "box_filter") {
            parent.style.display = "block";
            break;
          }
          parent = parent["parentNode"];
          profundidad--;
        }
      } catch (error) { }
    }
  });


});
