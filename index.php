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


class File {


    /**
     * Scan all files in directory
     *
     * @return array
     */
    public function scanDir($path) {
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


    /**
     * Get file properties; name, size, date modified
     *
     * @return array
     */
    public function properties($path) {
        // Create empty properties
        $properties = [
            "name" => "",
            "size" => "",
            "type" => "",
            "modified" => ""
        ];

        // Check if file exists
        if ($this->exists(($path)) {
            // Get file path info
            $filePathInfo = pathinfo($path);
            // Set file properties
            $properties["name"] = $filePathInfo["filename"];
            $properties["size"] = filesize($path);
            $properties["type"] = mime_content_type($path);
            $properties["modified"] = filemtime($path);
            // Return file properties
            return $properties;
        } else {
            // Return empty template response
            return $properties;
        }
    }


}


class Xml {


    /**  @var string $output final output of xml text */
    public $output = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\">

      <channel>
        <title></title>
        <link></link>
        <description></description>
    ";


    /**
     * Add file to xml $output
     *
     * @return bool
     */
    public function addFile($properties) {
        // Add file $properties to xml output
        $this->output .= "
            <file>
                <name>". $properties["name"] ."</name>
                <size>". $properties["size"] ."</size>
                <type>". $properties["type"] ."</type>
                <modified>". $properties["modified"] ."</modified>
            </file>
        ";

        return true;
    }


    /**
     * Print xml to page and exit
     *
     * @return $output
     */
    public function output() {
        // End xml
        $this->output .= "
          </channel>
          </rss>
        ";
        // Print xml and exit
        die($this->output);
    }

}
