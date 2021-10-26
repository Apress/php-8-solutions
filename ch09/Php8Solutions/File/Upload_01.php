<?php
namespace Php8Solutions\File;

class Upload {

    protected $permitted = [
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/webp'
    ];
    protected $messages = [];

    public function __construct(
        string $field,
        protected string $path,
        protected int $max = 51200
    ) {
        if (!is_dir($this->path) && !is_writable($this->path)) {
            throw new \Exception("$this->path must be a valid, writable directory.");
        } else {
            $this->path = rtrim($this->path, '/\\') . DIRECTORY_SEPARATOR;
            if ($this->checkFile($_FILES[$field])) {
                $this->moveFile($_FILES[$field]);
            }
        }
    }

    public function getMessages() {
        return $this->messages;
    }

    protected function checkFile($file) {
        return true;
    }

    protected function moveFile($file) {
        $success = move_uploaded_file($file['tmp_name'],
            $this->path . $file['name']);
        if ($success) {
            $result = $file['name'] . ' was uploaded successfully';
            $this->messages[] = $result;
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

}