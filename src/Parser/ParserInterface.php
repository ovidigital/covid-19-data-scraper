<?php

namespace App\Parser;

use App\Data\DataInterface;
use Symfony\Component\CssSelector\Exception\ParseException;

interface ParserInterface {
    /**
     * Parse content and retrieve relevant data.
     *
     * @param string $content The content
     * @return DataInterface The data object
     * @throws ParseException
     */
    public function parse(string $content): DataInterface;
}
