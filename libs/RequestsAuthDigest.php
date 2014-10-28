<?php

class Requests_Auth_Digest extends Requests_Auth_Basic {
 
    public function curl_before_send(&$handle) {
        curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($handle, CURLOPT_USERPWD, $this->getAuthString());
    }
}