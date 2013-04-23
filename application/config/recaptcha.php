<?
/*
The reCaptcha server keys and API locations

Obtain your own keys from:
http://www.recaptcha.net
*/
$config['recaptcha'] = array(
  'public'                      => '6LdG8N4SAAAAAJjoAsUpOFmXXgu275uW78oY2her',
  'private'                     => '6LdG8N4SAAAAAIpz3-y9JAtLAcF6XO6vwIM67LWK',
  'RECAPTCHA_API_SERVER'        => 'http://www.google.com/recaptcha/api',
  'RECAPTCHA_API_SECURE_SERVER' => 'https://www.google.com/recaptcha/api',
  'RECAPTCHA_VERIFY_SERVER'     => 'www.google.com',
  'RECAPTCHA_SIGNUP_URL'        => 'https://www.google.com/recaptcha/admin/create',
  'theme'                       => 'red'
);
