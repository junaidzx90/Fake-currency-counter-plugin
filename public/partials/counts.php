<?php
/* FindWPConfig - searching for a root of wp */
function FindWPConfig($dirrectory)
{
    global $confroot;

    foreach (glob($dirrectory . "/*") as $f) {

        if (basename($f) == 'wp-config.php') {
            $confroot = str_replace("\\", "/", dirname($f));
            return true;
        }

        if (is_dir($f)) {
            $newdir = dirname(dirname($f));
        }
    }

    if (isset($newdir) && $newdir != $dirrectory) {
        if (FindWPConfig($newdir)) {
            return false;
        }
    }
    return false;
}

if (!isset($table_prefix)) {
    global $confroot;
    FindWPConfig(dirname(dirname(__FILE__)));
    include_once $confroot . "/wp-config.php";
    include_once $confroot . "/wp-load.php";
}

$increments = 1000000;

if(intval(get_option('counter_default_value')) && intval(get_option('counter_default_value')) > 0){
    $increments = intval(get_option('counter_default_value'));
    if(intval(get_option( 'numcounter_count' )) < intval(get_option('counter_default_value'))){
        update_option( 'numcounter_count', $increments );
    }
}else{
    if(intval(get_option( 'numcounter_count' )) < $increments){
        update_option( 'numcounter_count', $increments );
    }
}

$maxincreament = get_option('counter_increment_value') ? intval(get_option('counter_increment_value')): 100;

update_option( 'numcounter_count', intval(get_option( 'numcounter_count' ))+rand(1,$maxincreament) );
echo $return = number_format(get_option( 'numcounter_count' ));