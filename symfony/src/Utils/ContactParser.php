<?php

namespace App\Utils;


/**
 * Class ContactParser
 */
class ContactParser implements BaseParserInterface
{

    /**
     * Parses the contact details
     * @param string $line
     *
     * @return array|mixed
     */
    public function parse(string $line)
    {
        $inOutCall = [];
        $contactName = [];
        $contactPhone = [];

        // Extract if sent or received sms.
        preg_match(
            LogParser::IN_OUT_REGEX,
            $line,
            $inOutCall,
            0,
            LogParser::IN_OUT_OFFSET
        );

        // Extracts the contact Phone.
        $phoneOffset = (int) $inOutCall[0] === 1
            ? LogParser::PHONE_OFFSET_INCOMING_CALL
            : LogParser::PHONE_OFFSET_OUTGOING_CALL;

        preg_match(
            LogParser::PHONE_REGEX,
            $line,
            $contactPhone,
            PREG_OFFSET_CAPTURE,
            $phoneOffset
        );
        $contactPhone = (int) current(current($contactPhone));

        // Extracts the name.
        preg_match(
            LogParser::NAME_REGEX,
            $line,
            $contactName,
            PREG_OFFSET_CAPTURE,
            LogParser::NAME_OFFSET
        );
        $contactName = trim(current(current($contactName)));

        return [
          'name'  => $contactName,
          'phone' => $contactPhone,
        ];
    }
}

