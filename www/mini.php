<? 
error_reporting(-1);
ini_set('display_errors', 'On');

$statfile = "now_playing";
$status = file_get_contents($statfile);
$action = isset($_POST['action'])?$_POST['action']:null;

?>
<html5>
<?
if (!file_exists("/tmp/mplayer.fifo")){ 
	?>making fifo<?
	exec('mkfifo /tmp/mplayer.fifo');
	$status = "Idle";
}

echo `hostname`;

switch($action){
        case "repair":
                echo `killall mplayer`; 
                echo `rm /tmp/mplayer.fifo`;
                exec('mkfifo /tmp/mplayer.fifo');
                $status = "Ready";
                break;

        case "stop" :  
                `killall mplayer`;
                $status = "Stopped"; 
                break;
        case "kvmr" :
                `killall mplayer`;
                exec('mplayer -ao alsa -idle -slave -input file=/tmp/mplayer.fifo -playlist http://live2.artoflogic.com:8190/kvmr.m3u </dev/null >/dev/null 2>&1 &');
                $status = "Playing KVMR";
                break;
        case "icecast" : 
                `killall mplayer`;
                exec('mplayer -ao alsa -idle -slave -input file=/tmp/mplayer.fifo -playlist http://192.168.0.101:8000/tunes.m3u </dev/null >/dev/null 2>&1 &');
                $status = "Playing Local Stream";
                break;
}

file_put_contents($statfile,$status);

echo 'Playing: '.$status.'<br>';

?>
<form method="POST">
	<input type="button" value="Stop Playback" onclick="form.submit()" />
	<input type="button" value="Reset Mplayer" onclick="action.value='repair';form.submit()" />
	<input type="button" value="Play KVMR" <? if($status=="Playing KVMR"){ ?> disabled="disabled" <? } ?> onclick="action.value='kvmr';form.submit()" />
	<input type="button" value="Play Local Stream" <? if($status=="Playing Local Stream"){ ?> disabled="disabled" <? } ?> onclick="action.value='icecast';form.submit()" />
	<input type="hidden"  name="action" id="action" value="stop" />
</form>
</html5>
