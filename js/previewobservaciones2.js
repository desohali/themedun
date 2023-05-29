//PREVIEW OBSERVACIONES
document.getElementById("bbfiled1").addEventListener("click", mostrar_editinfper);
document.getElementById("ctn-editip").addEventListener("click", ocultar_editinfper);

perfil3 = document.getElementById("perfil3");
perfil4 = document.getElementById("perfil4");

function mostrar_editinfper() {
    perfil4.style.display = "block";
    perfil3.style.display = "none";
}
function ocultar_editinfper() {
    perfil3.style.display = "block";
    perfil4.style.display = "none";
}
