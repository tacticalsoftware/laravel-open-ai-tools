<?php

namespace Tactical\OpenAiTools;

if (! function_exists('fmt')) {
    function fmt(string $format, ...$args): string
    {
        $placeholder = md5($format);

        $format = str_replace('%%', "__{$placeholder}__", $format);
        $format = str_replace('%', '%s', $format);
        $format = str_replace("__{$placeholder}__", '%', $format);

        return sprintf($format, ...$args);
    }
}
