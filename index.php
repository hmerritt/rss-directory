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


    __construct($title="", $link="", $description="") {
        /**  @var string Set xml properties */
        $this->title       = $title;
        $this->link        = $link;
        $this->description = $description;
        /**  @var array All items */
        $this->items = [];
    }


    /**
     * Add item to xml $output
     *
     * @return null
     */
    public function addItem($properties) {
        // Create new file
        $newFile = [
            ["name", $properties["name"]],
            ["size", $properties["size"]],
            ["type", $properties["type"]],
            ["modified", $properties["modified"]]
        ];

        // Add file $properties to xml output
        array_push($this->files, $newFile);
    }


    /**
     * Get the xml text of current obj
     *
     * @return string
     */
    public function getText() {
        // Create xml
        $output .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
          <rss version=\"2.0\">
          <channel>
              <title>$this->title</title>
              <link>$this->link</link>
              <description>$this->description</description>
        ";

        // Add items
        // Loop items array
        foreach($this->items as $item) {
            // Create item xml
            $item_xml = "";
            // Loop each property in the item
            foreach($item as $property) {
                //
                $item_xml = .= "<".$property[0].">" . $property[1] . "</".$property[0].">";
            }
            // Wrap item with <file> tag in $output
            $output .= "<file>" . $item_xml . "</file>";
        }

        // Wrap items in a <file> tag
        $output .= "<file>" . $item_xml . "</file>";

        // End xml
        $output .= "
          </channel>
          </rss>
        ";

        return $output;
    }


    /**
     * Output xml and exit
     *
     * @return null
     */
    public function addItem($properties) {
        // Return xml text and exit
        die($this->getText());
    }

}
