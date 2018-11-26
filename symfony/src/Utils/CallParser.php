<?php

namespace App\Utils;


/**
 * Class CallParser
 */
class CallParser implements BaseParserInterface
{

    /**
     * Parses the call communication
     * @param string $line
     *
     * @return array
     */
    public function parse(string $line): array
    {


        $dateTime = [];
        $callDuration = [];
        $targetPhone = [];

        // Extract if incoming or outgoing call.
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

        // Extracts the call duration.
        preg_match(
            LogParser::CALL_DURATION_REGEX,
            $line,
            $callDuration,
            PREG_OFFSET_CAPTURE,
            LogParser::CALL_DURATION_OFFSET
        );
        $callDuration = current(current($callDuration));

        // Returns the parsed metadata.
        $data = [
            'communications' => [
                'type' => 'call',
                'inOut' => (int) $inOutCall[0] === 1 ? 'incoming' : 'outgoing',
                'phone' => $targetPhone,
                'date' => $dateTime,
                'duration' => $callDuration,
            ],
        ];

        return $data;
    }
}
