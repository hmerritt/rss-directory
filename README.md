# RSS Live Directory
An auto-updating RSS feed that is mapped to the files in a directory.


## Install

### Prerequisites
- PHP 7

### Instructions
1. Move `rss.php` into any web-directory
2. Customize config within the `rss.php` file
3. Open using `rss.php?dir=DIRECTORY-PATH-TO-LIST`


## Usage
```
wallpapers/
    cat.jpg
	dog.png
	sloth.jpg
rss.php
```

Scan all files within the `wallpapers` directory and generate an RSS feed
```
rss.php?dir=wallpapers
```
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" >
<channel>
    <title></title>
    <link></link>
    <description></description>
        
    <item>
        <name> sloth </name>
        <size> 94555 </size>
        <type> image/jpeg </type>
        <modified> 1565822937 </modified>
        <link> https://example.com/wallpapers/sloth.jpg </link>
    </item>
            
    <item>
        <name> cat </name>
        <size> 49475095 </size>
        <type> image/jpeg </type>
        <modified> 1561387867 </modified>
        <link> https://example.com/wallpapers/cat.jpg </link>
    </item>
            
    <item>
        <name> dog </name>
        <size> 86993 </size>
        <type> image/png </type>
        <modified> 1551307898 </modified>
        <link> https://example.com/wallpapers/dog.png </link>
    </item>
            
</channel>
</rss>
```


## Possible Uses

### 1. Synced Wallpapers
A personal collection of wallpapers that is synced across all computers.
- Used alongside [JBS](https://johnsad.ventures/software/backgroundswitcher/)