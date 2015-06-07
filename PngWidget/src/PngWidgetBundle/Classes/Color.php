<?php

namespace PngWidgetBundle\Classes;

class Color
{
    private $red;
    private $green;
    private $blue;
    
    public function getRed(){
		return $this->red;
	}

	public function setRed($red){
		$this->red = $red;
	}

	public function getGreen(){
		return $this->green;
	}

	public function setGreen($green){
		$this->green = $green;
	}

	public function getBlue(){
		return $this->blue;
	}

	public function setBlue($blue){
		$this->blue = $blue;
	}
    
}

