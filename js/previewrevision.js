const filetit = document.getElementById("filetit");
const filefirma = document.getElementById("filefirma");
const filehuella = document.getElementById("filehuella");

document.getElementById("formfotos1").addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!filetit.files.length) {
        Swal.fire(
            'Imagen no seleccionada',
            'Seleccione una imagen disponible.',
            'error'
            )
        return;
    } else{
        const formData = new FormData(this);
        formData.append("edittit", "edittit");

        const response = await fetch("", {
            method: "post",
            body: formData
        });
        const text = await response.text();

        window.location.reload();
    }
});

document.getElementById("formfotos2").addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!filefirma.files.length) {
        Swal.fire(
            'Imagen no seleccionada',
            'Seleccione una imagen disponible.',
            'error'
            )
        return;
    } else{
        const formData = new FormData(this);
        formData.append("editfirma", "editfirma");

        const response = await fetch("", {
            method: "post",
            body: formData
        });
        const text = await response.text();

        window.location.reload();
    }
});

document.getElementById("formfotos3").addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!filehuella.files.length) {
        Swal.fire(
            'Imagen no seleccionada',
            'Seleccione una imagen disponible.',
            'error'
            )
        return;
    } else{
        const formData = new FormData(this);
        formData.append("edithuella", "edithuella");

        const response = await fetch("", {
            method: "post",
            body: formData
        });
        const text = await response.text();

        window.location.reload();
    } 
});


//PREVIEW FOTO TÍTULO
document.getElementById("filetit").onchange=function(e){
    let readertit = new FileReader();
    readertit.readAsDataURL(e.target.files[0]);
    readertit.onload = function(){
        let previewtit = document.getElementById("previewtit");
        let fptit = document.getElementById("fptit");
        imagentit = document.createElement('img');
        imagentit.src = readertit.result;
        imagentit.style.maxWidth="100%";
        imagentit.style.maxHeight="100%";
        previewtit.innerHTML="";
        previewtit.append(imagentit);
        fptit.style.display="none";
    }
}

//PREVIEW FOTO COLEGIATURA
document.getElementById("filefirma").onchange=function(e){
    let readerfirma = new FileReader();
    readerfirma.readAsDataURL(e.target.files[0]);
    readerfirma.onload = function(){
        let previewfirma = document.getElementById("previewfirma");
        let fpfirma = document.getElementById("fpfirma");
        imagenfirma = document.createElement('img');
        imagenfirma.src = readerfirma.result;
        imagenfirma.style.maxWidth="100%";
        imagenfirma.style.maxHeight="100%";
        previewfirma.innerHTML="";
        previewfirma.append(imagenfirma);
        fpfirma.style.display="none";
    }
}

//PREVIEW FOTO DOCUMENTO
document.getElementById("filehuella").onchange=function(e){
    let readerhuella = new FileReader();
    readerhuella.readAsDataURL(e.target.files[0]);
    readerhuella.onload = function(){
        let previewhuella = document.getElementById("previewhuella");
        let fphuella = document.getElementById("fphuella");
        imagenhuella = document.createElement('img');
        imagenhuella.src = readerhuella.result;
        imagenhuella.style.maxWidth="100%";
        imagenhuella.style.maxHeight="100%";
        previewhuella.innerHTML="";
        previewhuella.append(imagenhuella);
        fphuella.style.display="none";
    }
}

//MOSTRAR BOTON GUARDAR 1
document.getElementById("lbltit").addEventListener("click", mostrar_tit);
document.getElementById("edittit").addEventListener("click", ocultar_tit);

edittit = document.getElementById("edittit");
lbltit = document.getElementById("lbltit");

function mostrar_tit(){
    edittit.style.display = "block";
    lbltit.style.display = "none";
}
function ocultar_tit(){
    edittit.style.display = "none";
    lbltit.style.display = "block";
}

//MOSTRAR BOTON GUARDAR 2
document.getElementById("lblfirma").addEventListener("click", mostrar_firma);
document.getElementById("editfirma").addEventListener("click", ocultar_firma);

editfirma = document.getElementById("editfirma");
lblfirma = document.getElementById("lblfirma");


function mostrar_firma(){
    editfirma.style.display = "block";
    lblfirma.style.display = "none";
}
function ocultar_firma(){
    editfirma.style.display = "none";
    lblfirma.style.display = "block";
}

//MOSTRAR BOTON GUARDAR 3
document.getElementById("lblhuella").addEventListener("click", mostrar_huella);
document.getElementById("edithuella").addEventListener("click", ocultar_huella);

edithuella = document.getElementById("edithuella");
lblhuella = document.getElementById("lblhuella");

function mostrar_huella(){
    edithuella.style.display = "block";
    lblhuella.style.display = "none";
}
function ocultar_huella(){
    edithuella.style.display = "none";
    lblhuella.style.display = "block";
}
