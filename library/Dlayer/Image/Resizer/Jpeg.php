<?php
/**
* Resizes the requested jpeg image, typically to create a thumbnail, the aspect 
* ratio of the image will be maintained adding white space as required
* 
* This class can only create smaller images, it doesn't upscale
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
class Dlayer_Image_Resizer_Jpeg extends Dlayer_Image_Resizer 
{
    private $width;
    private $height;
    
    private $dest_width;
    private $dest_height;
    
    private $spacing_x;
    private $spacing_y;

    private $src_width;
    private $src_height;    
    private $src_file;
    private $src_path;
    private $src_aspect_ratio;
    
    private $mime = 'image/jpeg';
    
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
            
            $this->sourceDimensions();
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
    * Fetch the dimensions for the source image and the aspect ratio. Also 
    * checks to ensure that the requested sizes aren't larger than the supplied 
    * image, the resizer does not upscale images
    * 
    * @return void|Exceptioon Writes the values to the src properties
    */
    private function sourceDimensions() 
    {
        $dimensions = getimagesize($this->path . $this->file);
        
        $this->src_width = $dimensions[0];
        $this->src_height = $dimensions[1];
        $this->src_aspect_ratio = $this->src_width / $this->src_height;
        
        if($this->width > $this->src_width || 
        $this->height > $this->src_height) {
            throw new InvalidArgumentException("Set resizer width or height 
            are larger then source width or height, the resizer does not 
            upscale images.");
        }
    }
    
    /**
    * Resize, calculate the size for the resized image maintaing aspect ratio 
    * whilst attempting to get to the requested canvas size
    * 
    * @return void|Exception
    */
    public function resize() 
    {
        if($this->src_aspect_ratio > 1) {
            $this->resizeLandscape();
        } else if($this->src_aspect_ratio == 1) {
            $this->resizeSquare();
        } else {
            $this->resizePortrait();
        }
        
        $this->spacingX();
        
        $this->spacingY();
        
        $this->create();
    }
    
    private function resizeLandscape() 
    {
        // Set width and then calculate height
        $this->dest_width = $this->width;
        $this->dest_height = number_format(
        $this->dest_width / $this->src_aspect_ratio, 0);
        
        // If height larger than requested, set and calculate new width
        if($this->dest_height > $this->height) {
            $this->dest_height = $this->height;
            $this->dest_width = number_format(
            $this->dest_height * $this->src_aspect_ratio, 0);
        }
    }
    
    private function resizeSquare() 
    {
        if($this->height == $this->width) {
            // Requesting a sqaure image, set destination sizes, no spacing
            $this->dest_width = $this->width;
            $this->dest_height = $this->height;
        } else if($this->width > $this->height) {
            // Requested landscapoe image, set height as dimension, will need 
            // horizontal spacing
            $this->dest_width = $this->height;
            $this->dest_height = $this->height;            
        } else {
            // Requested portrait image, set width as dimension, will need 
            // vertical spacing
            $this->dest_height = $this->width;
            $this->dest_width = $this->width;
        }
    }
    
    private function resizePortrait() 
    {
        // Set height and then calculate width
        $this->dest_height = $this->height;
        $this->dest_width = number_format(
        $this->dest_height * $this->src_aspect_ratio, 0);
        
        // If width larger than requested, set and calculate new height
        if($this->dest_width > $this->width) {
            $this->dest_width = $this->width;
            $this->dest_height = number_format(
            $this->dest_width / $this->src_aspect_ratio, 0);
        }
    }
    
    private function spacingX() 
    {
        $this->spacing_x = 0;
        
        if($this->dest_width < $this->width) {
            $width_difference = $this->width - $this->dest_width;
            
            if($width_difference % 2 == 0) {
                $this->spacing_x = $width_difference / 2;
            } else {
                if($width_difference > 1) {
                    $this->spacing_x = ($width_difference-1) / 2 + 1;
                } else {
                    $this->spacing_x = 1;
                }
            }
        }
    }
    
    private function spacingY() 
    {
        $this->spacing_y = 0;
        
        if($this->dest_height < $this->height) {
            $height_difference = $this->width - $this->dest_width;
            
            if($height_difference % 2 == 0) {
                $this->spacing_y = $height_difference / 2;
            } else {
                if($height_difference > 1) {
                    $this->spacing_y = ($height_difference-1) / 2 + 1;
                } else {
                    $this->spacing_y = 1;
                }
            }
        }
    }
    
    private function create() 
    {
        $canvas = imagecreatetruecolor($this->width, $this->height);
        
        $fill_color = imagecolorallocate($canvas, 255, 255, 0);
        imagefill($canvas, 0, 0, $fill_color);
        
        $copy = imagecreatefromjpeg($this->path . $this->file);
        
        imagecopyresampled($canvas, $copy, $this->spacing_x, 
        $this->spacing_y, 0 ,0, $this->dest_width, 
        $this->dest_height, $this->src_width, $this->src_height);
        
        imagejpeg($canvas, $this->path . 
        str_replace('.jpg', '-thumb.jpg', $this->file), 100);
        
        imagedestroy($canvas);
        imagedestroy($copy);      
    }
}