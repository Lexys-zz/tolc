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
                }
                if (j[index].group == 'active_divs') {

                }
            });

            target.attr("title", html_title);
        }
    });

    if($("#admin_mode").val() == '0' && $("#new_page").val() == '1') {
        $("#login_required_new_page").dialog({
            autoOpen: true,
            show: "blind",
            hide: "explode",
            width: 300,
            height: 200
        });
    }





    if($("#admin_mode").val() == '1') {
        $("#tolc_btn_slide").click(function(){
            $("#tolc_panel").slideToggle("slow");
            return false;
        });

        $("#tp_edit_page").button({
            icons: {
                primary: 'ui-icon-pencil'
            }
        });

        $("#tp_sitemap").button({
            icons: {
                primary: 'ui-icon-pin-w'
            }
        });

        $("#tp_templates").button({
            icons: {
                primary: 'ui-icon-wrench'
            }
        });

        $("#tp_users").button({
            icons: {
                primary: 'ui-icon-person'
            }
        });

        $("#tp_logout").button({
            icons: {
                primary: 'ui-icon-power'
            }
        });

        $("#tp_about").button({
            icons: {
                primary: 'ui-icon-home'
            }
        });
    }



    //$(this).attr("title", html_title);
    //$("#test").html("<h1>τεστ 123</h1>");
});