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
   protected $newName;
   protected $filenames = [];

    public function __construct(
        string $field,
        protected string $path,
        protected int $max = 51200,
        string|array|null $mime = null,
        bool $rename = true
    ) {
        if (!is_dir($this->path) && !is_writable($this->path)) {
            throw new \Exception("$this->path must be a valid, writable directory.");
        } else {
            $this->path = rtrim($this->path, '/\\') . DIRECTORY_SEPARATOR;
            if (!is_null($mime)) {
                $this->permitted = array_merge($this->permitted, (array)$mime);
            }
            $uploaded = $_FILES[$field];
            if (is_array($uploaded['name'])) {
                // deal with multiple uploads
                $numFiles = count($uploaded['name']);
                $keys = array_keys($uploaded);
                for ($i = 0; $i < $numFiles; $i++) {
                    $values = array_column($uploaded, $i);
                    $currentfile = array_combine($keys, $values);
                    $this->processUpload($currentfile, $rename);
                }
            } else {
                $this->processUpload($_FILES[$field], $rename);
            }
        }
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getMaxSize() {
        return number_format($this->max / 1024, 1) . ' KB';
    }

    public function getFilenames() {
        return $this->filenames;
    }

    protected function checkFile($file) {
        $errorCheck = $this->getErrorLevel($file);
        if ($errorCheck !== true) {
            $this->messages[] = $errorCheck;
            $errorCheck = false;
        }
        $sizeCheck = $this->checkSize($file);
        $typeCheck = false;
        if (!empty($file['type'])) {
            $typeCheck = $this->checkType($file);
        }
        return $errorCheck && $sizeCheck && $typeCheck;
    }

    protected function getErrorLevel($file) {
        $result = match($file['error']) {
            0 => true,
            1, 2 => $file['name'] . ' is too big: (max: ' .
                    $this->getMaxSize() . ').',
            3 => $file['name'] . ' was only partially uploaded.',
            4 => 'No file submitted.',
            default => 'Sorry, there was a problem uploading ' . $file['name']
        };
        return $result;
    }

    protected function checkSize($file) {
        if ($file['error'] == 1 || $file['error'] == 2 ) {
            return false;
        } elseif ($file['size'] == 0) {
            $this->messages[] = $file['name'] . ' is an empty file.';
            return false;
        } elseif ($file['size'] > $this->max) {
            $this->messages[] = $file['name'] . ' exceeds the maximum size 
                    for a file (' . $this->getMaxSize() . ').';
            return false;
        }
        return true;
    }

    protected function checkType($file) {
        if (!in_array($file['type'], $this->permitted)) {
            $this->messages[] = $file['name'] . ' is not a permitted type of file.';
            return false;
        }
        return true;
    }

    protected function checkName($file, $rename)
    {
        $this->newName = null;
        $nospaces = str_replace(' ', '_', $file['name']);
        if ($nospaces != $file['name']) {
            $this->newName = $nospaces;
        }
        if ($rename) {
            $name = $this->newName ?? $file['name'];
            if (file_exists($this->path . $name)) {
                // rename file
                $basename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $this->newName = $basename . '_' . time() . ".$extension";
            }
        }
    }

    protected function processUpload($uploaded, $rename) {
        if ($this->checkFile($uploaded)) {
//            echo "Processing {$uploaded['name']} <br>";
            $this->checkName($uploaded, $rename);
            $this->moveFile($uploaded);
        }
    }

    protected function moveFile($file) {
        $filename = $this->newName ?? $file['name'];
        $success = move_uploaded_file($file['tmp_name'],
            $this->path . $filename);
        if ($success) {
            $this->filenames[] = $filename;
            $result = $file['name'] . ' was uploaded successfully';
            if (!is_null($this->newName)) {
                $result .= ', and was renamed ' . $this->newName;
            }
            $this->messages[] = $result;
        } else {
            $this->messages[] = 'Could not upload ' . $file['name'];
        }
    }

}