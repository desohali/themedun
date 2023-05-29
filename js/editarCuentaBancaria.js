//MOSTRAR EDITAR CUENTA BANCARIA
document.getElementById("labelEditar").addEventListener("click", mostrar_editinfper);
document.getElementById("btncuenta").addEventListener("click", ocultar_editinfper);

perfil1 = document.getElementById("bodyCuenta2");
perfil2 = document.getElementById("bodyCuentaEditar");

function mostrar_editinfper() {
    perfil2.style.display = "block";
    perfil1.style.display = "none";
}
function ocultar_editinfper() {
    perfil1.style.display = "block";
    perfil2.style.display = "none";
}