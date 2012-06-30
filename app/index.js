$(function () {

    var target = $(this);
    $.ajax({
        type: 'POST',
        url: $("#project_url").val() + "/app/ajax_retrieve_page.php",
        data: {
            url: $("#url").val()
        },
        success: function (data) {

            var html_title = '';
            var j = $.parseJSON(data);

            $.each(j, function (index, value) {
                if (j[index].group == 'html_title') {
                    html_title = j[index].val;
                    console.log('html_title=' + html_title);
                }
                if (j[index].group == 'active_divs') {

                }
            });

            target.attr("title", html_title);
        }
    });

    $(".btn-slide").click(function(){
        $("#tolc_panel").slideToggle("slow");
        return false;
    });

    //$(this).attr("title", html_title);
    //$("#test").html("<h1>τεστ 123</h1>");
});