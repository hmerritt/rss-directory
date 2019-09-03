<?php
/**
* RSS from directory
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
* @package rss-directory
* @author Harry Merritt
*/


class Directory {


    /**
     * Scan all files in directory
     *
     * @return array
     */
    public function scan($path) {
        // Scan directory
        // remove unwanted values '.', '..'
        $scannedFiles = array_slice(scandir($path), 2);
        return $scannedFiles;
    }


    /**
     * Check if file/directory exists
     *
     * @return bool
     */
    public function exists($path) {
        // Check if a either a file/directory exists
        if (file_exists($path)) {
            return true;
        }

        return false;
    }


}
