<?php

class Recaptcha
{
    public $_publicKey  = '6LdwXcoSAAAAABfCaO-Xbx6AMi3zwLK3qV-arCzY';
    private $_privateKey = '6LdwXcoSAAAAAJRRR4B_pY-ZU-svaV_msQ0vMQSb';
    private $_apiUrl    = 'http://www.google.com/recaptcha/api/verify';


    function __construct()
    {
    }

    public function getRecaptchaHTML()
    {
        return '<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LdwXcoSAAAAABfCaO-Xbx6AMi3zwLK3qV-arCzY"></script>
              	<noscript>
                 <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LdwXcoSAAAAABfCaO-Xbx6AMi3zwLK3qV-arCzY"
                     height="300" width="500" frameborder="0"></iframe><br>
                 <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                 </textarea>
                 <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
              	</noscript>';
    }

    public function validateRecaptcha( $challenge = null, $response = null )
    {
        if ( $challenge AND $response )
        {
            $remoteIp = $_SERVER['REMOTE_ADDR'];
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $this->_apiUrl );
            curl_setopt( $ch, CURLOPT_POST, 2 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, 'privatekey='.$this->_privateKey.'&remoteip='.$remoteIp.'&challenge='.urlencode( $challenge ).'&response='.urlencode( $response ) );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
            $responseString = curl_exec( $ch );
            $response = curl_getinfo( $ch );

            //echo '#z'. substr( $responseString, 0, 4);
            if ( curl_errno( $ch ))
                return false;
            $resultLines = explode( "\n", $responseString );

            if ( substr( $responseString, 0, 4) === 'true')
                return true;
            else
                return false;
        }

        return false;
    }
}
?>