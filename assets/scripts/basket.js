$(".radio-address").change(function() {
    $(".container-address.active").each(function(){
        $(this).removeClass("active")
    })
    $(this).parent().parent().addClass("active")
});