document.getElementById("file-1").onchange=function(e){
    let reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = function(){
        let preview = document.getElementById("previewimage");
        let labelimage = document.getElementById("labelimage");
        let icimage = document.getElementById("icon-image");
        imagen = document.createElement('img');
        imagen.src = reader.result;
        imagen.style.maxWidth="100%";
        imagen.style.maxHeight="188px";
        preview.innerHTML="";
        preview.append(imagen);
        labelimage.style.background="transparent";
        labelimage.style.border="transparent";
        icimage.style.color="transparent";
    }
}
