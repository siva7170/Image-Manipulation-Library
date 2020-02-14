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

> Default: ImageManipulation::IMAGE_TYPE_JPG

**Available options:**

* ImageManipulation::IMAGE_TYPE_GIF
* ImageManipulation::IMAGE_TYPE_JPG
* ImageManipulation::IMAGE_TYPE_JPEG
* ImageManipulation::IMAGE_TYPE_PNG

### ImageManipulationAction

We may set the image manipulation action here. This library has four actions. The output of the image will be based on this action selection

```php
$image->ImageManipulationAction(ImageManipulation::IMAGE_ACTION_FILL);
```

> Default: ImageManipulation::IMAGE_ACTION_FILL

**Available options:**

* ImageManipulation::IMAGE_ACTION_FIT
* ImageManipulation::IMAGE_ACTION_FILL
* ImageManipulation::IMAGE_ACTION_CENTER
* ImageManipulation::IMAGE_ACTION_STRETCH

### ImageResize

This method used to specify the image width & height.

```php
$image->ImageResize(1000,1000);
```

### ImageQuality

We may also set image quality. Based on this image quality value, final image output will be generated

Note: There is no quality option provided for GIF image output.

> Default: 90 for JPEG; 8 for PNG

```php
$image->ImageResize(1000,1000);
```

### ImageQuality

We may also set image quality. Based on this image quality value, final image output will be generated

Note: There is no quality option provided for GIF image output.

> Default: 90 for JPEG; 8 for PNG

```php
$image->ImageResize(1000,1000);
```
