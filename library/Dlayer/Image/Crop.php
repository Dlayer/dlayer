<?php
/**
* Crops the source image based on the selection area and position, all params 
* will be validated including ensuring that the crop selection fits within the 
* source image
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
abstract class Dlayer_Image_Crop 
{
    protected $src_width;
    protected $src_height;    
    protected $src_file;
    protected $src_path;
    
    protected $crop_width;
    protected $crop_height; 
    protected $crop_x;
    protected $crop_y;
    
    protected $src_image;
    protected $cropped_image;

    protected $quality;
    
    protected $mime;    
    protected $extension;
    
    protected $suffix = '-cropped';
    
    protected $invalid;
    protected $errors  = array();
    
    /**
    * Set the crop options, set here to allow batch processing by repeatedly 
    * calling the loadImage and crop methods
    * 
    * @param integer $x_position X position of crop selection rectangle
    * @param integer $y_position Y position of crop selection rectangle
    * @param integer $width Width of crop selection rectangle
    * @param integer $height Height of crop selected rectangle
    * @param integer $quality Quality or compression level for new image if 
    *                         required by format
    * @return void|Exception
    */
    public function __construct($x_position, $y_position, $width, $height, 
    $quality) 
    {
        if(is_int($x_position) == FALSE || $x_position < 0) {            
            $this->invalid++;
            $this->errors[] = 'X crop position not valid, must be a positive 
            integer';
        }
        
        if(is_int($y_position) == FALSE || $y_position < 0) {            
            $this->invalid++;
            $this->errors[] = 'Y crop position not valid, must be a positive 
            integer';
        }
        
        if(is_int($width) == FALSE || $width < 0) {            
            $this->invalid++;
            $this->errors[] = 'Width not valid, must be an integer above 0';
        }
        
        if(is_int($height) == FALSE || $height < 1) {
            $this->invalid++;
            $this->errors[] = 'Height not valid, must be an integer above 0';
        }
        
        if($this->invalid == 0) { 
            $this->crop_x = $x_position;
            $this->crop_y = $y_position;
            $this->crop_width = $width;
            $this->crop_height = $height;
            $this->quality = $quality;
        } else {
            throw new InvalidArgumentException("Error(s) creating cropper: " . 
            implode(' - ', $this->errors));
        }
    }
    
    /**
    * Load the image, image is validated, source dimensions are fetched and the 
    * the previouslt defined crop selections are validated against the source 
    * image
    * 
    * @param string $file File name and extension
    * @param string $path Full path to image
    * @return void|Exception 
    */
    public function loadImage($file, $path='') 
    {
        if(file_exists($path . $file) == TRUE) {
            
            $this->file = $file;
            $this->path = $path; 
            
            $this->validateImage();
            
            $this->sourceDimensions();
            
            $this->validateCropSelection();
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
    * Validate crop selection, checks to ensure that the crop selection fits 
    * within the source image
    * 
    * @return void|Exception
    */
    protected function validateCropSelection() 
    {
        if(($this->crop_x + $this->crop_width) > $this->src_width || 
        ($this->crop_y + $this->crop_height) > $this->src_height) {
            throw new RuntimeException("Crop selection does not fit within the 
            source image, combined crop width: " . 
            ($this->crop_x + $this->crop_width) . ' height: ' . 
            ($this->crop_y + $this->crop_height) . 
            ' source image dimensions - width: ' . $this->src_width . 
            ' height: ' . $this->src_height);
        }
    }
    
    /**
    * Fetch the dimensions for the source image
    * 
    * @return void|Exception Writes the values to the src properties
    */
    protected function sourceDimensions() 
    {
        $dimensions = getimagesize($this->path . $this->file);
        
        $this->src_width = $dimensions[0];
        $this->src_height = $dimensions[1];
    }
    
    /**
    * Crop the selected image
    * 
    * Although the suffix for the new image can be defined the path cannot be 
    * changed, that is outside the scope of this class, it is down to the 
    * client developer to create directories and then oevrride the save method
    * 
    * @param string $suffix Suffix for newly cropped 
    * @return void|Exception
    */
    public function crop($suffix='-cropped') 
    {
        if(strlen(trim($suffix)) > 0) {
            $this->suffix = trim($suffix);
        } else {
            throw new InvalidArgumentException("Suffix must be defined 
            otherwise cropped image will conflict with source image");
        }
        
        $this->create();
    }
      
    /**
    * Destroy the image resources
    * 
    * @return void
    */
    public function __destruct() 
    {
        if(isset($this->cropped_image) == TRUE) {
            imagedestroy($this->cropped_image);
        }
        if(isset($this->src_image) == TRUE) {
            imagedestroy($this->src_image); 
        }
    }
    
    /**
    * Crop image
    * 
    * @return void|Exception
    */
    protected function cropImage() 
    {
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
    * Required method in child classes which creates the requested image
    * 
    * @return void|Exception
    */
    abstract protected function create();
}