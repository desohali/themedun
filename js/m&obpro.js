//MORE
$(document).ready(function () {

  $more = $("#more");
  $("#i-more").click(function () {

    $more.css("display", $more.css("display") == "block" ? "none" : "block");
    $boxNoti.css("display", "none");
    /* $("#more").each(function () {
      displaying = $(this).css("display");
      if (displaying == "block") {
        $(this).css("display", "none");
      } else {
        $(this).css("display", "block");
      }
    }); */

  });


  //NOTIFICACIONES
  $boxNoti = $("#box-noti");
  $("#i-noti").click(function () {
    $boxNoti.css("display", ($boxNoti.css("display") == "block") ? "none" : "block");
    $more.css("display", "none");
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
      $boxNoti.css("display", "none");
      $more.css("display", "none");
    }
  }

  document.querySelector("body").addEventListener("click", listenBody);

});
