jQuery(document).ready( function(){
    $('#registrationFormModal').modal;
    $('#enterFrom').modal;
    var sortInfo = new Array();
    checkURL();
    $('.sortable').on("click", function(){
        var sort, sortobj, data, url;
        sortobj = $(this).attr("id");
        $(this).find("p").removeClass(sortInfo[sortobj]);
        sort = sortInfo[sortobj];
        if(sort == "ASC") {
            sort = "DESC";
        } else {
            sort = "ASC";
        }
        $(this).find("p").addClass(sort);
        url = $(this).parents('table').data('url');
        data = sortobj+' '+sort;
        $.post( url,{ data:data}, function( data ) {
            $("#result").html( data );
            sortInfo[sortobj]= sort;
        });
    });
    function checkURL() {
        var url = location.pathname;
        $("nav").find("li").each(function(){
            if($(this).find('a').attr('href') == url) {
                $(this).addClass('active');
            }
        });
    }
    $('.back-office-block').on('click', "input[type='checkbox']", function(){
        var state = $(this).prop("checked");
        $(this).closest('ul').find("input").each(function() {
            if(state) {
                $(this).prop("checked", true) ;
            } else {
                $(this).prop("checked", false);
            }
        });
    });
});