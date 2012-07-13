$(document).ready(function() {
$("input[type='text']").dblclick(function(){
     var dir =$(this).attr("dir");
if (typeof dir != 'undefined' && dir != '') {
     var querystr= "?tmce=2&p="+dir;   
    
}else{
    var querystr= "?tmce=2";    
}
		var windowname =$(this).attr("id");
		var newWindow = window.open("http://"+document.domain+"/tinymce/jscripts/tiny_mce/plugins/ezfilemanager/index.php"+querystr,windowname,"scrollbars=yes,status=yes,menubar=no,toolbar=no,resizeable=no,height=680,width=720");
            });

        });