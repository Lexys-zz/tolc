<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if (!$isAjax) {
    print 'Access denied - not an AJAX request...';
    exit;
}

// check for logged in user
if(!isset($_SESSION['username'])) {
	print gettext('Access denied') . '...';
	exit;
}

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';

$version = file_get_contents($tolc_conf['project_dir'] . '/VERSION');

?>

<div id="tolc_logo">
	<img src="<?php print $tolc_conf['project_url']  ?>/app/images/tolc_logo.png" alt="Tolc - the simple CMS" title="Tolc - the simple CMS">
</div>

<div id="tolc_moto">
	Tolc - the simple CMS
</div>

<div id="tolc_version">
	<?php print $version ?>
</div>

<div id="tolc_copyright">
	Copyright &copy; Christos Pontikis. License <a href="http://gplv3.fsf.org/" target="_blank">GPL3</a>
	<br />
	<a href="https://github.com/pontikis/tolc" target="_blank">https://github.com/pontikis/tolc</a>

</div>

<div id="tolc_license">
    <p>
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	<p>
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	<p>
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see http://www.gnu.org/licenses/

</div>
