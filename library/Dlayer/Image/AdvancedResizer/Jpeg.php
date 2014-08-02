<?php
/**
* Jpeg image resizer
* 
* @see Dlayer_Image_AdvancedResizer
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_AdvancedResizer_Jpeg extends Dlayer_Image_AdvancedResizer 
{
    protected $mime = 'image/jpeg';
    protected $extension = '.jpg';
    
    /**
    * Set base resizing options, only setting the base resizing option here 
    * to allow some simple batch processing by repeatedly calling the loadImage 
    * and resize method
    * 
    * @param integer $width Canvas width
    * @param integer $height Canvas height
    * @param integer $quality Quality or compression level for new image
    * @param array $canvas_color Canvas background color
    * @param boolean $maintain_aspect Maintain aspect ratio of image
    * @return void|Exception
    */
    public function __construct($width, $height, $quality, 
    array $canvas_color=array('r'=>255, 'g'=>255, 'b'=>255), 
    $maintain_aspect=TRUE) 
    {
        $this->invalid = 0;
        
        if(is_int($quality) == FALSE || $quality < 1 || $quality > 100) {
            $this->invalid++;
            $this->errors[] = 'Quality must be an integer value between 1 
            and 100';
        }
        
        parent::__construct($width, $height, $quality, $canvas_color, 
        $maintain_aspect);
    }
    
    protected function create() 
    {
        $this->canvas = imagecreatetruecolor($this->width, $this->height);
        
        $fill_color = imagecolorallocate($this->canvas, 
        $this->canvas_color['r'], $this->canvas_color['g'], 
        $this->canvas_color['b']);
        imagefill($this->canvas, 0, 0, $fill_color);
        
        $this->copy = imagecreatefromjpeg($this->path . $this->file);
        
        $result = imagecopyresampled($this->canvas, $this->copy, 
        $this->spacing_x, $this->spacing_y, 0 ,0, $this->dest_width, 
        $this->dest_height, $this->src_width, $this->src_height);
        
        if($result == TRUE) {
            $result = imagejpeg($this->canvas, $this->path . 
            str_replace($this->extension, $this->suffix . $this->extension, 
            $this->file), $this->quality);
            
            if($result == FALSE) {
                throw new RuntimeException("Unable to save new image");
            }
        } else {
            throw new RuntimeException("Unable to resample the image.");
        }
    }
}