<?php
namespace Php8Solutions\Image;

class Thumbnail {
    protected $original;
    protected $originalWidth;
    protected $originalHeight;
    protected $basename;
    protected $imageType;
    protected $messages = [];

    public function __construct(
        string $image,
        protected string $path,
        protected int $max = 120,
        protected string $suffix = '_thb'
    ) {
        if (is_file($image) && is_readable($image)) {
            $dimensions = getimagesize($image);
        } else {
            throw new \Exception("Cannot open $image.");
        }
        if (!is_array($dimensions)) {
            throw new \Exception("$image doesn't appear to be an image.");
        } else {
            if ($dimensions[0] == 0) {
                throw new \Exception("Cannot determine size of $image.");
            }
            // check the MIME type
            if (!$this->checkType($dimensions['mime'])) {
                throw new \Exception('Cannot process that type of file.');
            }
        }
        if (is_dir($path) && is_writable($path)) {
            $this->path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
        } else {
            throw new \Exception("Cannot write to $path.");
        }
        $this->original = $image;
        $this->originalWidth = $dimensions[0];
        $this->originalHeight = $dimensions[1];
        $this->basename = pathinfo($image, PATHINFO_FILENAME);
        $this->max = abs($max);
        if ($suffix != '_thb') {
            $this->suffix = $this->setSuffix($suffix) ?? '_thb';
        }
    }

    public function create() {
        $ratio = $this->calculateRatio();
        $thumbWidth = round($this->originalWidth * $ratio);
        $thumbHeight = round($this->originalHeight * $ratio);
        $resource = $this->createImageResource();
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled($thumb, $resource, 0, 0, 0, 0, $thumbWidth,
            $thumbHeight, $this->originalWidth, $this->originalHeight);
        $newname = $this->basename . $this->suffix;
        switch ($this->imageType) {
            case 'jpeg':
                $newname .= '.jpg';
                $success = imagejpeg($thumb, $this->path . $newname, 100);
                break;
            case 'png':
                $newname .= '.png';
                $success = imagepng($thumb, $this->path . $newname, 0);
                break;
            case 'gif':
                $newname .= '.gif';
                $success = imagegif($thumb, $this->path . $newname);
                break;
            case 'webp':
                $newname .= '.webpgif';
                $success = imagewebp($thumb, $this->path . $newname, 100);
                break;
        }
        if ($success) {
            $this->messages[] = "$newname created successfully.";
        } else {
            $this->messages[] = "Couldn't create a thumbnail for " .
                basename($this->original);
        }
        imagedestroy($resource);
        imagedestroy($thumb);
    }

    public function getMessages() {
        return $this->messages;
    }

    protected function checkType($mime) {
        $mimetypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($mime, $mimetypes)) {
            // extract the characters after '/'
            $this->imageType = substr($mime, strpos($mime, '/')+1);
            return true;
        }
        return false;
    }

    protected function setSuffix($suffix) {
        if (preg_match('/^\w+$/', $suffix)) {
            if (!str_starts_with($suffix, '_')) {
                return '_' . $suffix;
            } else {
                return $suffix;
            }
        }
    }

    protected function calculateRatio() {
        if ($this->originalWidth <= $this->max && $this->originalHeight <= $this->max) {
            return 1;
        } elseif ($this->originalWidth > $this->originalHeight) {
            return $this->max/$this->originalWidth;
        } else {
            return $this->max/$this->originalHeight;
        }
    }

    protected function createImageResource() {
        switch ($this->imageType) {
            case 'jpeg':
                return imagecreatefromjpeg($this->original);
            case 'png':
                return imagecreatefrompng($this->original);
            case 'gif':
                return imagecreatefromgif($this->original);
            case 'webp':
                return imagecreatefromwebp($this->original);
        }
    }

}
