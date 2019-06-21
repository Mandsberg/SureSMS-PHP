<?php
/*
 * SureSMS - http://github.com/Mandsberg/SureSMS-PHP
 */

class SureSMS
{
    private $username;
    private $password;
    private $log_file;
    public $request;
    public $response;
    public $replaces = array( //Illegal characters
        "/贸/" => "o"
     );


    function log($message) {
        if ($this->log_file) {
            $message = date('c') . ' ' . var_export($message, true) . "\n";
            file_put_contents($this->log_file, $message, FILE_APPEND);
        }
    }

    public function __construct($username, $password, $log_file = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->log_file = $log_file;
    }


    function send($message, $recipient, $sender = false) {
        $pars = array(
            'username' => $this->username,
            'password' => $this->password,
            'recipient' => $recipient,
            'from' => $sender ?: '',
            'url' => null,
            'message' => preg_replace(array_keys($this->replaces), array_values($this->replaces), $message),
            'utf8' => 1,
        );
        $context = stream_context_create(array('http' => array('header' => "Accept-Charset: UTF-8;")));
        $this->request = 'http://api.suresms.com/script/sendsms.aspx?' . http_build_query($pars);
        $this->response = file_get_contents($this->request, FALSE, $context);

        $this->log("Sms sent: " . print_r($this->request, true) . " / "  . print_r($this->response, true));
        if (empty($this->response)) {
            throw new Exception('Cannot send the SMS.');
        }
        if (stristr($this->response, 'error')) {
            return false;
        }
        return true;
    }
 
}
