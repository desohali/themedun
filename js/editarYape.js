//MOSTRAR EDITAR YAPE
document.getElementById("labelEditarYape").addEventListener("click", mostrar_edityape);
document.getElementById("btnyape").addEventListener("click", ocultar_edityape);

perfilyape1 = document.getElementById("bodyYape2");
perfilyape2 = document.getElementById("bodyYapeEditar");

function mostrar_edityape() {
    perfilyape2.style.display = "block";
    perfilyape1.style.display = "none";
}
function ocultar_edityape() {
    perfilyape1.style.display = "block";
    perfilyape2.style.display = "none";
}