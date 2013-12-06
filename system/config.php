<?php
session_start();

/** Set Environment */
//$uri = explode(".", $_SERVER['HTTP_HOST']);
//define(ENV, ($uri[0] == 'dev') ? 'development' : 'production');
define(SERVER, '/Users/zakfisher');
define(ROOT, '/Documents/Projects/Westfield/');
define(STOREFRONTS, '/Box Sync/Redesign Website & Unify Mobile App/Images and Content/Website/3-Shop/3.1.1 Shop Details/Images/Production/');

$centreMap = array(
    'centurycity' => 'Century City',
    'sanfrancisco' => 'SFC'
);

/** Connect to Database */
//require_once('system/connect.php');

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