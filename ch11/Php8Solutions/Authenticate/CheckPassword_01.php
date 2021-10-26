<?php
namespace Php8Solutions\Authenticate;

class CheckPassword {

    const MIN_LENGTH = 8;
    protected array $errors = [];

    public function __construct(
        protected string $password,
        protected ?int $minChars = null,
        protected bool $mixedCase = false,
        protected int $minNums = 0,
        protected int $minSymbols = 0
    ) {
        if (!isset($this->minChars) || $this->minChars < self::MIN_LENGTH) {
            $this->minChars = self::MIN_LENGTH;
        }
        $this->check();
    }

    public function getErrors() {
        return $this->errors;
    }

    protected function check() {
        if (preg_match('/\s{2,}/', $this->password)) {
            $this->errors[] = 'Password can contain only single spaces.';
        }
        if (strlen($this->password) < $this->minChars) {
            $this->errors[] = "Password must be at least 
                    $this->minChars characters.";
        }
    }

}
