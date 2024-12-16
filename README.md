This is a small Minecraft tool written in PHP to fix missing end or nether dimension compound tags in the level.dat file. If the tags are missing, the portals do not work.

# Usage CLI

```bash
php repair.php input_file [output_file]
```

If no output file path is given, the output directory is the current directory.

# Usage PHP code

```php
$fileName = 'level.dat'
$fileContent = file_get_contents($filename)
$creabit = new Creabit($fileContent)
file_put_contents($fileName, $creabit->repair());
```