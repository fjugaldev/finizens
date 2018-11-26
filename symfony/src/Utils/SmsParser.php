<?php

namespace App\Utils;


/**
 * Class SmsParser
 */
class SmsParser implements BaseParserInterface
{
    /**
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

        preg_match(
            LogParser::IN_OUT_REGEX,
            $line,
            $inOutCall,
            0,
            LogParser::IN_OUT_OFFSET
        );

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

        preg_match(
            LogParser::NAME_REGEX,
            $line,
            $contactName,
            PREG_OFFSET_CAPTURE,
            LogParser::NAME_OFFSET
        );
        $contactName = trim(current(current($contactName)));

        preg_match(
            LogParser::DATE_TIME_REGEX,
            $line,
            $dateTime,
            PREG_OFFSET_CAPTURE,
            LogParser::DATE_TIME_OFFSET
        );
        $dateTime = current(current($dateTime));

        $data = [
            'details' => [
                'name' => $contactName,
                'phone' => $contactPhone,
            ],
            'communications' => [
                'sms' => [
                    'type' => (int) $inOutCall[0] === 1 ? 'received' : 'sent',
                    'phone' => $targetPhone,
                    'date' => $dateTime,
                ],
            ],
        ];

        return $data;
    }
}
