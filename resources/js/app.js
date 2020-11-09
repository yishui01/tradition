require('./bootstrap');

$(function () {
    /************** 头部搜索 ***************/
    var searchTimer = false;
    $(".searchInput").focus(function (v) {
        $(this).parent().addClass("focus")
    })
    $(".searchInput").blur(function (v) {
        $(this).parent().removeClass("focus")
    })
    $(".searchInput").on("input", function (v) {
        if (searchTimer) {
            clearTimeout(searchTimer)
            searchTimer = false;
        }
        searchTimer = setTimeout(() => {
            $.ajax({
                url:"/search?q="+$(this).val(),
                method:"get",
                success:function (data) {
                    console.log(data)
                }
            })
        }, 200)
    })

})
