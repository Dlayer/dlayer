<?php
/**
* Custom resizer class for the Dlayer Image library, additional functionality 
* includes setting a custom save location and name and also placing images 
* that are smaller than than the desired thumbnail onto a canvas
*  
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
abstract class Dlayer_Image_LibraryResizer 
{
    protected $width;
    protected $height;
    
    protected $dest_width;
    protected $dest_height;
    protected $dest_file;
    protected $dest_path;
    
    protected $spacing_x;
    protected $spacing_y;

    protected $src_width;
    protected $src_height;    
    protected $src_file;
    protected $src_path;
    protected $src_aspect_ratio;
    
    protected $canvas;
    protected $copy;
    
    protected $maintain_aspect;
    
    protected $canvas_color = array('r'=>255, 'g'=>255, 'b'=>0);
    protected $quality;
    
    protected $mime;    
    protected $extension;
    
    protected $suffix = '-thumb';
    
    protected $invalid;
    protected $errors  = array();
    
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
        if(is_int($width) == FALSE || $width < 1) {            
            $this->invalid++;
            $this->errors[] = 'Width not valid, must be an integer above 0';
        }
        
        if(is_int($height) == FALSE || $height < 1) {
            $this->invalid++;
            $this->errors[] = 'Height not valid, must be an integer above 0';
        }
        
        if($this->colorIndexValid('r', $canvas_color) == FALSE || 
        $this->colorIndexValid('g', $canvas_color) == FALSE || 
        $this->colorIndexValid('b', $canvas_color) == FALSE) {
            $this->invalid++;
            $this->errors[] = 'Canvas color array invalid, must contain three 
            indexes, r, g and b each with values between 0 and 255';
        }
        
        if($this->invalid == 0) { 
            $this->width = intval($width);
            $this->height = intval($height);
            $this->quality = $quality;
            $this->canvas_color = $canvas_color;
            if($maintain_aspect == TRUE) {
                $this->maintain_aspect = TRUE;
            } else {
                $this->maintain_aspect = FALSE;
            }
        } else {
            throw new InvalidArgumentException("Error(s) creating resizer: " . 
            implode(' - ', $this->errors));
        }
    }
    
    /**
    * Check to see if the supplied color index is valid
    * 
    * @param string $index
    * @param array Color array to check
    * @return boolean
    */
    private function colorIndexValid($index, array $canvas_color) 
    {
        if(array_key_exists($index, $canvas_color) == TRUE && 
        $canvas_color[$index] >= 0 && $canvas_color[$index] <= 255) {
            return TRUE;
        } else {
            return FALSE;
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
    * Fetch the dimensions for the source image and the aspect ratio.
    * 
    * @return void|Exceptioon Writes the values to the src properties
    */
    protected function sourceDimensions() 
    {
        $dimensions = getimagesize($this->path . $this->file);
        
        $this->src_width = intval($dimensions[0]);
        $this->src_height = intval($dimensions[1]);
        $this->src_aspect_ratio = $this->src_width / $this->src_height;
    }
    
    /**
    * Calculate the size for the resized image maintaining aspect ratio 
    * if required.
    * 
    * @param string $path Destination path
    * @param string $file Destination filename (no extension)
    * @return void|Exception
    */
    public function resize($path, $file) 
    {
        if(strlen(trim($path)) > 0 && strlen(trim($file)) > 0) {
            $this->dest_path = trim($path);
            $this->dest_file = $file;
        } else {
            throw new InvalidArgumentException("Destination path and filename 
            not defined.");
        }
        
        if($this->src_aspect_ratio > 1) {
            $this->resizeLandscape();
        } else if($this->src_aspect_ratio == 1) {
            $this->resizeSquare();
        } else {
            $this->resizePortrait();
        }
        
        if($this->maintain_aspect == TRUE) {
            $this->spacingX();
        
            $this->spacingY();
        } else {
            $this->dest_width = $this->width;
            $this->dest_height = $this->height;
        }
        
        $this->create();
    }
    
    /**
    * Calculate new destination width and height for a landscape based image
    * 
    * @return void
    */
    protected function resizeLandscape() 
    {
        if($this->src_width >= $this->width) {
            // Source width is greater than or equal to requested width.            
            // Set width to requested size and calculate the corresponding 
            // height using the current aspect ration.
            $this->dest_width = $this->width;
            $this->dest_height = intval(round(
            $this->dest_width / $this->src_aspect_ratio, 0));
            
            if($this->dest_height > $this->height) {
                // Newly calculated height is larger than requested height, 
                // set height and then recalculate the width
                $this->dest_height = $this->height;
                $this->dest_width = intval(round(
                $this->dest_height * $this->src_aspect_ratio, 0));
            }
        } else {
            $this->dest_width = $this->src_width;
            $this->dest_height = $this->src_height;
            
            // Source width smaller than requested width, check source height 
            // against requested height and modify width accordingly
            if($this->src_height > $this->height) {
                $this->dest_height = $this->height;
                $this->dest_width = intval(round(
                $this->dest_height * $this->src_aspect_ratio, 0));
            }
        }
    }
    
    /**
    * Calculate new destination width and height for a square image
    */
    protected function resizeSquare() 
    {
        if($this->height == $this->width) {
            // Requested a square destination image
            if($this->src_width >= $this->width) {
                // Source image larger than or equal to requested image
                $this->dest_width = $this->width;
                $this->dest_height = $this->height;
            } else {
                // Source image smaller than requested image
                $this->dest_width = $this->src_width;
                $this->dest_height = $this->src_height;
            }
        } else if($this->width > $this->height) {
            $this->resizeLandscape();
        } else {
            $this->resizePortrait();
        }
    }
    
    /**
    * Calculate new destination width and height for a portrait based image
    * 
    * @return void
    */
    protected function resizePortrait() 
    {
        if($this->src_height >= $this->height) {
            // Source height is greater than or equal to requested height.            
            // Set height to requested size and calculate the corresponding 
            // width using the current aspect ratio.
            $this->dest_height = $this->height;
            $this->dest_width = intval(round(
            $this->dest_height * $this->src_aspect_ratio, 0));
            
            if($this->dest_width > $this->width) {
                // Newly calculated width is larger than requested width, 
                // set width and then recalculate the height
                $this->dest_width = $this->width;
                $this->dest_height = intval(round(
                $this->dest_width / $this->src_aspect_ratio, 0));
            }
        } else {
            $this->dest_width = $this->src_width;
            $this->dest_height = $this->src_height;
            
            // Source height smaller than requested height, check source width 
            // against requested width and modify width accordingly
            if($this->src_width > $this->width) {
                $this->dest_width = $this->width;
                $this->dest_height = intval(round(
                $this->dest_width / $this->src_aspect_ratio, 0));
            }
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
            
            $height_difference = $this->height - $this->dest_height;
            
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
        if(isset($this->canvas) == TRUE) {
            imagedestroy($this->canvas);
        }
        if(isset($this->copy) == TRUE) {
            imagedestroy($this->copy); 
        }
    }
    
    /**
    * Required method in child classes which creates the requested image
    * 
    * @return void|Exception
    */
    abstract protected function create();
}