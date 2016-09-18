<? 
include 'incl/config.php';

if(isset($_POST['relay'])) foreach($_POST['relay'] as $id => $val){
        $switch = $sw[$id][1];
        exec("echo $val > /sys/class/gpio/gpio".$switch."/value");
        $sw[$id][2] = shell("cat /sys/class/gpio/gpio".$switch."/state");
}

if(isset($_POST['interior_lights'])) for($i=4;$i<9;$i++){
	$id = $sw[$i][1];
	$val = $_POST['interior_lights'];
	exec("echo $val > /sys/class/gpio/gpio".$id."/value");
    $sw[$id][2] = shell("cat /sys/class/gpio/gpio".$id."/state");
}

?>
<html5>
<pre>
<?


echo `ls -l /tmp/player.fifo`;
echo `hostname`;
echo `uname -a`;

switch($action){
	case "repair":
		`killall mplayer`; 
		`killall pianobar`;
		`rm /tmp/player.fifo`;
		exec('mkfifo /tmp/player.fifo');
		$status = "ready";
		break;

	case "stop" :  
		`killall mplayer`;
		`killall pianobar`;
		`rm /tmp/pianobar`;
		echo "stopping...<br>";
		$status = "Stopped"; 
		break;
	case "kvmr" :
		`killall mplayer`;
		`killall pianobar`;
		exec('mplayer -ao alsa -slave -input file=/tmp/player.fifo -playlist '.$kvmr_url.' </dev/null >/dev/null 2>&1 &');
		$status = "Playing KVMR";
		break;
	case "icecast" : 
		`killall mplayer`;
		`killall pianobar`;
		exec('mplayer -ao alsa -slave -input file=/tmp/player.fifo -playlist http://'.$icecast_server.'/stream.m3u </dev/null >/dev/null 2>&1 &');
		$status = "Playing Local Stream";
		break;
	case "pandora" : 
		$Pando = new Pando();
		$Pando->play();
		$status = "Playing Pandora<br>".$pando->stat();
		break;
}

file_put_contents($statfile,$status);

echo 'Playing: '.$status.'<br>';

?>
</pre>
<div style="width: 100%;">
<div style="float: left; width: 50%;">
<form method="POST">
	<input type="button" value="Stop Playback" onclick="form.submit()" />
	<input type="button" value="Reset Mplayer" onclick="action.value='repair';form.submit()" />
	<input type="button" value="Play KVMR" <? if($status=="Playing KVMR"){ ?> disabled="disabled" <? } ?> onclick="action.value='kvmr';form.submit()" />
	<input type="button" value="Play Pandora" <? if($status=="Playing Pandora"){ ?> disabled="disabled" <? } ?> onclick="action.value='pandora';form.submit()" />
	<input type="button" value="Play Local Stream" <? if($status=="Playing Local Stream"){ ?> disabled="disabled" <? } ?> onclick="action.value='icecast';form.submit()" />
	<input type="hidden"  name="action" id="action" value="stop" />
</form>
<div>
	<? foreach($others as $ip){ ?>
	<iframe src="http://<?=$ip?>/mini.php"></iframe>
	<? } ?>
</div>
<? if($status=='Playing Pandora') echo "<pre>".`cat /var/www/.config/pianobar/state`."</pre>" ?>
</div>
<div style="width: 200px; margin-left:50%;">
<? for($i=1;$i<9;$i++){ ?>
        <form action="index.php" method="POST">
                <?=$sw[$i][0]?> Off: <input type="radio" name="relay[<?=$i?>]" value="1"<? if($sw[$i][2] == 1) echo ' checked="true"'?> onchange="this.form.submit()"> 
                On: <input type="radio" name="relay[<?=$i?>]" value="0"<? if($sw[$i][2] == 0) echo ' checked="true"'?> onchange="this.form.submit()">
        </form>
<? } ?>
<form action="index.php" method="POST">
	<input type="hidden" name="interior_lights" value="1" />
	<input type="button" value="Garage Lights On" onclick="interior_lights.value='0';this.form.submit()" /><br /><br />
	<input type="button" value="Garage Lights Off" onclick="this.form.submit()" /><br /><br />
	<input type="button" value="Refresh Page" onclick="location.reload()" />
</form>
</div>
</div>
<div style="clear:left">
<pre>
<? echo `gpio readall` ?>
</pre>
</div>
</html5>
