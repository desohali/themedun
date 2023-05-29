//PREVIEW FOTO DE PERFIL
/* document.getElementById("bbfile2").onchange=function(e){
    let reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = function(){
        let preview = document.getElementById("previewperfil");
        imagen = document.createElement('img');
        imagen.src = reader.result;
        imagen.style.width="100%";
        imagen.style.height="197px";
        preview.innerHTML="";
        preview.append(imagen);
    }
} */

document.getElementById("form2").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("editip", "editip");

    const response = await fetch("", {
        method: "post",
        body: formData
    });
    const text = await response.text();

    window.location.reload();

});

const canvas = document.getElementById("canvasPerfil");
const ctx = canvas.getContext("2d");
canvas.width = 200;
canvas.height = 200;


const inputFile = document.getElementById("bbfile2");

inputFile.addEventListener("change", (e) => {
    const [firstFile] = e.target.files;
    resizeImage(firstFile, { width: 200, height: 200 });
});

document.getElementById("formFoto").addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!inputFile.files.length) {
        Swal.fire(
            'Imagen no seleccionada',
            'Seleccione una imagen disponible.',
            'error'
            )
        return;
    }

    const [,fotoMini] = canvas.toDataURL("image/png", 1).split(",");
    const formData = new FormData(this);
    formData.append("editfoto", "editfoto");
    formData.append("fotoMini", fotoMini);

    const response = await fetch("", {
        method: "post",
        body: formData
    });
    const text = await response.text();


    window.location.reload();


});

function resizeImage(img, { width, height }) {

    const sizeCanvas = width;

    /* let width = 0;
    let height = 0; */

    let positionX = 0;
    let positionY = 0;

    const newImg = new Image();
    newImg.src = window.URL.createObjectURL(img);
    newImg.addEventListener("load", function () {
        width = canvas.width;
        height = ((this.height * width) / this.width);

        positionX = 0;
        positionY = (height < sizeCanvas) ? ((sizeCanvas - height) / 2) : 0;

        ctx.fillStyle = "#ecf0f1";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(this, positionX, positionY, width, height);
        window.URL.revokeObjectURL(this.src);

    }, false);


    let editCanvasMouse = function (e) {

        positionX = (e.offsetX - (width / 2));
        positionY = (e.offsetY - (height / 2));

        ctx.clearRect(0, 0, sizeCanvas, sizeCanvas);
        ctx.fillStyle = "#ecf0f1";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(newImg, positionX, positionY, width, height);

    };

    let editCanvasTouch = function (e) {

        positionX = (e.changedTouches[0].offsetX - (sizeCanvas / 2)),
            positionY = (e.changedTouches[0].offsetY - (height / 2))

        ctx.clearRect(0, 0, sizeCanvas, sizeCanvas);
        ctx.fillStyle = "#ecf0f1";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(newImg, positionX, positionY, width, height);
    }, move = true;

    canvas.addEventListener("click", function (e) {
        if (move) {
            canvas.addEventListener("mousemove", editCanvasMouse, false);
            canvas.addEventListener("touchmove", editCanvasTouch, false);
            Object.assign(canvas.style, {
                boxShadow: "0px 0px 3px 2px orange",
                cursor: "move"
            });
            move = false;
        } else {
            canvas.removeEventListener("mousemove", editCanvasMouse, false);
            canvas.removeEventListener("touchmove", editCanvasTouch, false);
            Object.assign(canvas.style, {
                boxShadow: "0px 0px 3px 2px teal",
                cursor: "pointer"
            });
            move = true;
        }
    }, false);

    /* document.getElementById("zoomPerfil").addEventListener("input", function (e) {
        console.log('this.value', this.value)
        width = (width + Number(this.value));
        height = (height + Number(this.value));
  
        ctx.clearRect(0, 0, sizeCanvas, sizeCanvas);
        ctx.fillStyle = "white";
        ctx.fillRect(0, 0, sizeCanvas, sizeCanvas);
        ctx.drawImage(newImg, positionX, positionY, width, height);
      }); */
}

//PREVIEW INFPER
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
