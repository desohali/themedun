$(document).ready(()=>{
    $(".desmarks").click(function(){
        var id = this.id;
        var desmar = `.desmarcado${id}`;
        var mar = `.marcado${id}`;
        $(desmar).css('display','none');
        $(mar).css('display','inline-block');
	});
    $(".marks").click(function(){
        var ids = this.id;
        var desmars = `.desmarcado${ids}`;
        var mars = `.marcado${ids}`;
        $(mars).css('display','none');
        $(desmars).css('display','inline-block');
	});
});
