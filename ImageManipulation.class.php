<?php
/**
 * Image Manipulation Library
 *
 * This library is used for image manipulation functionalities
 * like "Fit", "Fill", "Stretch", "Center". We have developed
 * this image library in flexible and very user-friendly
 * usage.
 *
 * @author Siva Perumal <siva7170430@gmail.com>
 * @author Selva Vignesh <selvavignesh128@gmail.com>
 * @version 1.1
 * @license Open Source
 */

class ImageManipulation{
    private $file_from="";
    private $image_transparent=true;
    private $file_type="";
    private $manipulation_action="";
    private $result=false;
    private $msg="";

    //  image file original

    private $original_filename="";
    private $original_filesize="";
    private $original_filewidth="";
    private $original_fileheight="";
    private $original_fileaspect_ratio="";
    private $original_filepath="";  //  always be temp file if it is uploaded; Otherwise, it will be path or URL
    private $original_filetype="";

    //  image file original (manipulated)

    private $modified_filex="";
    private $modified_filey="";
    private $modified_filewidth="";
    private $modified_fileheight="";
    private $modified_fileaspect_ratio="";
    private $modified_filepath="";  //  always be temp file if it is uploaded; Otherwise, it will be path or URL

    // image file processed/processing  (destination)

    private $proc_filename="";
    private $proc_filesize="";
    private $proc_filewidth="";
    private $proc_fileheight="";
    private $proc_fileaspect_ratio="";
    private $proc_filequality="";  //  in percentage
    private $proc_filepath="";

    // image file processed/processing workspace (whitepaper)

    private $whitepaper_width="";
    private $whitepaper_height="";
    private $whitepaper_aspect_ratio="";
    private $whitepaper_color=[255,255,255];

    // some constant

    const IMAGE_TYPE_PNG="png";
    const IMAGE_TYPE_JPEG="jpeg";
    const IMAGE_TYPE_JPG="jpg"; // no use
    const IMAGE_TYPE_GIF="gif";

    const IMAGE_ACTION_FIT="fit";
    const IMAGE_ACTION_FILL="fill";
    const IMAGE_ACTION_CENTER="center";
    const IMAGE_ACTION_STRETCH="stretch";

    /**
     * ImageManipulation constructor.
     *
     * This library usage:
     *
     * $image=new ImageManipulation();
     * $image->ImageFrom("image.jpg");
     * $test=$image->IsOkay();
     * echo var_dump($test[0])."-".$test[1];
     * $image->ImageType(ImageManipulation::IMAGE_TYPE_GIF);
     * $image->ImagePreserverTransparent(true);
     * $image->ImageManipulationAction(ImageManipulation::IMAGE_ACTION_FILL);
     * $image->ImageQuality(80);
     * $image->ImageResize(1000,1000);
     * $image->WorkSpaceColor(0,255,0);
     * $image->Output("../img1.gif");
     */
    public function __construct()
    {
        $this->file_type=self::IMAGE_TYPE_JPG;
        $this->manipulation_action=self::IMAGE_ACTION_FILL;
        $this->result=false;
        $this->whitepaper_color=[255,255,255];
        $this->msg="Please select image file path/URL!";
    }

    /**
     * We should pass path of image into this method
     *
     * @param string $file_from Image file path
     */
    public function ImageFrom($file_from){
        $this->file_from=$file_from;
        if(!file_exists($this->file_from)){
            $this->result=false;
            $this->msg="File is not found!";
        }
        else{
            $file_mime=exif_imagetype($this->file_from);
            if($file_mime!=false){
                switch($file_mime){
                    case IMAGETYPE_GIF:
                        $this->original_filetype=self::IMAGE_TYPE_GIF;
                        break;
                    case IMAGETYPE_JPEG:
                        $this->original_filetype=self::IMAGE_TYPE_JPEG;
                        $this->proc_filequality=90;
                        break;
                    case IMAGETYPE_PNG:
                        $this->original_filetype=self::IMAGE_TYPE_PNG;
                        $this->proc_filequality=8;
                        break;
                }
                $temp_array=[self::IMAGE_TYPE_GIF,self::IMAGE_TYPE_JPEG,self::IMAGE_TYPE_PNG];
                if(in_array($this->original_filetype,$temp_array)){
                    $this->result=true;
                    $this->msg="Input file is found!";
                }
                else{
                    $this->result=false;
                    $this->msg="Unsupported file!";
                }
            }
            else{
                $this->result=false;
                $this->msg="Unsupported file!";
            }
        }
    }

    /**
     * This method will return the status of the functionality
     * whether is going good or not.
     *
     * @return array
     */
    public function IsOkay(){
        return [$this->result,$this->msg];
    }

