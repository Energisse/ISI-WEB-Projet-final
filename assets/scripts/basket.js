$("#addresses-table tr").on("click", function () {
    $(this).find(".radio-address").prop("checked", true)
    $("#addresses-table tr").each(function () {
        $(this).removeClass("active")
    })
    $(this).find(".radio-address").parent().parent().addClass("active")
})