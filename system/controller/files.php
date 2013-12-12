<?php
class FilesController {

    private $centreMap;

    function __construct($map) {
        $this->centreMap = $map;
    }

    // Return array of files from specified directory
    public function getFilesFromDir($dir) {
        $files = array();
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (!in_array($file, array('.','..'))) $files[] = $file;
                }
                closedir($dh);
            }
        }
        return $files;
    }

    // Get storefront data from txt file (should be replaced with API call or direct DB access)
    public function extractStorefrontsFromTxt($centre = '') {
        $file = file_get_contents(SERVER . ROOT . 'storefronts.txt');
        $file = explode("\n", $file);
        unset($file[0]);
        unset($file[1]);
        unset($file[20256]);
        unset($file[20257]);
        unset($file[20258]);
        $storefronts = array();
        foreach ($file as $row) {
            $s = explode("|", $row);
            $storefronts[trim($s[1])][] = array(
                'retail_chain_id' => trim($s[0]),
                'retailer_id'     => trim($s[2]),
                'name'            => trim($s[3]),
                'filename'        => (trim($s[0]) . '_' . trim($s[1]) . '_' . trim($s[2]) . '_storefront'),
                'sourcefile' => '',
                'matches' => 0
            );
        }
        if (empty($centre)) return $storefronts;
        return $storefronts[$centre];
    }

    // Get list of storefront images (based on centre) for batch rename
    public function getStorefrontImagesFromCentre($sourceFolder, $centre, $rename = false) {
        $files = $this->getFilesFromDir($sourceFolder);
        $storefronts = $this->extractStorefrontsFromTxt($centre);

        foreach ($storefronts as $i => $s) {
            $prefix = strtolower(str_replace(' ', '', $storefronts[$i]['name']));
            $storefronts[$i]['prefix'] = $prefix;
            $storefronts[$i]['renamed'] = 'no';
        }

        // Check for prefix matches and files already renamed
        foreach ($files as $file) {
            $file = explode(FILENAME_CHAR, $file);
            $name = $file[0];
            foreach ($storefronts as $i => $s) {

                // Check for row match against file
                if ($name === $storefronts[$i]['prefix']) {
                    $storefronts[$i]['sourcefile'] = implode('_', $file);
                    $storefronts[$i]['matches']++;
                }

                // Check if already renamed
                $alreadyRenamed = file_exists($sourceFolder . '/' . $s['filename'] . '.jpg');
                if ($alreadyRenamed) {
                    $storefronts[$i]['renamed'] = 'yes';
                }
            }
        }

        array_sort_by_column($storefronts, 'name');

        if ($rename) {
            foreach ($storefronts as $i => $s) {
                if ($s['matches'] === 1 && $s['renamed'] === 'no') {
                    $sourceName = $sourceFolder . '/' . $s['sourcefile'];
                    $finalName = $sourceFolder . '/' . $s['filename'] . '.jpg';
                    rename($sourceName, $finalName);
                    $storefronts[$i]['renamed'] = 'yes';
                    $storefronts[$i]['sourcefile'] = $s['filename'];
                }
            }
        }

        return $storefronts;
    }

    // Return array of all centres
    public function listAllCentres() {
        $storefronts = $this->extractStorefrontsFromTxt();
        $centres = array();
        foreach ($storefronts as $c => $list) $centres[] = $c;
        sort($centres);
        return $centres;
    }

    // Return array of available centres (based on existing directory - see $centreMap above)
    public function listAvailableCentres() {
        $list = $this->listAllCentres();
        foreach ($list as $i => $centre) {
            if (!isset($this->centreMap[$centre])) unset($list[$i]);
        }
        return $list;
    }

    // Return directory for specified centre
    public function getStorefrontDir($centre) {
        $dir = STOREFRONTS . $this->centreMap[$centre];
        if ($dir === STOREFRONTS) return false;
        return $dir;
    }

    // Return array of available retailers (for manual rename, this array contains retailers without an image)
    public function listAvailableRetailers($storefronts, $sourceFolder) {
        $files = $this->getFilesFromDir(SERVER . $sourceFolder);
        foreach ($storefronts as $i => $s) {
            foreach ($files as $f) {
                if ($f === $s['filename'] . '.jpg') {
                    unset($storefronts[$i]);
                    continue;
                }
            }
        }
        return $storefronts;
    }

    // Return array of available images based on centre (for manual rename, this array contains images that haven't been renamed)
    public function getFilesToRename($sourceFolder, $centre) {
        $storefronts = $this->getStorefrontImagesFromCentre($sourceFolder, $centre);
        $files = $this->getFilesFromDir($sourceFolder);
        foreach ($files as $i => $f) {
            foreach ($storefronts as $s) {
                if ($f === $s['filename'] . '.jpg') {
                    unset($files[$i]);
                    continue;
                }
            }
        }
        $files = array_values($files);
        return $files;
    }

}