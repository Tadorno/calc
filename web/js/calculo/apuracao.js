$(document).ready(function(){
    $('#calculo-content').on('click', '.treeview-item', function(event) {
                
        nodeid = $(this).data('nodeid');
        nodesinal = $(this).data('nodesinal');

        if(nodesinal === "+"){
            $(this).data('nodesinal', '-');
            $(".span_" + nodeid).removeClass("glyphicon-plus");
            $(".span_" + nodeid).addClass("glyphicon-minus");
            $("#treeview ." + nodeid).removeClass("hide");
        }else{
            $(this).data('nodesinal', '+');
            $(".span_" + nodeid).addClass("glyphicon-plus");
            $(".span_" + nodeid).removeClass("glyphicon-minus");
            $("#treeview ." + nodeid).addClass("hide");
        }
        
    });
});