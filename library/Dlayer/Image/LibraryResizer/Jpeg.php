<?php
/**
* Jpeg image resizer
* 
* @see Dlayer_Image_LibraryResizer
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_LibraryResizer_Jpeg extends Dlayer_Image_LibraryResizer 
{
    protected $mime = 'image/jpeg';
    protected $extension = '.jpg';
    
    /**
    * Set base resizing options, only setting the base resizing option here 
    * to allow some simple batch processing by repeatedly calling the loadImage 
    * and resize method
    * 
    * @param integer $quality Quality or compression level for new image
    * @param integer $width Canvas width
    * @param integer $height Canvas height
    * @param array $canvas_color Canvas background color
    * @param boolean $maintain_aspect Maintain aspect ratio of image, if set 
    *                                 to TRUE padding is added around best fit 
    *                                 resampled image otherwise image is 
    *                                 stretched to fit
    * @return void|Exception
    */
    public function __construct($quality,
    $width=Dlayer_Config::IMAGE_LIBRARY_THUMB_WIDTH, 
    $height=Dlayer_Config::IMAGE_LIBRARY_THUMB_HEIGHT, 
    array $canvas_color=array('r'=>Dlayer_Config::IMAGE_LIBRARY_CANVAS_R, 
    'g'=>Dlayer_Config::IMAGE_LIBRARY_CANVAS_G, 
    'b'=>Dlayer_Config::IMAGE_LIBRARY_CANVAS_B), 
    $maintain_aspect=TRUE)
    {
        $this->invalid = 0;
        
        if(is_int($quality) == FALSE || $quality < 1 || $quality > 100) {
            $this->invalid++;
            $this->errors[] = 'Quality must be an integer value between 1 
            and 100';
        }
        
        parent::__construct($quality, $width, $height, $canvas_color, 
        $maintain_aspect);
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
        
        $this->copy = imagecreatefromjpeg($this->path . $this->file);     
        
        $result = imagecopyresampled($this->canvas, $this->copy, 
        $this->spacing_x, $this->spacing_y, 0 ,0, $this->dest_width, 
        $this->dest_height, $this->src_width, $this->src_height);
        
        if($result == TRUE) {
            $result = $this->save();
            
            if($result == FALSE) {
                throw new RuntimeException("Unable to save new image");
            }
        } else {
            throw new RuntimeException("Unable to resample the image.");
        }
    }
    
    /**
    * Attempt to save the new image, Overriding  this method to change 
    * destination 
    * 
    * @return boolean
    */
    protected function save() 
    {
        return imagejpeg($this->canvas, $this->dest_path . $this->dest_file . 
        $this->extension, $this->quality);
    }
}