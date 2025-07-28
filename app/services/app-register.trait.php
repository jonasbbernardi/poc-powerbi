<?php

trait AppRegisterTrait {
  protected function getToken() {
    $vars = Variables::get();

    $tenant_id     = $vars['tenant_id'];
    $client_id     = $vars['client_id'];
    $client_secret = $vars['client_secret'];
    $url           = "https://login.microsoftonline.com/$tenant_id/oauth2/v2.0/token";
    $scope         = "https://analysis.windows.net/powerbi/api/.default";
    $grant_type    = "client_credentials";
    $data = http_build_query([
      'client_id'     => $client_id,
      'client_secret' => $client_secret,
      'scope'         => $scope,
      'grant_type'    => $grant_type
    ]);
    $headers = [
      'Content-Type: application/x-www-form-urlencoded'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode >= 400) throw new Exception('AppRegister::getToken > Permission denied');
    if(curl_errno($ch)) throw new Exception('AppRegister::getToken > ' . curl_error($ch));
    curl_close($ch);

    $result = json_decode($resp, true);
    $access_token = isset($result['access_token']) ? $result['access_token'] : null;
    return $access_token;
  }
}
