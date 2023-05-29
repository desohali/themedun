//GUARDAR FOTO
document.getElementById("bbfile").addEventListener("click", mostrar_guardar);
document.getElementById("ctn-editfoto").addEventListener("click", ocultar_guardar);

editfoto = document.getElementById("ctn-editfoto");
labelfoto = document.getElementById("labelfoto");
canvasPerfil = document.getElementById("canvasPerfil");

function mostrar_guardar(){
    labelfoto.style.display = "none";
    editfoto.style.display = "block";
    canvasPerfil.style.display = "block";
}
function ocultar_guardar(){
    editfoto.style.display = "none";
    labelfoto.style.display = "block";
    canvasPerfil.style.display = "none";
}