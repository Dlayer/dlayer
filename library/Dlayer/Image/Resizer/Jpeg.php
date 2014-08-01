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
    private $width;
    private $height;

    private $src_width;
    private $src_height;    
    private $src_file;
    private $src_path;
    
    private $mime = 'image/jpeg';
    
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
    
    /**
    * Load the image
    * 
    * @param string $file File name and extension
    * @param string $path Full patch to image
    * @return void|Exception 
    */
    public function loadImage($file, $path='') 
    {
        if(file_exists($path . $file) == TRUE) {
            
            $this->file = $file;
            $this->path = $path; 
            
            $this->validateImage();
        } else {
            throw new RuntimeException("File couldn't be found, supplied 
            destination: '" . $path . $file . "'");
        }
    }
    
    /**
    * Validate image is of correct mimetype, if not throw exception, called 
    * by the load image method
    * 
    * @return void|Exception
    */
    private function validateImage() 
    {
        $validator = new Zend_Validate_File_IsImage();
        $validator->setMimeType($this->mime);
        
        if($validator->isValid($this->path . $this->file) == FALSE) {
            throw new InvalidArgumentException("Supplied image not correct, 
            mime type invalid, needs to be '" . $this->mime . "'");
        }
    }
    
    /**
    * Fetch the dimensions for the source image
    * 
    * @return void Writes the values to the src properties
    */
    private function sourceDimensions() 
    {
        // getimagesize
    }
}