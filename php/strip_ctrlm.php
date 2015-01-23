<?php

/*
 * Stack Overflow Source: http://stackoverflow.com/questions/11852476/php-removing-windows-m-character
 */

if ( !isset($argv[1]) ) die( "Missing File to Convert.\n" );
$filename = substr($argv[1] , 0, 3) == "../" ? __DIR__ . "/" . $argv[1] : $argv[1];
echo "$filename\n";
$contents = file_get_contents($filename);
$contents = str_ireplace("\x0D", "\n", $contents);
echo $contents;
file_put_contents($filename, $contents);
$filename = __DIR__ . "/" . $argv[1];
echo "$filename\n";
$contents = file_get_contents($filename);
$contents = str_replace('Ê','', mb_convert_encoding($contents, "UTF-8"));
echo $contents;
file_put_contents($filename, $contents);