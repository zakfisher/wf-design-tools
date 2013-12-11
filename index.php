<?php
require_once('system/config.php');

$tpl->page = 'Design Tools';

$tpl->task = 'index';

if (isset($_GET['task'])) {
    $tpl->task = $_GET['task'];
    switch ($_GET['task']) {

        case 'batch-rename-storefronts':
            $centre = $_GET['centre'];
            $sourceFolder = $files->getStorefrontDir($centre);
            $rename = ($_GET['rename'] === 'true');
            $tpl->centre = $centre;
            $tpl->storefronts = $files->getStorefrontImagesFromCentre(SERVER . $sourceFolder, $centre, $rename);
            $tpl->files = $files->getFilesFromDir(SERVER . $sourceFolder);
            if (empty($sourceFolder)) $tpl->files = array();
            $tpl->centres = $files->listAllCentres();
            break;

        case 'manually-rename-storefronts':
            if (isset($_POST['submit'])) {
                $oldName = SERVER . $_POST['folder'] . '/' . $_POST['old_filename'];
                $newName = SERVER . $_POST['folder'] . '/' . $_POST['new_filename'];
                rename($oldName, $newName);
            }
            $centre = $_GET['centre'];
            $sourceFolder = $files->getStorefrontDir($centre);
            $tpl->centre = $centre;
            $tpl->folder = $sourceFolder;
            $tpl->files = $files->getFilesToRename(SERVER . $sourceFolder, $centre);
            $offset = 0;
            if (isset($_GET['offset'])) $offset = $_GET['offset'];
            if ($offset > count($tpl->files) - 1) $offset = 0;
            $tpl->offset = $offset + 1;
            $tpl->file = $tpl->files[$offset];
            $tpl->centres = $files->listAvailableCentres();
            $storefronts = $files->getStorefrontImagesFromCentre(SERVER . $sourceFolder, $centre, $rename);
            $tpl->storefronts = $files->listAvailableRetailers($storefronts, $sourceFolder);
            break;
    }
}

//JSON::print_array($tpl->storefronts); exit;

$tpl->display('templates/header.tpl.php');
$tpl->display('templates/navigation.tpl.php');
//$tpl->display('templates/modal.tpl.php');
$tpl->display('templates/' . $tpl->task . '.tpl.php');
$tpl->display('templates/footer.tpl.php');
