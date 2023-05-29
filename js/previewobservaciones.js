//PREVIEW OBSERVACIONES
document.getElementById("bbfiled1").addEventListener("click", mostrar_editinfper);
document.getElementById("ctn-editip").addEventListener("click", ocultar_editinfper);

perfil1 = document.getElementById("perfil1");
perfil2 = document.getElementById("perfil2");

function mostrar_editinfper() {
    perfil2.style.display = "block";
    perfil1.style.display = "none";
}
function ocultar_editinfper() {
    perfil1.style.display = "block";
    perfil2.style.display = "none";
}
