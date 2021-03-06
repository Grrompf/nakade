<?php
namespace Appointment\Mail;

/**
 * mail for both players after confirming
 *
 * @package Appointment\Mail
 */
class ConfirmMail extends AppointmentMail
{

    /**
     * @return string
     */
    public function getMailBody()
    {

        $message =
            $this->translate('The new appointment for your match date at %URL% is confirmed.') .
            PHP_EOL . PHP_EOL .
            $this->translate('Your match: %MATCH_INFO%') .
            PHP_EOL .
            $this->translate('New match date: %NEW_DATE%') .
            PHP_EOL . PHP_EOL .
            $this->translate('If you use a calendar application, do not forget to update.') . ' ' .
            $this->translate('An updated iCal is found on your site after login at %URL%.') .
            PHP_EOL . PHP_EOL .
            $this->getSignature()->getSignatureText();

            $this->makeReplacements($message);

        return $message;
    }

    /**
     * @return string
     */
    public  function getSubject()
    {
        return $this->translate('Your League Appointment is confirmed');
    }

}