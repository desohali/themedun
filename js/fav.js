$(document).ready(function(){
    $(".heartfav").click(function(){
        var id = this.id;
        $.ajax({
			url: 'fav.php',
			type: 'post',
			data: {id:id},
			dataType: 'json',
			success: function(data) {
				var img = data['img'];

					$('#'+id).html(img);
			}
		});

	});

});

