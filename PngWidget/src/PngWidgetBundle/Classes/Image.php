<?php

namespace PngWidgetBundle\Classes;

class Image
{
	private $width;
	private $height;
	private $backgroundColor;
	private $textColor;
	private $text;

    
    function __construct($width,$height,$backgroundColor,$textColor) {
        $this->width = $width;
        $this->height = $height;
        $this->backgroundColor = $backgroundColor;
        $this->textColor = $textColor;
        $this->text = rand(0, 100);
    }
	/**
     * Get width
     *
     * @return integer 
     */
    public function getWidth(){
		return $this->width;
	}

	/**
     * Set width
     * @param integer $width
     * @return Image 
     */
	public function setWidth($width){
		$this->width = $width;
		return $this;
	}

	/**
     * Get Height
     *
     * @return integer 
     */
	public function getHeight(){
		return $this->height;
	}

	/**
     * Set height
     * @param integer $height
     * @return Image 
     */
	public function setHeight($height){
		$this->height = $height;
		return $this;
	}

	/**
     * Get BackgroundColor
     *
     * @return string 
     */
	public function getBackgroundColor(){
		return $this->backgroundColor;
	}

	public function setBackgroundColor($backgroundColor){
		$this->backgroundColor = $backgroundColor;
		return $this;
	}

	/**
     * Get TextColor
     *
     * @return string 
     */
	public function getTextColor(){
		return $this->textColor;
	}

	/**
     * Set TextColor
     *
     * @return Image 
     */
	public function setTextColor($textColor){
		$this->textColor = $textColor;
		return $this;
	}

	/**
     * Get Text
     *
     * @return string 
     */
	public function getText(){
		return $this->text;
	}

	/**
     * Set Text
     *
     * @return Image 
     */
	public function setText($text){
		$this->text = $text;
		return $this;
	}
    
    // Check $width,$height,$background,$textColor
    public function checkParams() {
        if($this->width <100 && $this->width>500)
            return "The Width must be between 100 and 500";
        if($this->height <100 && $this->height>500)
            return "The Height must be between 100 and 500";
        if(!preg_match('/([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $this->backgroundColor))
            return "Please check your backgroundcolor Hexa Code";
        if(!preg_match('/([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $this->textColor))
            return "Please check your TextColor Hexa Code";
        return true;
    }
}