<?php

namespace App\Services;

use SimpleXMLElement;

class XMLParser
{

    public function parse($xml)
    {
        $data = simplexml_load_string($xml, SimpleXMLElement::class, LIBXML_NOCDATA);
        return json_decode(json_encode($data), true);
    }
}
