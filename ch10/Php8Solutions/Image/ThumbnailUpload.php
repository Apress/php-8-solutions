<?php
namespace Php8Solutions\Image;

use Php8Solutions\File\Upload;

require_once __DIR__ . '/../File/Upload.php';
require_once 'Thumbnail.php';

class ThumbnailUpload extends Upload {

    public function __construct(
        protected string $field,
        protected string $path,
        protected int $max = 51200,
        protected int $maxDimension = 120,
        protected string $suffix = '_thb',
        protected ?string $thumbPath = null,
        protected bool $deleteOriginal = false,
    ) {
        $this->thumbPath = $thumbPath ?? $path;
        if (is_dir($this->thumbPath) && is_writable($this->thumbPath)) {
            $this->thumbPath = rtrim($this->thumbPath, '/\\') . DIRECTORY_SEPARATOR;
        } else {
            throw new \Exception("$this->thumbPath must be a valid, writable directory.");
        }
        parent::__construct(
            $this->field,
            $this->path,
            $this->max
        );
    }

    protected function moveFile($file) {
        $filename = $this->newName ?? $file['name'];
        $success = move_uploaded_file($file['tmp_name'],
            $this->path . $filename);
        if ($success) {
            // add a message only if the original image is not deleted
            if (!$this->deleteOriginal) {
                $result = $file['name'] . ' was uploaded successfully';
                if (!is_null($this->newName)) {
                    $result .= ', and was renamed ' . $this->newName;
                }
                $this->messages[] = $result;
            }
            // create a thumbnail from the uploaded image
            $this->createThumbnail($this->path . $filename);
            // delete the uploaded image if required
            if ($this->deleteOriginal) {
                unlink($this->path . $filename);
            }
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

    protected function createThumbnail($image) {
        $thumb = new Thumbnail($image, $this->thumbPath, $this->maxDimension, $this->suffix);
        $thumb->create();
        $messages = $thumb->getMessages();
        $this->messages = array_merge($this->messages, $messages);
    }

}
