<?php

namespace App\Integrations\Advertisers;

interface TransformerInterface
{
    public function parse(\stdClass $data);
}
