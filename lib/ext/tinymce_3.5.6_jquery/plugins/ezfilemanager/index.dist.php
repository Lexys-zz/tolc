<?php
include("includes/config.inc.php");
include("langs/".LANG.".inc.php");
include("includes/ezf.class.php");
$ezf = new ezFilemanager();
$ezf->login();
$ezf->check_post_data();
$ezf->basic_hack_block();
$ezf->set_max_upload_size();
$ezf->ezf_actions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo LANG?>" lang="<?php echo LANG?>">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?php echo TXT_EZFM." ".EZ_VERSION?></title>
<link  href="css/site.css" rel="stylesheet" type="text/css" />
<meta name="robots" content="noindex, nofollow" />
<script type="text/javascript" src="js/jquery/jquery-1.3.2.min.js"></script>
<script type='text/javascript' src='js/jquery/jquery-ui-1.7.2.custom.min.js'></script>
<script type="text/javascript" src="js/jquery/jquery.form.js"></script>
<script type='text/javascript' src='js/jquery/jquery.tools.min.js'></script>
<script type='text/javascript' src='js/jquery/jquery.jeditable.js'></script>
<?php  if (isset($_GET['tmce'])){
if ($_GET['tmce']==1){
?>
<!--  Your tiny_mce_popup.js path might be different, change it accordingly-->
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<?php }?>
<script type="text/javascript" src="js/ez_tinyMCE_insert.js"></script>
<?php }?>
<script type='text/javascript' src='js/jquery/jquery.contextMenu.js'></script>
<link  href="css/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<link  href="favicon.ico" rel="shortcut icon" type="image/ico" />

