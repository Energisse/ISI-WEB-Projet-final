$(".toggleEditReview").on("click", function () {
    $("#user-review").css("display", $("#form-review").css("display"));
    $("#form-review").css("display", $("#form-review").css("display") == "none" ? "block" : "none");
});