    /**
     * We may set the file type either PNG or GIF or JPG.
     * This image library will convert the image type to
     * this type.
     *
     * Default:  JPG
     *
     * @param string $file_type File type : Use ImageManipulation::IMAGE_TYPE_GIF, ImageManipulation::IMAGE_TYPE_JPG, ImageManipulation::IMAGE_TYPE_JPEG, ImageManipulation::IMAGE_TYPE_PNG
     */
    public function ImageType($file_type){
        $this->file_type=$file_type;
    }

    /**
     * If you use final file type is PNG/GIF, the you may set
     * this option to preserve the transparency of the image
     *
     * Default: true
     *
     * @param bool $transparent Set either TRUE or FALSE
     */
    public function ImagePreserverTransparent($transparent){
        $this->image_transparent=$transparent;
    }

    /**
     * We may set the image manipulation action here. This library has four
     * actions. The output of the image will be based on this action selection
     *
     * Default: ImageManipulation::IMAGE_ACTION_FILL
     *
     * @param string $file_action File action : Use ImageManipulation::IMAGE_ACTION_FIT or ImageManipulation::IMAGE_ACTION_FILL or ImageManipulation::IMAGE_ACTION_CENTER or ImageManipulation::IMAGE_ACTION_STRETCH
     */
    public function ImageManipulationAction($file_action){
        $this->manipulation_action=$file_action;
    }

    /**
     * We may also set image quality. Based on this image
     * quality value, final image output will be generated
     *
     * Note: There is no quality option provided for GIF
     * image output.
     *
     * Default: 90 for JPEG; 8 for PNG
     *
     * @param int $file_quality Pass between 0 to 100 for JPEG; Pass 0 to 9 for PNG
     */
    public function ImageQuality($file_quality){
        $this->proc_filequality=$file_quality;
    }

    /**
     * This method used to specify the image width & height.
     *
     * @param int $file_resize_width Final output image width
     * @param int $file_resize_height Final output image height
     */
    public function ImageResize($file_resize_width, $file_resize_height){
        $this->proc_filewidth=$file_resize_width;
        $this->proc_fileheight=$file_resize_height;
    }

    /**
     *
     */
    public function calculation(){
        list($this->original_filewidth, $this->original_fileheight)=getimagesize($this->file_from);
        $sw=$this->original_filewidth;
        $sh=$this->original_fileheight;
        $sar=($sw/$sh);
        $dw=$this->proc_filewidth;
        $dh=$this->proc_fileheight;
        $dar=($dw/$dh);
        if($this->manipulation_action==self::IMAGE_ACTION_FIT){
            $temp_sw=$dw;
            $temp_sh=($temp_sw/$sar);

            if($dh>$temp_sh){
                $this->modified_filewidth=$temp_sw;
                $this->modified_fileheight=$temp_sh;
                $this->modified_filex=0;
                $this->modified_filey=($this->proc_fileheight-$this->modified_fileheight)/2;
            }
            else{
                $temp_sh=$dh;
                $temp_sw=($temp_sh*$sar);
                if($dw>$temp_sw){
                    $this->modified_filewidth=$temp_sw;
                    $this->modified_fileheight=$temp_sh;
                    $this->modified_filex=($this->proc_filewidth-$this->modified_filewidth)/2;
                    $this->modified_filey=0;
                }
                else{
                    $this->modified_filewidth=$this->proc_filewidth;
                    $this->modified_fileheight=$this->proc_fileheight;
                    $this->modified_filex=0;
                    $this->modified_filey=0;
                }
            }
        }
        elseif($this->manipulation_action==self::IMAGE_ACTION_FILL){
            if($sar<$dar){
                $temp_sw=$dw;
                $temp_sh=($temp_sw/$sar);
                $this->modified_filewidth=$temp_sw;
                $this->modified_fileheight=$temp_sh;
                $this->modified_filex=0;
                $this->modified_filey=($this->proc_fileheight-$this->modified_fileheight)/2;
            }
            elseif($sar>$dar){
                $temp_sh=$dh;
                $temp_sw=($temp_sh*$sar);
                $this->modified_filewidth=$temp_sw;
                $this->modified_fileheight=$temp_sh;
                $this->modified_filex=($this->proc_filewidth-$this->modified_filewidth)/2;
                $this->modified_filey=0;
            }
            else{
                $this->modified_filewidth=$this->proc_filewidth;
                $this->modified_fileheight=$this->proc_fileheight;
                $this->modified_filex=0;
                $this->modified_filey=0;
            }
        }
        elseif($this->manipulation_action==self::IMAGE_ACTION_CENTER){
            $this->modified_filewidth=$sw;
            $this->modified_fileheight=$sh;
            $this->modified_filex=($this->proc_filewidth-$this->modified_filewidth)/2;
            $this->modified_filey=($this->proc_fileheight-$this->modified_fileheight)/2;
        }
        elseif($this->manipulation_action==self::IMAGE_ACTION_STRETCH){
            $this->modified_filewidth=$this->proc_filewidth;
            $this->modified_fileheight=$this->proc_fileheight;
            $this->modified_filex=0;
            $this->modified_filey=0;
        }
    }