<script type="text/javascript">
/* INITIALISE TABS */
$(function() {
   $("ul.tabs").tabs("div.panes > div");
}); 
/* END INITIALISE TABS */
<?php if (ENABLE_DELETE){?>
/* DELETE CHECKED DIRECTORY-FILES*/
 $(function() {
 $("#dodelete").click(function() {
   if (CheckifCheckBoxChecked()){
   var delMsg = confirm("<?php echo TXT_QUSTION?>\n\n<?php echo TXT_DO_CLICK?>\n\n");
	if (delMsg == true) {
            var form = window.document.forms["ezbrowser"];
            form.elements["action"].value = "delete";
        return true;
        }
    return false;
  }else{
    alert('<?php echo TXT_FILE_NO?>');
    return false;
 }
});
});

 function CheckifCheckBoxChecked()
  {
    var is_checked=false;
   $("input[type='checkbox']:checked").each(function(){
          //Check if checkbox is checked
         if($(this).is(':checked'))
         {
            if ($(this).attr('id') !== 'select_all'){
            is_checked=true;
            }
         }
      }
    );
    if (is_checked==1){
    return true;
    }else{
    return false;
    }
  }
  /* END DELETE CHECKED DIRECTORY-FILES*/
<?php }?>
/* DO IMAGE PREVIEW*/
this.imagePreview = function(){
	// these 2 variable determine popup's distance from the cursor
	// you might want to adjust to get the right result
        xOffset=10;
        yOffset = 10;
       	/* END CONFIG */
	$("a.preview").click(function(e){
            e.preventDefault();
            var loadurl = encodeURI($(this).attr("rel"));
             $('#folderinfo').hide();
            $('#stats-placeholder').html("<img src='css/images/indicator.gif' />");
            $('#stats-placeholder').load("?action=info&st="+loadurl);
        }),
	$("a.preview").hover(function(e)
        {
        var linalt = encodeURI($(this).attr("rel"));
        <?php if (PREVIEW_IMAGE_ENABLE){?>
        <?php if (PREVIEW_ON_THE_FLY){?>
            //alert(linalt);
            $("body").append("<div id='preview'><img src='index.php?action=preview&f="+ linalt +"'></div>");
            <?php }else{?>
            var imgheight = $(this).attr("id");
            var tempsize = new Array();
            var tempsize = imgheight.split('_');
            xOffset = parseInt(tempsize[2])+10; //Fix screen flicker
            $("body").append("<div style='width:"+tempsize[1]+"px;height:"+tempsize[2]+"px;overflow:hidden;' id='preview'><img src='<?php echo SITE_URL?>/"+ linalt +"' width='"+tempsize[1]+"' height='"+tempsize[2]+"'></div>");
    <?php }?>
            $("#preview")
            .css("top",(e.pageY - xOffset) + "px")
            .css("left",(e.pageX + yOffset) + "px")
            .fadeIn("fast");
           <?php }?>
        },
	function(){
		$("#preview").remove();
        });
	$("a.preview").mousemove(function(e)
        {
	    $("#preview")
		.css("top",(e.pageY - xOffset) + "px")
		.css("left",(e.pageX + yOffset) + "px");
                $(".contextMenu").hide();
	});

};/* END DO IMAGE PREVIEW*/
/* DO UPLOAD, MAKEDIR AND DOWNLOAD*/
$(document).ready(function() {
   $('a#folder-info').click(function() {
 $('#folderinfo').slideToggle();
  });
       var options = {
        target:        '#info',   // target element(s) to be updated with server response
        beforeSubmit:  showRequest,  // pre-submit callback
        success:       showResponse,  // post-submit callback
        clearForm: true,        // clear all form fields after successful submit
        resetForm: true        // reset the form after successful submit
       // timeout:   6000    //AJAX timeout, disable if uploading multible large files
    };
    // bind to the form's submit event
    $('#upload_form').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
   imagePreview();
/* DO MAKEDIR*/
  $("form#make_dir_form").submit(function()
      {

   var dir_to_make =$('#newdir').attr('value');
    var current_dir ='<?php echo CURRENT_PATH;?>';
     var dir_to_make_msg="";
    dir_to_make = dir_to_make.replace(/(\r\n|\r|\n)/g, "|splithere|") ;
    <?php echo $ezf->allow_space('makedir')?>
    dir_to_make = dir_to_make.replace(/[^a-zA-Z 0-9\_\-\||]+/g,'');
   dir_to_make_msg = dir_to_make.replace("|splithere|",", ");
    if (dir_to_make=='')
    {
      alert("<?php echo TXT_ERROR.": ".TXT_DIR_NO?>");
  return false;
    }
    $('#infomakedir').html("<img src='css/images/indicator.gif' />");
    $("#infomakedir").html('<?php echo TXT_CREATING?>....'+dir_to_make_msg);
    $.post("index.php?action=makefolder", {make_dir: '1', the_dir:dir_to_make,current_dir:current_dir},
      function(data) {
	    $("#infomakedir").html(data);
        });
var timer = reloadTimer({  seconds:<?php echo RELOAD_PAGE?>});
timer.start();
return false;
	 });
<?php if (ENABLE_RENAME){?>
/* INLINE FILE-DIRECTORY RENAME*/
//CUSTOM TYPE
$.editable.addInputType('webnaz', {
    element : function(settings, original) {
         var default_textarea = $.editable.types['text'].element
         var input = default_textarea.apply(this, [settings, original]);
         return(input);
     },
    submit : function(settings, original) {
         var value = $(':input:first', this).val();
         <?php echo $ezf->allow_space('rename')?>
         value = value.replace(/[^a-zA-Z 0-9 _-]+/g,'');
         $(':input:first', this).val(value);
     }
 });
     $(".editable_textarea").editable("index.php", {
      indicator : "<img src='css/images/indicator.gif'>",
      type   : 'webnaz',
      submitdata: { _method: "put" },
      select : true,
      onblur :  "submit",
      event     : "dblclick",
      tooltip   : "<?php echo TXT_CLICK_EDIT?>",
       style   : 'inherit',

    callback : function(value, settings) {
    el = $(this);
    var linkid = $(this).attr("id");
    var classid = $(this).attr("class");
    var temp = new Array();
    var temp = linkid.split('|');
    el.removeClass("editable_textarea").addClass("editable_textarea_red");
       if (temp[3]=='file'){
            var newid =temp[0]+"|"+value+"."+temp[2]+"|"+temp[2]+"|"+temp[3]+"|"+temp[4]+"|"+temp[5];
            jQuery(this).attr("id",newid);
            $('#'+temp[5]).attr('rel', temp[0]+value+'.'+temp[2]+'')
            $('#'+temp[5]).attr('href', '/'+temp[0]+value+'.'+temp[2]+'')
            $('#delfile'+temp[5]).attr('name', 'delete_file['+temp[0]+value+'.'+temp[2]+']');
            $("#stats-placeholder").html("<?php echo TXT_CLICK?>");
            $('#filefactory').load('index.php?action=after_rename&w='+encodeURI(temp[0])+encodeURI(value)+'.'+temp[2]);
       }else{
            var newid =temp[0]+"|"+value+"|"+temp[2]+"|"+temp[3]+"|"+temp[4];
            jQuery(this).attr("id",newid);
            $('#durl'+temp[4]).attr('href', '?p='+temp[0]+value+'/<?php echo $ezf->type_url()?>');
            $('#delimput'+temp[4]).attr('name', 'delete_dir['+temp[0]+value+']');
        }
    }
});
<?php }?>
$("a.popup").click(function(e){
    e.preventDefault();
    $('#folderinfo').hide();
    var loadurl = $(this).attr("rel");
    $('#stats-placeholder').html("<img src='css/images/indicator.gif' />");
    $('#stats-placeholder').load("?action=info&st="+encodeURI(loadurl));
});
$("tr:even").css("background-color", "#f4f4f8");
$("tr:odd").css("background-color", "#eff1f1")
//handle the mouseover/mouseout event
$("#filebrowsertbl tr").mouseover(function() {$(this).addClass("rowhover");}).mouseout(function() {$(this).removeClass("rowhover");});
$("#select_all").click(function()				
    {
	var checked_status = this.checked;
        $("input[type='checkbox']").each(function()
	    {
                if ($(this).attr('disabled') !== true){
		    this.checked = checked_status;
                }
	    });
    });
//CONTEXT

$("#myview a").contextMenu({
    menu: 'myMenu',
    <?php if (ENABLE_COPY){ ?>
     myoffset: 100
     <?php }else{?>
     myoffset: 50
     <?php }?>
    },
	function(action, el, pos) {
            if (action=='download'){
                window.open('index.php?action=info&d=1&st='+encodeURI($(el).attr('href').substr(1)));
                return false;
            }
            if (action=='copy'){
                $('#filefactory').load('index.php?action=copy&w='+encodeURI($(el).attr('href').substr(1)));
                $('#myDirMenu').enableContextMenuItems('#paste');
                 $("#ezpaste").html("<img  src='css/images/paste.png' alt='<?php echo TXT_PASTE?>' />");
                

            }
            if (action=='cancel'){
                $('#myDirMenu').disableContextMenuItems('#paste');
                $('#filefactory').load('index.php?action=cancel');
                $("#ezpaste").html("");
               
            }
            
            if (action=='delete'){
                var delMsg = confirm("<?php echo TXT_QUSTION?>\n\n<?php echo TXT_DO_CLICK?>\n\n");
                if (delMsg == true) {
                    $('#filefactory').load('index.php?action=sdelete&w='+encodeURI($(el).attr('href').substr(1)));
                    timedRefresh(<?php echo (RELOAD_PAGE)?>);
                    return true;
                }
                return false;
            }
           
$("#preview").remove();
    });
<?php if (ENABLE_COPY){ ?>
$("#folder a").contextMenu({
    menu: 'myDirMenu',
     myoffset: 60
    },
	function(action, el, pos) {
            if (action=='paste'){
               var what= $(el).attr('href').substr(3);
                $('#filefactory').load('index.php?action=paste&w='+encodeURI(what));
                $('#myDirMenu').disableContextMenuItems('#paste');
                 $("#ezpaste").html('');
            }
            if (action=='cancel'){
                $('#myDirMenu').disableContextMenuItems('#paste');
                $('#filefactory').load('index.php?action=cancel');
                 $("#ezpaste").html('');
            }
            
           

    });
$("a.pastehere").click(function(e){
    e.preventDefault();
        $('#filefactory').load(this.href, null, function(){
        timedRefresh(<?php echo (RELOAD_PAGE+120)?>);          
        });
    });
<?php }?>
<?php if (file_exists(ABSOLUT_PATH.UPLOAD_DIR.".ezaccess")){?>
    $('#filefactory').load('index.php?action=d');
     $("#ezpaste").html("<img  src='css/images/paste.png' alt='<?php echo TXT_PASTE?>' />");
<?php }else{?>
     $('#myDirMenu').disableContextMenuItems('#paste');
      $("#ezpaste").html('');
<?php } ?>
//END ON READY
});
//Close file info box
$("a.close").live("click", function(e){
        e.preventDefault();
        $('#folderinfo').show();
        $("#stats-placeholder").html("<?php echo TXT_CLICK?>");

    });
