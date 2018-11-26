<?php

namespace App\Utils;


/**
 * Interface BaseParserInterface
 */
interface BaseParserInterface
{
    /**
     * @param string $line
     *
     * @return mixed
     */
    public function parse(string $line);
}
