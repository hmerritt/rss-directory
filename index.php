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


/**
* Set config settings for RSS feed
*/
$config = [

  // Header info of RSS feed
  "title" => "",
  "link" => "",
  "description" => "",


  // Name of each item
  "item" => "item",


  // Link to file protocol
  "link_prefix" => "https://"

];


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
        global $config;

        // Create empty properties
        $properties = [
            "name" => "",
            "size" => "",
            "type" => "",
            "modified" => ""
        ];

        // Check if file exists
        if ($this->exists($path)) {
            // Get file path info
            $filePathInfo = pathinfo($path);
            // Set file properties
            $properties["name"] = $filePathInfo["filename"];
            $properties["size"] = filesize($path);
            $properties["type"] = mime_content_type($path);
            $properties["modified"] = filemtime($path);
            $properties["url"] = dirname("{$config['link_prefix']}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}") ."/". $path;
            // Return file properties
            return $properties;
        } else {
            // Return empty template response
            return $properties;
        }
    }


}


class Xml {


    function __construct($items=[]) {
        /**  @var array All items */
        $this->items = $items;
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
        global $config;

        // Create xml
        $output = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\">
<channel>
    <title>". $config["title"] ."</title>
    <link>". $config["link"] ."</link>
    <description>". $config["description"] ."</description>
        ";

        // Add items
        // Loop items array
        foreach($this->items as $item) {
            // Create item xml
            $item_xml = "";
            // Loop each property in the item
            foreach($item as $property) {
                //
                $item_xml .= "<".$property[0].">" . $property[1] . "</".$property[0].">";
            }
            // Wrap item with <file> tag in $output
            $output .= "
    <".$config["item"].">" . $item_xml . "</".$config["item"].">
            ";
        }

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
    public function output() {
        // Return xml text and exit
        die($this->getText());
    }


}




// Get url params
$path = $_GET["path"];


// Init file obj and xml objects
$File = new File();

// Scan files
$filesArr = $File->scanDir($path);
$filePropertiesArr = [];

// Get file properties for all scanned files
foreach($filesArr as $file) {
    // Set file path
    $filePath = $path ."/". $file;
    // Get file properties
    $properties = $File->properties($filePath);
    $thisFile = [
        ["title", $properties["name"]],
        ["url", $properties["url"]],
    ];
    array_push($filePropertiesArr, $thisFile);
}


// Init xml obj
$xml = new Xml($filePropertiesArr);

// Print xml
$xml->output();
