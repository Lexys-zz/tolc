<?php

$settings_local = '../app/conf/settings.php';
$settings_local_bak = '../app/conf/settings.bak.php';
$settings_dist = '../app/conf/settings.dist.php';

$res = update_settings($settings_local, $settings_local_bak, $settings_dist);
switch($res) {
	case -1:
		print 'ERROR: Cannot copy ' . $settings_dist . ' to ' . $settings_local;
		break;
	case -2:
		print 'ERROR: Cannot copy ' . $settings_local . ' to ' . $settings_local_bak;
		break;
	case -3:
		print 'ERROR: Cannot write to ' . $settings_local;
		break;
	default:
		highlight_string($res);
}

/**
 * @param $settings_local
 * @param $settings_local_bak
 * @param $settings_dist
 * @return int|string
 */
function update_settings($settings_local, $settings_local_bak, $settings_dist) {

	if(!file_exists($settings_local)) {
		if(copy($settings_dist, $settings_local) === false) {
			return -1;
		}
	} else {
		if(copy($settings_local, $settings_local_bak) === false) {
			return -2;
		}
	}
    $tolc_conf = array();
	include $settings_local;
	$tolc_conf_local = $tolc_conf;
	unset($tolc_conf);

	$tolc_conf = array();
	include $settings_dist;

	$a_keys = array_keys($tolc_conf);
	foreach($a_keys as $key) {
		if(array_key_exists($key, $tolc_conf_local)) {
			$a_tmp[$key] = $tolc_conf_local[$key];
		} else {
			$a_tmp[$key] = $tolc_conf[$key];
		}
	}

	$tz = new DateTimeZone('UTC');
	$date = new DateTime('');
	$date->setTimeZone($tz);
	$dt = $date->format('d/m/Y h:m:s') . ' (UTC time)';
	$str_create = '/* Last automatic creation at ' . $dt . ' */';

	$str_settings = '<?php' . PHP_EOL;
	$str_settings .= $str_create . PHP_EOL;
	foreach($a_keys as $key) {
		$val = $a_tmp[$key];
		$type = gettype($val);
		switch($type) {
			case 'string':
				$val = "'" . $val . "'";
				break;
			case 'boolean':
				$val = $val == 1 ? 'true' : 'false';
				break;
			case 'array';
				$val = var_export($val, true);
				break;
		}
		$str_settings .= '$tolc_conf[' . "'" . $key . "'] = " . $val . ';' . PHP_EOL;
	}
	$str_settings .= '?>';

	if(file_put_contents($settings_local, $str_settings) === false) {
		return -3;
	}

	return $str_settings;
}

?>