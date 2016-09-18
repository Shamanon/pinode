<?php
class Pando
{
	public $status;
	
	public function play()
	{
		`killall mplayer`;
		`killall pianobar`;
		`killall screen`;
		exec("screen -L -S pando -d -m pando");
		$this->status = shell("tail -n 2 /dev/shm/player.log");
		return $this->satus;
	}
	
	public function next()
	{
		exec('echo -n "n" > /tmp/player.fifo');
		$this->status = shell("tail -n 2 /dev/shm/player.log");
		return $this->satus;
	}
	
	public function stat()
	{
		$this->status = shell("tail -n 2 /dev/shm/player.log");
		return $this->satus;
	}
	
	public function like()
	{
		exec('echo -n "+" > /tmp/player.fifo');
		$this->status = shell("tail -n 2 /dev/shm/player.log");
		return $this->satus;
	}
	
	public function dislike()
	{
		exec('echo -n "-" > /tmp/player.fifo');
		$this->status = shell("tail -n 2 /dev/shm/player.log");
		return $this->satus;
	}
	
	public function quit()
	{
		exec('echo -n "q" > /tmp/player.fifo');
		$this->status = "Stopped";
		exec("echo > /dev/shm/player.log");
		return $this->status;
	}
}
?>

