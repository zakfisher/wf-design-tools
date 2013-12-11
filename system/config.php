<?php
session_start();

/** Set Environment */

/** Connect to Database */
//require_once('system/connect.php');

require_once('system/env.php');

/** Libraries **/
require_once('system/libraries/Savant3-3.0.1/Savant3.php');

/** Utilities **/
require_once('system/utilities/browser.php');
require_once('system/utilities/date.php');
require_once('system/utilities/db.php');
require_once('system/utilities/email.php');
require_once('system/utilities/helpers.php');
require_once('system/utilities/import.php');
require_once('system/utilities/json.php');
require_once('system/utilities/text.php');

/** Models **/
//require_once('system/model/music.php');

/** Controllers **/
require_once('system/controller/files.php');
$files = new FilesController($centreMap);

/** Launch **/
$tpl = new Savant3();

// Browser Settings
$browser = new Browser();
$tpl->browser = $browser->get_browser_info();
//JSON::print_array($tpl->browser);
// Check for IE 8 and below
//if ($tpl->browser['short_name'] == 'msie' AND $tpl->browser['version'] <= 8) {
//    echo "Please upgrade your browser.";
//    exit;
//}