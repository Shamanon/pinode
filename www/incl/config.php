<?php
// error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

// class autoloader
spl_autoload_register(function ($class_name) {
    include 'incl/'.$class_name . '.php';
});

// create shared pipe if needed
if (!file_exists("/tmp/player.fifo")) 
	exec('mkfifo /tmp/player.fifo');
	
// IP/URL of media servers
$logfile = "/dev/shm/player.log";
exec('touch $logfile');
$info = shell("tail -n 3 $logfile");
$statfile = "/dev/shm/player.stat";
$action = isset($_POST['action'])?$_POST['action']:null;
$others = array(NULL);
$icecast_server = "192.168.0.105:3000";
$kvmr_url = 'http://live2.kvmr.org:8190/kvmr.m3u';

// name the inputs here
$sw[8] = array(' Desk','4',`cat /sys/class/gpio/gpio4/value`);
$sw[7] = array(' Door','25',`cat /sys/class/gpio/gpio4/value`);
$sw[6] = array('Gar 3','24',`cat /sys/class/gpio/gpio4/value`);
$sw[5] = array('Gar 2','23',`cat /sys/class/gpio/gpio4/value`);
$sw[4] = array('Gar 1','22',`cat /sys/class/gpio/gpio4/value`);
$sw[3] = array(' Yard','27',`cat /sys/class/gpio/gpio4/value`);
$sw[2] = array(' Park','18',`cat /sys/class/gpio/gpio4/value`);
$sw[1] = array('Radio','17',`cat /sys/class/gpio/gpio4/value`);
