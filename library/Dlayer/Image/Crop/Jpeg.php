<?php
/**
* Jpeg cropper
* 
* @see Dlayer_Image_Crop
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_Crop_Jpeg extends Dlayer_Image_Crop 
{
    protected $mime = 'image/jpeg';
    protected $extension = '.jpg';
    
    /**
    * Set the crop options, set here to allow batch processing by repeatedly 
    * calling the loadImage and crop method
    * 
    * @param integer $x_position X position of selection rectangle
    * @param integer $y_position Y position of selection rectangle
    * @param integer $width Width of selection rectangle
    * @param integer $height Height of selected rectangle
    * @param integer $quality Quality for cropped image, value between 1-100
    * @return void|Exception
    */
    public function __construct($x_position, $y_position, $width, $height, 
    $quality) 
    {
        $this->invalid = 0;
        
        if(is_int($quality) == FALSE || $quality < 1 || $quality > 100) {
            $this->invalid++;
            $this->errors[] = 'Quality must be an integer value between 1 
            and 100';
        }
        
        parent::__construct($x_position, $y_position, $width, $height, 
        $quality);
    }
    
    /**
    * Create canvas, copy image onto canvas and then save the image
    * 
    * @return void|Exception
    */
    protected function create() 
    {
        $this->src_image = imagecreatefromjpeg($this->path . $this->file);
        
        $crop_settings = array('x'=>$this->crop_x, 'y'=>$this->crop_y, 
        'width'=>$this->crop_width, 'height'=>$this->crop_height);
        
        $this->cropped_image = imagecrop($this->src_image, $crop_settings);
        
        if($this->cropped_image != FALSE) {
            $result = $this->save();
            
            if($result == FALSE) {
                throw new RuntimeException("Unable to save new image");
            }
        } else {
            throw new RuntimeException("Unable to crop the requested image.");
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
        return imagejpeg($this->cropped_image, $this->path . 
        str_replace($this->extension, $this->suffix . $this->extension, 
        $this->file), $this->quality);
    }
}