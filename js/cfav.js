$(document).ready(()=>{
    $(".heartfav").click(function(){
        var id = this.id;
        $(".box"+id).css('display','none');
	});
});