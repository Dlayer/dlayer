<?php
/**
* Resizes the requested jpeg image, typically to create a thumbnail, the aspect 
* ratio of the image will be maintained adding white space as required
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_Resizer_Jpeg extends Dlayer_Image_Resizer 
{
    /**
    * Width for the new image/thumbnail
    * 
    * @var integer
    */
    private $width;
    
    /**
    * Height for the new image/thumbnail
    * 
    * @var integer
    */
    private $height;
    
    /**
    * Width of source image
    * 
    * @var integer
    */
    private $src_width;
    
    /**
    * Height of source image
    * 
    * @var integer
    */
    private $src_height;
    
    /**
    * Constructor, set base resizing options, only set base options to allow 
    * batch processing by just loading an image and then resizing with set 
    * params
    * 
    * @param integer $width
    * @param integer $height
    * @return void|Exception
    */
    public function __construct($width, $height) 
    {
        if(is_int($width) == TRUE && is_int($height) == TRUE && 
        $width > 0 && $height > 0) {
            $this->width = intval($width);
            $this->height = intval($height);
        } else {
            throw new InvalidArgumentException("Width and height not valid, 
            must be integers with values above 0, supplied width and height 
            were, width: '" . $width . "' height: '" . $height . "'");
        }
    }
}