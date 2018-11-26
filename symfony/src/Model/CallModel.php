<?php

namespace App\Model;


/**
 * Class CallModel
 */
class CallModel extends BaseCommunicationModel
{
    protected $callDuration;

    /**
     * @return \DateTime
     */
    public function getCallDuration(): \DateTime
    {
        return $this->callDuration;
    }

    /**
     * @param \DateTime $callDuration
     */
    public function setCallDuration($callDuration): \DateTime
    {
        $this->callDuration = $callDuration;
    }


}