//Copy
$("a.ezcopy").live("click", function(e){
    $("#filefactory").load(encodeURI(this.href));
    $("#myDirMenu").enableContextMenuItems("#paste");
    $("#ezpaste").html("<img  src='css/images/paste.png' alt='<?php echo TXT_PASTE?>' />");
    e.preventDefault();
});
</script>
<script>
// pre-submit callback
function showRequest(formData, jqForm, options) {
    var num_to_upload     = $('#upload_form :numfiles').fieldValue()[0];
        var i=1;
        var x=0;
        var can_upload= 1;
    for (i=1;i<=num_to_upload;i++)
    {
    var file_to_upload =$('#upload_form :filename'+i).fieldValue()[i+(i-1)];
    var file_to_rename =$('#upload_form :newfilename'+i).fieldValue()[i+i];
        if (file_to_rename=='' || file_to_upload=='')
        {
        alert("#"+i+" <?php echo TXT_ERROR.": ".TXT_RENAME."/".TXT_SELECT_FILE;?>");
        can_upload= 0;
        return false;
        }
    }
    if (can_upload==1){
        $("#info").html("<img src='css/images/indicator.gif' /> <?php echo TXT_UPLOADING?>....");
        return true;
    }else{
        return false;
    }
}
// post-submit callback
function showResponse(responseText, statusText)  {
   var timer = reloadTimer({  seconds:<?php echo RELOAD_PAGE?>});
    timer.start();
}
</script>
<script type="text/javascript">
function addnewupload(){
var html = "";
var file_to_upload=(parseInt(document.forms['upload_form'].numfiles.value)+1);
var spanid = "uploaddiv"+(parseInt(document.forms['upload_form'].numfiles.value)+1);
    if (file_to_upload<=<?php echo MAX_SIM_UPLOAD ?>)
    {
    html += '<div class="rename"><span class="red">#'+file_to_upload+'</span> <?php echo TXT_RENAME?></div>';
    html += '<div class="selectfile"><?php echo TXT_SELECT_FILE." (".TXT_MAX_UPLOAD." <span class=\"bold\">".$ezf->bytestostring(MAX_UPLOAD_SIZE)."</span>)";?></div>';
    html += '<div class="clear_left"></div>';
    html += '<input id="newfilename'+file_to_upload+'" name="newfilename'+file_to_upload+'" type="text" size="35" class="fieldtext" maxlength="200" style="width: 180px" value="" />';
    html += ' <input type="file" name="filename'+file_to_upload+'" id="filename'+file_to_upload+'"   class="fieldtextfile"  onchange="updateFileName(this,\''+file_to_upload+'\')" />';
    document.forms['upload_form'].numfiles.value = file_to_upload;
    document.getElementById('remupload').style.visibility = 'visible';
    x=document.getElementById(spanid);
    x.innerHTML=html;
    if (file_to_upload==<?php echo MAX_SIM_UPLOAD ?>){
        document.getElementById('addupload').style.visibility = 'hidden';
        document.getElementById('addupload').style.width = '1px';
        }
    }else{
    alert('max limit');
    }
}
function remove_upload() {
    var file_to_remove=document.forms['upload_form'].numfiles.value;
    if (file_to_remove>1)
    {
    var file_to_upload=(parseInt(document.forms['upload_form'].numfiles.value)-1);
    document.forms['upload_form'].numfiles.value = file_to_upload;
    try {
        x=document.getElementById('uploaddiv'+file_to_remove);
        x.innerHTML="";
        } catch (e) { }
    }
    if (file_to_remove==2)
        document.getElementById('remupload').style.visibility = 'hidden';
    if (file_to_remove<=<?php echo MAX_SIM_UPLOAD ?>)
    {
        document.getElementById('addupload').style.visibility = 'visible';
        document.getElementById('addupload').style.width = '';
    }
}//
function updateFileName(thefile,theid) {
    var uploadfileName = thefile.value;
    var renameto="newfilename"+theid;
    var pos = uploadfileName.lastIndexOf('/');
    pos = pos == -1 ? uploadfileName.lastIndexOf('\\') : pos;
    if (pos > 0) {
	uploadfileName = uploadfileName.substring(pos+1);
	    if ((pos = uploadfileName.lastIndexOf('.')) != -1)
		uploadfileName = uploadfileName.substring(0, pos);
        uploadfileName = decodeURI(uploadfileName);
        <?php echo $ezf->allow_space('upload')?>
        uploadfileName = uploadfileName.replace(/[^a-zA-Z 0-9 _-]+/g,'');
        document.getElementById(renameto).value =  uploadfileName;
    }else{
        if ((pos = uploadfileName.lastIndexOf('.')) != -1)
	    uploadfileName = uploadfileName.substring(0, pos);
        uploadfileName = decodeURI(uploadfileName);
        <?php echo $ezf->allow_space('upload')?>
        uploadfileName = uploadfileName.replace(/[^a-zA-Z 0-9 _-]+/g,'');
        document.getElementById(renameto).value = uploadfileName;
    }
}
//timers
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
}
var reloadTimer = function (options) {
var seconds = options.seconds || 0;
this.start = function () {
    setTimeout(function (){
        window.location.href = window.location;
        }, seconds * 1000);
    }
    return this;
};
</script>
<?php
   if (BRANDING){
    echo '<link  href="css/branding/branding.css" rel="stylesheet" type="text/css" />';
   }
   ?>
