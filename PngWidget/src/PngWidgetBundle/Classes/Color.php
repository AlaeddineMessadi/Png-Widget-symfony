<?php

namespace PngWidgetBundle\Classes;

class Color
{
    private $red;
    private $green;
    private $blue;
    
    function __construct($hexa){
        $colors = $this->convertFromHexa($hexa);
        $this->red = $colors['red'];
        $this->green = $colors['green'];
        $this->blue = $colors['blue'];
    }
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
    
    /*
     * 
     * Check the Hexa Color value and reformat 
     * @param string
     * @return array
     */
    private function convertFromHexa($hexa){
        $length = strlen($hexa);
        if($length == 3){
            $array['red'] = substr($hexa,0,1).substr($hexa,0,1);
            $array['green'] = substr($hexa,1,1).substr($hexa,1,1);
            $array['blue'] = substr($hexa,2,1).substr($hexa,2,1);
        }else{
            $array['red'] = substr($hexa,0,2);
            $array['green'] = substr($hexa,2,2);
            $array['blue'] = substr($hexa,4,2);
        }
        return $array;
    }
}

