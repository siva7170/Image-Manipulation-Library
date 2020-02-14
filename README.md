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

### ImageFrom

We should pass path of image into this method

```php
$image->ImageFrom("image.png");
```

### ImageType

We may set the file type either PNG or GIF or JPG. This image library will convert the image type to this type.

```php
$image->ImageType(ImageManipulation::IMAGE_TYPE_GIF);
```

**Available options:**

* ImageManipulation::IMAGE_TYPE_GIF
* ImageManipulation::IMAGE_TYPE_JPG
* ImageManipulation::IMAGE_TYPE_JPEG
* ImageManipulation::IMAGE_TYPE_PNG
