$("#search").on("keyup", function () {
    fetch("/product/search", {
        method: "post",
        body: JSON.stringify({
            "searchName": $(this).val()
        })
    })
        .then((res) => res.json())
        .then((res) =>
            res.map(({ id, name, image }) =>
                `<a href="/product/${id}" class="list-search-element"><img src="/assets/public/productimages/${image}"/>${name}</a>`
            ).join("")
        )
        .then((res) => {
            $("#list-search").html(res)
            if (res) {
                $("#list-search").css("visibility", "visible");
            }
            else {
                $("#list-search").css("visibility", "hidden");
            }
        })
        .catch(console.error)
        .finally(() => console.log("fini"))
})

$("#container-list-and-search").on("click", function (event) {
    event.stopPropagation();
})

$(document).on("click", function () {
    $("#list-search").css("visibility", "hidden");
})

$("#search").on("focusin", function () {
    if (!$("#list-search").html().trim()) return;
    $("#list-search").css("visibility", "visible");
})