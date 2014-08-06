<?php
/**
* Crops the source image based on the selection area and position, all params 
* will be validated including ensuring that the crop selection fits within the 
* source image
* 
* @see Dlayer_Image_Crop
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_Crop_Gif extends Dlayer_Image_Crop 
{
    protected $mime = 'image/gif';
    protected $extension = '.gif';
    
    /**
    * Set the crop options, set here to allow batch processing by repeatedly 
    * calling the loadImage and crop methods
    * 
    * @param integer $x_position X position of crop selection rectangle
    * @param integer $y_position Y position of crop selection rectangle
    * @param integer $width Width of crop selection rectangle
    * @param integer $height Height of crop selected rectangle
    * @param integer $quality Quality or compression level for new image, must 
    *                         be 0 for gifs as not used
    * @return void|Exception
    */
    public function __construct($x_position, $y_position, $width, $height, 
    $quality) 
    {
        $this->invalid = 0;
        
        if(is_int($quality) == FALSE || $quality != 0) {
            $this->invalid++;
            $this->errors[] = 'Quality must be set to 0, not used for gif 
            images, only here because sibling classes use value';
        }
        
        parent::__construct($x_position, $y_position, $width, $height, 
        $quality);
    }
    
    /**
    * Crop the image base the supplied params
    * 
    * @return void|Exception
    */
    protected function create() 
    {
        $this->src_image = imagecreatefromgif($this->path . $this->file);
        
        $this->cropImage();
    }
    
    /**
    * Attempt to save the new image, Overriding  this method to change 
    * destination 
    * 
    * @return boolean
    */
    protected function save() 
    {
        return imagegif($this->cropped_image, $this->path . 
        str_replace($this->extension, $this->suffix . $this->extension, 
        $this->file), $this->quality);
    }
}