<?php

namespace Tactical\OpenAiTools\Collections;

use Illuminate\Support\Collection;

class StringCollection extends Collection
{
    public function __construct(string ...$data)
    {
        parent::__construct($data);
    }
}
