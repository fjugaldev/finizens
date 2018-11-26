<?php

namespace App\Utils;


class ContactParser
{

    public function parse(array $communicationLog)
    {
        foreach ($communicationLog as $line) {
            $contactName = [];
            $contactPhone = [];
            preg_match('/[A-Za-z[:space:]]{1,24}/', $line, $contactName, 1);
            preg_match('/[0-9]{9}/', $line, $contactPhone, PREG_OFFSET_CAPTURE, 9);
            preg_match('/[0-9]{9}/', $line, $contactPhone, PREG_OFFSET_CAPTURE, 20);
            var_dump($contactName);
            var_dump($contactPhone);
            die();

        }
    }

}
