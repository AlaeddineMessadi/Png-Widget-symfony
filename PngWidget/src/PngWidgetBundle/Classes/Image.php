<?php

namespace PngBundle\Classes;

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
    

}