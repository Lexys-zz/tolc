<?php if ( ! defined('SITE_URL')) exit('No direct script access allowed');?>
<?php
session_start();
    if(!isset($_SESSION[AUTHENTICATION_SESSION_NAME]))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo LANG?>" lang="<?php echo LANG?>">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?php echo TXT_EZFM." ".EZ_VERSION?></title>
<link  href="css/site.css" rel="stylesheet" type="text/css" />
<?php
   if (BRANDING){
    echo '<link  href="css/branding/branding.css" rel="stylesheet" type="text/css" />';
   }
   ?>
<meta name="robots" content="noindex, nofollow" />
<style>
label { position: absolute; text-align:right; width:130px; }
input, textarea { margin-left: 140px; }
</style>
</head>

<body>
    <div id='container'>
    <?php
   if (BRANDING){
    include("css/branding/branding.inc.php");
   }
   ?>
    <?php
    if (ENABLE_FORM_TOKEN){
    $key = substr(md5(KEY_2),0,mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CFB));
    $encrypted_value = base64_encode(mcrypt_encrypt(MCRYPT_BLOWFISH, md5(KEY_1), SECRET, MCRYPT_MODE_CFB, $key));
        //Now create a decent hash with a 10 character salt
    $salt = substr(md5(uniqid(rand(), true)), 0, 10);
    $hashed_value = $salt . substr(sha1($salt . SECRET),-10);
  
    if (isset($_POST['encrypted_value']) || isset($_POST['hashed_value'])) {
        $key = substr(md5(KEY_2),0,mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CFB));
        $decrypted_value = mcrypt_decrypt(MCRYPT_BLOWFISH, md5(KEY_1), base64_decode($_POST['encrypted_value']), MCRYPT_MODE_CFB, $key);
        $salt_2 = substr($_POST['hashed_value'], 0, 10);
        $new_hashed_value = $salt_2 . substr(sha1($salt_2 . $decrypted_value), -10);
    if($new_hashed_value == $_POST['hashed_value']){
        if (trim($_POST['username']) !="" && trim($_POST['password'])!=""){
            $ezf = new ezFilemanager();
            $ezf->authenticate();
            }
    }
    else{
        //The hidden value has been changed and is therefore invalid
        print TXT_FORM_ERROR;
    }
    }
    }else{
        if (isset($_POST['username']) || isset($_POST['password'])) {
            if (trim($_POST['username']) !="" && trim($_POST['password'])!=""){
            $ezf = new ezFilemanager();
            $ezf->authenticate();
            }
        }
    }
        ?>
<form action="" method="post">
<fieldset>
<p>
<label for="username"><?php echo TXT_USERNAME ?></label>
<input type="text" id="username" name="username" value="" maxlength="20" />
</p>
<p>
<label for="password"><?php echo TXT_PASSWORD ?></label>
<input type="password" id="password" name="password" value="" maxlength="20" />
</p>
<p>
<?php if (ENABLE_FORM_TOKEN){?>
 <input type="hidden" name="encrypted_value" value="<?php echo $encrypted_value; ?>" />
<input type="hidden" name="hashed_value" value="<?php echo $hashed_value; ?>" />

<?php
}
?>
<input type="submit" value="&rarr; <?php echo TXT_LOGIN ?>" />
</p>
</fieldset>
</form>
    </div>
</body>
</html>
<?php
 die();
    }else{
    //unset($_SESSION[AUTHENTICATION_SESSION_NAME]); 
    
    }