</head>
<body>
<div id='container'>
   <?php
   if (BRANDING){
    include("css/branding/branding.inc.php");
   }
   ?>
      <ul class="tabs">
      <li><a href="#" class='xl'><?php echo TXT_EZFM." ".EZ_VERSION?></a></li>
      <?php if (MAX_SIM_UPLOAD>0){?>
      <li><a href="#" class='s'><?php echo TXT_UPLOAD?></a></li>
      <?php }?>
      <?php if (ENABLE_NEW_DIR){?>
      <li><a href="#" class='l'><?php echo TXT_NEW_DIR?></a></li>
      <?php }?>
    </ul>
  <div class="panes">
    <div class='whatever'>
      <form method="post" action="" id="ezbrowser"  name="ezbrowser">
        <?php include("includes/toolbar.inc.php")?>
        <?php include("includes/tab_filebrowser.inc.php")?>
        </form>
        <div id='panel'><?php include("includes/panel_filebrowser.inc.php")?></div>
        <div class='clear_left'></div>
    </div>
    <?php if (MAX_SIM_UPLOAD>0){?>
    <div class='whatever'>
   <?php include("includes/tab_file_upload.inc.php")?>

    </div>
     <?php }?>
      <?php if (ENABLE_NEW_DIR){?>
    <div class='whatever'>
 <?php include("includes/tab_make_directory.inc.php")?>
    </div>
     <?php }?>
  </div>
</div>
<ul id="myMenu" class="contextMenu">
    <li class="download">
        <a href="#download"><?php echo TXT_DOWNLOAD;?></a>
    </li>
    <?php if (ENABLE_COPY){ ?>
    <li class="copy separator">
        <a href="#copy"><?php echo TXT_COPY;?></a>
    </li>
    <li class="cancel">
        <a href="#cancel"><?php echo TXT_CANCEL_COPY;?></a>
    </li>
    <li class="delete">
        <a href="#delete"><?php echo TXT_DELETE_FILE;?></a>
    </li>
    <?php } ?>
    <li class="quit separator">
        <a href="#quit"><?php echo TXT_CLOSE;?></a>
    </li>
</ul>
    <?php if (ENABLE_COPY){ ?>
<ul id="myDirMenu" class="contextMenu">
    <li class="paste">
        <a href="#paste"><?php echo TXT_PASTE;?></a>
    </li>
    <li class="cancel">
        <a href="#cancel"><?php echo TXT_CANCEL_COPY;?></a>
    </li>
    <li class="quit separator">
        <a href="#quit"><?php echo TXT_CLOSE;?></a>
    </li>
    
</ul>
<?php } ?>
</body>
</html>