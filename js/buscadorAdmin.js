// $(buscar_datos());

function buscar_datos(consulta){
    $.ajax({
        url: 'themeduni/activos.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta: consulta},
    })
    .done(function(respuesta){
        $("#box-search").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    })
}

$(document).on('keyup', '#buscapro', function(){
    var valor = $(this).val();
    if(valor != ""){
        buscar_datos(valor);
    }else{
        buscar_datos();
    }
});