    /**
     * This will execute final process of this image library
     * It will automatically generate image based on all values
     * given to this library and default values.
     *
     * Default: (empty)
     *
     * @param string $output (Optional) If you want to show final output to browser, please leave this parameter to empty. Otherwise, please specify the path to write on disk.
     * @param bool $file_overwrite (Optional) If true, file will be overwritten. If no, file will not overwrite but error will show at the end.
     */
    public function Output($output="",$file_overwrite=true){
        $this->proc_filepath=$output;
        if($this->result!=false){
            if($this->proc_filepath!=""){
                $outputPath=pathinfo($this->proc_filepath, PATHINFO_DIRNAME);
                if(file_exists($outputPath)){
                    $this->result=true;
                    $this->msg="Input file is found. Output path is found";
                    if(file_exists($this->proc_filepath) && !$file_overwrite){
                        $this->result=false;
                        $this->msg="Input file is found. ";
                    }
                    elseif(file_exists($this->proc_filepath) && $file_overwrite){
                        $this->result=true;
                        $this->msg="Input file is found. Output path is found and there is file exist with this name. So, it will overwrite that file.";
                    }
                    else{
                        $this->result=true;
                        $this->msg="Input file is found. Output path is found and there is no file with this name.";
                    }
                }
                else{
                    $this->result=false;
                    $this->msg="Input file is found. ";
                }
            }
            else{
                $this->result=true;
                $this->msg="Input file is found. Output path is not specified.";
            }

            if($this->result!=false){
                $this->calculation();
                $this->ImageProceedAndOutput();
            }
        }
    }

    /**
     *
     */
    public function ImageProceedAndOutput(){
        $dstimage=imagecreatetruecolor($this->proc_filewidth,$this->proc_fileheight);

        if(!$this->image_transparent || $this->original_filetype!=self::IMAGE_TYPE_PNG){
            $white = imagecolorallocate($dstimage, $this->whitepaper_color[0], $this->whitepaper_color[1], $this->whitepaper_color[2]);
            imagefill($dstimage,0,0,$white);
        }

        switch($this->original_filetype){
            case self::IMAGE_TYPE_PNG:
                $srcimage=imagecreatefrompng($this->file_from);
                if($this->image_transparent){
                    imagecolortransparent($dstimage, imagecolorallocatealpha($dstimage, 0, 0, 0, 127));
                    imagealphablending($dstimage, false);
                    imagesavealpha($dstimage, true);
                }
                break;
            case self::IMAGE_TYPE_JPEG:
                $srcimage=imagecreatefromjpeg($this->file_from);
                break;
            case self::IMAGE_TYPE_GIF:
                $srcimage=imagecreatefromgif($this->file_from);
                break;
        }

        imagecopyresampled($dstimage,$srcimage,$this->modified_filex,$this->modified_filey,0,0,$this->modified_filewidth,$this->modified_fileheight, $this->original_filewidth,$this->original_fileheight);

        if($this->proc_filepath==""){
            switch($this->file_type){
                case self::IMAGE_TYPE_PNG:
                    header("Content-type: image/png");
                    imagepng($dstimage);
                    break;
                case self::IMAGE_TYPE_JPEG:
                case self::IMAGE_TYPE_JPG:
                    header("Content-type: image/jpeg");
                    imagejpeg($dstimage);
                    break;
                case self::IMAGE_TYPE_GIF:
                    header("Content-type: image/gif");
                    imagegif($dstimage);
                    break;
            }
        }
        else{
            switch($this->file_type){
                case self::IMAGE_TYPE_PNG:
                    imagepng($dstimage,$this->proc_filepath,$this->proc_filequality);
                    break;
                case self::IMAGE_TYPE_JPEG:
                case self::IMAGE_TYPE_JPG:
                    imagejpeg($dstimage,$this->proc_filepath,$this->proc_filequality);
                    break;
                case self::IMAGE_TYPE_GIF:
                    imagegif($dstimage,$this->proc_filepath);
                    break;
            }
        }
    }

    /**
     * This is workspace color. You can see this color on
     * ImageManipulation::IMAGE_ACTION_FIT
     *
     * @param int $red Specify color value from 0 to 255
     * @param int $green Specify color value from 0 to 255
     * @param int $blue Specify color value from 0 to 255
     */
    public function WorkSpaceColor($red, $green, $blue){
        $this->whitepaper_color=[$red,$green,$blue];
    }
}
