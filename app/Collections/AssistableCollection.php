<?php

namespace Tactical\OpenAiTools\Collections;

use Illuminate\Support\Collection;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;

class AssistableCollection extends Collection
{
    public function __construct(HasAssistant ...$data)
    {
        parent::__construct($data);
    }
}
