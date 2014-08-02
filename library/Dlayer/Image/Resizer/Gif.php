<?php
/**
* Gif image resizer
* 
* @see Dlayer_Image_Resizer
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_Resizer_Gif extends Dlayer_Image_Resizer 
{
    protected $mime = 'image/gif';
    protected $extension = '.gif';
    
    /**
    * Constructor, set base resizing options, only set base options to allow 
    * batch processing by just loading an image and then resizing with set 
    * params
    * 
    * @param integer $width Canvas width
    * @param integer $height Canvas height
    * @return void|Exception
    */
    public function __construct($width, $height) 
    {
        parent::__construct($width, $height);
    }
    
    /**
    * Create canvas, copy image onto canvas and then save the image
    * 
    * @return void|Exception
    */
    protected function create() 
    {
        $this->canvas = imagecreatetruecolor($this->width, $this->height);
        
        $fill_color = imagecolorallocate($this->canvas, 
        $this->canvas_color['r'], $this->canvas_color['g'], 
        $this->canvas_color['b']);
        imagefill($this->canvas, 0, 0, $fill_color);
        
        $this->copy = imagecreatefromgif($this->path . $this->file);
        
        $result = imagecopyresampled($this->canvas, $this->copy, 
        $this->spacing_x, $this->spacing_y, 0 ,0, $this->dest_width, 
        $this->dest_height, $this->src_width, $this->src_height);
        
        if($result == TRUE) {
            $result = imagegif($this->canvas, $this->path . 
            str_replace($this->extension, $this->suffix . $this->extension, 
            $this->file));
            
            if($result == FALSE) {
                throw new RuntimeException("Unable to save new image");
            }
        } else {
            throw new RuntimeException("Unable to resample the image.");
        }
    }
}