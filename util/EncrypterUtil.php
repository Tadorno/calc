<?php
namespace app\util;

class EncrypterUtil {

    private const encrypt_method = "AES-256-CBC";
    private const secret_key = 'tadorno';
    private const secret_iv = 'tulioasc';

    public static function encrypt($string) {
        $output = false;

        // hash
        $key = hash('sha256', EncrypterUtil::secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', EncrypterUtil::secret_iv), 0, 16);

        $output = openssl_encrypt($string, EncrypterUtil::encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    function decrypt($string) {
        $output = false;

        // hash
        $key = hash('sha256', EncrypterUtil::secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', EncrypterUtil::secret_iv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), EncrypterUtil::encrypt_method, $key, 0, $iv);

        return $output;
    }
}