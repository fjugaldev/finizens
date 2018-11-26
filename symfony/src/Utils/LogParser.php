<?php

namespace App\Utils;

/**
 * Class LogParser
 */
class LogParser
{
    const QUERY_NUMBER = 611111111;
    const FULL_CALL_REGEX_VALIDATOR = '/[Cc][0-9]{9}[0-9]{9}[01]{1}[A-Za-z[:space:]]{1,24}[0-9]{14}[0-9]{6}/';
    const FULL_SMS_REGEX_VALIDATOR = '/[Ss][0-9]{9}[0-9]{9}[01]{1}[A-Za-z[:space:]]{1,24}[0-9]{14}/';
    const CALL_SMS_REGEX = '/[CcSs]/';
    const NAME_REGEX = '/[A-Za-z[:space:]]{1,24}/';
    const PHONE_REGEX = '/[0-9]{9}/';
    const IN_OUT_REGEX = '/[01]{1}/';
    const DATE_TIME_REGEX = '/[0-9]{14}/';
    const CALL_DURATION_REGEX = '/[0-9]{6}/';
    const PHONE_OFFSET_INCOMING_CALL = 1;
    const PHONE_OFFSET_OUTGOING_CALL = 10;
    const NAME_OFFSET = 20;
    const IN_OUT_OFFSET = 19;
    const DATE_TIME_OFFSET = 44;
    const CALL_DURATION_OFFSET = 58;

    /**
     * @param array $communicationLog
     *
     * @return array
     */
    public function parse(array $communicationLog)
    {
        try {
            $contacts = [];
            foreach ($communicationLog as $line) {
                // Validates each line in order to check the expected format
                if (preg_match(self::FULL_CALL_REGEX_VALIDATOR, $line) ||
                    preg_match(self::FULL_SMS_REGEX_VALIDATOR, $line)
                ) {
                    // Parse Contact details.
                    $contactParser = new ContactParser();
                    $contact = $contactParser->parse($line);
                    $type = [];
                    // Extracts the type.
                    preg_match(self::CALL_SMS_REGEX, $line, $type);
                    // Gets the parser.
                    $parser = $this->getParser(current($type));
                    // Execute parser.
                    $data = $parser->parse($line);
                    // Adds the data to the contact array.
                    $contacts[$data['details']['phone']]['details'] = $contact;
                    $contacts[$data['details']['phone']]['communications'][] = $data['communications'];
                }

            }
            // Return parsed metadata.
            return $contacts;

        } catch (\Exception $e) {
        }
    }

    /**
     * @param string $type
     *
     * @return CallParser|SmsParser
     *
     * @throws \Exception
     */
    protected function getParser(string $type)
    {
        switch ($type) {
            case 'C':
                // Call
                $parser = new CallParser();
                break;

            case 'S':
                // SMS
                $parser = new SmsParser();
                break;

            default:
                // Unknown log entry
                throw new \Exception("Invalid log entry.");
        }

        return $parser;
    }
}
