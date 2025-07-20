<?php

namespace Yuges\Processable\Abstracts;

abstract class Stage implements \Yuges\Processable\Interfaces\Stage
{
    protected $name = 'Stage';

    public function execute()
    {
        return;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
