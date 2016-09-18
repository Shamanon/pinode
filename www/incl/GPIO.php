<?php
class GPIO
{
	public $invert = FALSE;
	public $gpio = array(4,17,18,22,23,24,25,27);
	
	public function init()
	{
		foreach($gpio as $i){
			exec("echo $i > /sys/class/gpio/export")
			exec("echo out > /sys/class/gpio/gpio".$i."/direction");
			exec("echo 0 > /sys/class/gpio/gpio".$i."/value");
		}
	}
	
    public function invert()
    {
		$this->invert = (!$this->invert) ? TRUE : FALSE; 
		return "Logic ".(!$this->invert ? "NOT ")."Inverted";
    }
    
    public function on($gpio)
    {
		exec("echo 1 >/sys/class/gpio/gpio".$gpio."/value");
	}
	
    public function on($gpio)
    {
		exec("echo 1 >/sys/class/gpio/gpio".$gpio."/value");
	}
}
?>
