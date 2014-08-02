<?php
/**
* Image resizer, creates a smaller copy of the supplied image at the 
* requested size. The aspect ratio of the image is maintained during the 
* resizing, white canvas spacing will be added around the image as required.
* 
* This class only creates smaller versions of an image, it is not able to 
* create an image with a dimension large than the source image
* 
* This is a simple resizer, options aren't configurabe, by default it creates 
* a thumbnail in the same directory as the source imagge with -thumb added as 
* a suffix to the file name
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
abstract class Dlayer_Image_Resizer 
{
    protected $width;
    protected $height;
    
    protected $dest_width;
    protected $dest_height;
    
    protected $spacing_x;
    protected $spacing_y;

    protected $src_width;
    protected $src_height;    
    protected $src_file;
    protected $src_path;
    protected $src_aspect_ratio;
    
    protected $canvas;
    protected $copy;
    
    protected $canvas_color = array('r'=>255, 'g'=>255, 'b'=>0);
    
    protected $mime;    
    protected $extension;
    
    protected $suffix = '-thumb';
    
    /**
    * Set base resizing options, only setting the base resizing option here 
    * to allow some simple batch processing by repeatedly calling the loadImage 
    * and resize method
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
    protected function validateImage() 
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
    protected function sourceDimensions() 
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
    
    protected function resizeLandscape() 
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
    
    protected function resizeSquare() 
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
    
    protected function resizePortrait() 
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
    
    /**
    * Calculate the x spacing if the width of the resampled image will be 
    * smaller than the width defined for the new thumbnail
    * 
    * @return void
    */
    protected function spacingX() 
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
    
    /**
    * Calculate the y spacing if the height of the resampled image will be 
    * smaller than the height defined for the new thumbnail
    * 
    * @return void
    */
    protected function spacingY() 
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
    
    /**
    * Destroy the image resources
    * 
    * @return void
    */
    public function __destruct() 
    {
        imagedestroy($this->canvas);
        imagedestroy($this->copy); 
    }
}