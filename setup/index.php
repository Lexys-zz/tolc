<?php
echo 'setup...';
exit;
$htaccess = $tolc_conf['project_dir'] . '.htaccess';
$htaccess_dist = $tolc_conf['project_dir'] . '.htaccess_dist';

$favicon = $tolc_conf['project_dir'] . 'favicon.ico';
$favicon_dist = $tolc_conf['project_dir'] . 'favicon_dist.ico';

$cfgs = array();
$cfgs[] = array($htaccess, $htaccess_dist);
$cfgs[] = array($favicon, $favicon_dist);
$cfgs[] = array($settings_php, $settings_php_dist);

foreach ($cfgs as $cfg) {
    $dest = $cfg[0];
    $src = $cfg[1];
    if (!file_exists($dest)) {
        if (file_exists($src)) {
            copy($src, $dest);
        } else {
            touch($dest);
        }
    }
}

?>