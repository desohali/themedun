document.getElementById("fototitulo").onchange=function(e){
    let reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = function(){
        let preview1 = document.getElementById("previewimage1");
        let labelimage1 = document.getElementById("labelimage1");
        let icimage1 = document.getElementById("icon-image1");
        imagen1 = document.createElement('img');
        imagen1.src = reader.result;
        imagen1.style.maxWidth="100%";
        imagen1.style.maxHeight="100%";
        preview1.innerHTML="";
        preview1.append(imagen1);
        labelimage1.style.background="transparent";
        labelimage1.style.border="transparent";
        icimage1.style.color="transparent";
    }
}

document.getElementById("fotofirma").onchange=function(e){
    let reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = function(){
        let preview2 = document.getElementById("previewimage2");
        let labelimage2 = document.getElementById("labelimage2");
        let icimage2 = document.getElementById("icon-image2");
        imagen2 = document.createElement('img');
        imagen2.src = reader.result;
        imagen2.style.maxWidth="100%";
        imagen2.style.maxHeight="100%";
        preview2.innerHTML="";
        preview2.append(imagen2);
        labelimage2.style.background="transparent";
        labelimage2.style.border="transparent";
        icimage2.style.color="transparent";
    }
}

document.getElementById("fotohuella").onchange=function(e){
    let reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = function(){
        let preview3 = document.getElementById("previewimage3");
        let labelimage3 = document.getElementById("labelimage3");
        let icimage3 = document.getElementById("icon-image3");
        imagen3 = document.createElement('img');
        imagen3.src = reader.result;
        imagen3.style.maxWidth="100%";
        imagen3.style.maxHeight="100%";
        preview3.innerHTML="";
        preview3.append(imagen3);
        labelimage3.style.background="transparent";
        labelimage3.style.border="transparent";
        icimage3.style.color="transparent";
    }
}