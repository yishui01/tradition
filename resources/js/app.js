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
            q = $(this).val()
            $.ajax({
                url:"/search?q="+q,
                method:"get",
                success:function (data) {
                    var h = "";
                    if (data.length == 0){
                        h= '<div class="message empty"><div class="header">结果为空</div><div class="description">搜索结果为空！</div></div>'
                    } else {
                        for (let i=0;i<data.length;i++){
                            h += ' <a class="result" href="'+data[i].url+'"><div class="image">\n' +
                                '<img src="'+data[i].avatar+'"></div><div class="content">\n' +
                                '<div class="title">'+data[i].title+'</div>\n' +
                                '<div class="description">'+data[i].excerpt+'</div>' +
                                '</div></a>'
                        }
                    }
                    console.log(h)
                    h += '<a href="/search/list?q='+q+'" class="action"><i class="fa fa-search icon"></i>当前列表仅搜加精，更多请搜全站</a>'
                    $(".results").html(h)
                    $(".results").fadeIn("slow");
                }
            })
        }, 200)
    })

})
