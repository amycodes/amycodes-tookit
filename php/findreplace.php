<?php

/*
 * This tool does a find and replace either on a single file or a folder with subfolders of files. 
 * Useful when making quick changes like drive or URL changes.
 * 
 * @author Amy Negrette
 */

if ( count($argv) < 2 ) die ("No Search Specified.");
if ( count($argv) < 3 ) die ("No Replace Specified.");
if ( count($argv) < 4 ) die ("No Path Specified.");

$find = $argv[1];
$replace = $argv[2];
$path = in_array($argv[3][0] , array("/", "\\")) ? $argv[3] : __DIR__ . '\\' . $argv[3];

function find_replace_in_file($x, $y, $source, $destination) {
    // echo "find_replace_in_file($x, $y, $source, $destination)\n";
    if ( is_file($source) ) {
        $out = fopen( $destination , "w");
        echo "Writing to $destination\n";
        $in = fopen ( $source , "r" );
        
        while ( $line = fgets($in) ) {
            fwrite($out, str_replace($x, $y, $line));
        }
        fclose($out);
        fclose($in);
    }
}

function find_in_folder($x, $y, $runtime, $path) {
    // echo "find_in_folder($x, $y, $path)\n";
    foreach ( scandir($path) as $file ) {
        if ( $file[0] == '.' ) continue;
        if ( is_dir($file) ) {
            find_in_folder($x, $y, $runtime, $path . "/" . $file);
        } else {
            $target = $path . "-" . $runtime;
            if ( !is_dir( $target ) ) mkdir( $target );
            if ( !is_writeable($target) ) die ( "Cannot write to target\n");
            find_replace_in_file($x, $y, $path . "/" . $file, $target . "/" . $file);
        }
    }
}

if ( is_file( $path ) ) {
    if ( ($pos = strrpos($path, ".", -1) ) > -1 ) {
        $destination = substr($path, 0, $pos) . "-ts" . time() . substr($path, $pos);
    } else {
        $destination = $path . "-ts" . time();
    }
    find_replace_in_file($find, $replace, $path, $destination);
} else {
    find_in_folder($find, $replace, time(), $path);
}
?>
