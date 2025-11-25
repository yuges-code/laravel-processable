<?php

namespace Yuges\Processable\Error;

class StageError
{
    public function __construct(
        public string $message,
        public int $code,
        public string $file,
        public int $line,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
    public function getCode(): int
    {
        return $this->code;
    }
    public function getFile(): string
    {
        return $this->file;
    }
    public function getLine(): int
    {
        return $this->line;
    }
}
