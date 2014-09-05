<?php

namespace kop\y2ts;

use SoapClient;
use yii\base\Component;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

/**
 * TurboSMS component gives you an ability to send SMS messages via TurboSMS.ua SMS gateway.
 *
 * This component is built with use of TurboSMS SOAP service.
 *
 * @link      http://turbosms.ua/soap.html TurboSMS SOAP service description.
 * @link      http://kop.github.io/yii2-turbosms Y2SP project page.
 * @license   https://github.com/kop/yii2-turbosms/blob/master/LICENSE.md MIT
 *
 * @author    Ivan Koptiev <ivan.koptiev@codex.systems>
 * @version   1.0
 */
class TurboSMS extends Component
{
    /**
     * @var string $username TurboSMS account username.
     */
    public $username;

    /**
     * @var string $username TurboSMS account password.
     */
    public $password;

    /**
     * @var string $alphaName The name of the sender.
     */
    public $alphaName;

    /**
     * @var SoapClient $_client SOAP client instance.
     */
    private $_client;

    /**
     * @var string $_serviceEndpoint TurboSMS SOAP endpoint.
     */
    private $_serviceEndpoint = 'http://turbosms.in.ua/api/wsdl.html';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Validate component settings
        if (empty($this->username) || empty($this->password) || empty($this->alphaName)) {
            $className = self::className();
            throw new InvalidConfigException(
                "Class \"{$className}\" requires \$username, \$password and \$alphaName attributes to be set."
            );
        }

        // Authenticate at TurboSMS service
        $this->_client = new SoapClient($this->_serviceEndpoint);
        $result = $this->_client->Auth([
            'login' => $this->username,
            'password' => $this->password,
        ]);
        if ($result->AuthResult !== 'Вы успешно авторизировались') {
            throw new ErrorException($result->AuthResult);
        }
    }

    /**
     * Send SMS message.
     *
     * @param string|array $destination One or multiple phone numbers.
     * @param string $message Text message.
     * @param string|bool $wapPush WAP Push link.
     *
     * @return array Operation results. This will return an array with two keys.
     * The first key is "status" which will contain the text status response from TurboSMS.
     * The second key is "messages" which will contain an array of unique ID's for each message.
     */
    public function send($destination, $message, $wapPush = false)
    {
        // Prepare SMS message
        $sms = [
            'sender' => $this->alphaName,
            'destination' => implode(',', (array) $destination),
            'text' => $message
        ];
        if ($wapPush) {
            $sms['wappush'] = $wapPush;
        }

        // Send message
        $result = $this->_client->SendSMS($sms);
        $result = $result->SendSMSResult->ResultArray;
        $status = array_shift($result);
        return [
            'status' => $status,
            'messages' => $result
        ];
    }

    /**
     * Get the current balance (in credits).
     *
     * @return integer Number of the credits.
     * Zero will be returned in case of errors.
     */
    public function balance()
    {
        $result = $this->_client->GetCreditBalance();
        return intval($result->GetCreditBalanceResult);
    }

    /**
     * Get the sending status of the SMS.
     *
     * @param string $messageID The unique message ID.
     * @return string Message sending status.
     */
    public function status($messageID)
    {
        $result = $this->_client->GetMessageStatus([
            'MessageId' => $messageID
        ]);
        return $result->GetMessageStatusResult;
    }
}