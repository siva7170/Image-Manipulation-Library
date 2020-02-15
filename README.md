# Image Manipulation Library

This library is used for image manipulation functionalities like "Fit", "Fill", "Stretch", "Center". We have developed this image library in flexible and very user-friendly
usage.

## Getting Started

This library is developed in PHP. So, you need below requirement to proceed before the next steps.

### Prerequisites

* PHP 7+

* gd2 module should be enabled

### Initialization

Include Image "ImageManipulation.class.php" on your PHP file and create object for the class ImageManipulation

```php
include("ImageManipulation.class.php");

$image=new ImageManipulation();
```

## Usage

Below code is sample for how to use it. Please see methods and its functionalities below sections.

```php
include("ImageManipulation.class.php");

$image=new ImageManipulation();
$image->ImageFrom("image.png");
$image->ImageType(ImageManipulation::IMAGE_TYPE_GIF);
$image->ImagePreserverTransparent(true);
$image->ImageManipulationAction(ImageManipulation::IMAGE_ACTION_FILL);
$image->ImageQuality(80);
$image->ImageResize(1000,1000);
$image->WorkSpaceColor(0,255,0);
$image->Output("../image.gif");
```

## Methods

### ImageFrom(file_from)

- **file_from**:
  - Type: `String`

We should pass path of image into this method

```php
$image->ImageFrom("image.png");
```

### ImageType(file_type) (optional)

- **file_type**:
  - Type: `String`
  - Default: ImageManipulation::IMAGE_TYPE_JPG

We may set the file type either PNG or GIF or JPG. This image library will convert the image type to this type.

```php
$image->ImageType(ImageManipulation::IMAGE_TYPE_GIF);
```

**Available options:**

* ImageManipulation::IMAGE_TYPE_GIF
* ImageManipulation::IMAGE_TYPE_JPG
* ImageManipulation::IMAGE_TYPE_JPEG
* ImageManipulation::IMAGE_TYPE_PNG

### ImageManipulationAction(file_action) (optional)

- **file_action**:
  - Type: `String`
  - Default: ImageManipulation::IMAGE_ACTION_FILL
  
We may set the image manipulation action here. This library has four actions. The output of the image will be based on this action selection

```php
$image->ImageManipulationAction(ImageManipulation::IMAGE_ACTION_FILL);
```

**Available options:**

* ImageManipulation::IMAGE_ACTION_FIT
* ImageManipulation::IMAGE_ACTION_FILL
* ImageManipulation::IMAGE_ACTION_CENTER
* ImageManipulation::IMAGE_ACTION_STRETCH

### ImageResize(file_resize_width, file_resize_height)

- **file_resize_width**:
  - Type: `Integer`

- **file_resize_height**:
  - Type: `Integer`

This method used to specify the image width & height.

```php
$image->ImageResize(1000,1000);
```

### ImageQuality(file_quality) (optional)

- **file_quality**:
  - Type: `Integer`
  - Default: 90 for JPEG; 8 for PNG
  
We may also set image quality. Based on this image quality value, final image output will be generated. Please pass between 0 to 100 for JPEG; Pass 0 to 9 for PNG

Note: There is no quality option provided for GIF image output.

```php
$image->ImageQuality(80);
```

### ImagePreserverTransparent(transparent) (optional)

- **transparent**:
  - Type: `Boolean`
  - Default: true (For GIF <=> PNG )
  
If you use final file type is PNG/GIF, the you may set this option to preserve the transparency of the image. Please set either TRUE or FALSE

```php
$image->ImagePreserverTransparent(true);
```

### WorkSpaceColor(red, green, blue) (optional)

- **red**:
  - Type: `Integer`
  - Default: 255

- **green**:
  - Type: `Integer`
  - Default: 255
  
- **blue**:
  - Type: `Integer`
  - Default: 255
  
This is workspace color. You can see this color on ImageManipulation::IMAGE_ACTION_FIT.

```php
$image->WorkSpaceColor(0,255,0);
```

### Output([output])

- **output** (optional):
  - Type: `String`

This will execute final process of this image library. It will automatically generate image based on all values given to this library and default values. If you want to show final output to browser, please leave this parameter to empty. Otherwise, please specify the path to write on disk.

```php
$image->Output("../img1.gif"); // It will write image on disk
```

Or

```php
$image->Output(); // It will show image on browser directly
```
