<?php

namespace App\Utils;


/**
 * Class SmsParser
 */
class SmsParser implements BaseParserInterface
{
    /**
     * Parses the sms communication
     * @param string $line
     *
     * @return array
     */
    public function parse(string $line): array
    {
        $inOutCall = [];
        $contactName = [];
        $contactPhone = [];
        $dateTime = [];
        $targetPhone = [];

        // Extract if sent or received sms.
        preg_match(
            LogParser::IN_OUT_REGEX,
            $line,
            $inOutCall,
            0,
            LogParser::IN_OUT_OFFSET
        );

        // Extracts the target phone.
        $phoneOffset = (int) $inOutCall[0] === 1
            ? LogParser::PHONE_OFFSET_OUTGOING_CALL
            : LogParser::PHONE_OFFSET_INCOMING_CALL;

        preg_match(
            LogParser::PHONE_REGEX,
            $line,
            $targetPhone,
            PREG_OFFSET_CAPTURE,
            $phoneOffset
        );
        $targetPhone = (int) current(current($targetPhone));

        // Extracts the datetime.
        preg_match(
            LogParser::DATE_TIME_REGEX,
            $line,
            $dateTime,
            PREG_OFFSET_CAPTURE,
            LogParser::DATE_TIME_OFFSET
        );
        $dateTime = current(current($dateTime));

        // Returns the parsed metadata.
        $data = [
            'communications' => [
                'type' => 'sms',
                'inOut' => (int) $inOutCall[0] === 1 ? 'received' : 'sent',
                'phone' => $targetPhone,
                'date' => $dateTime,
            ],
        ];

        return $data;
    }
}
