<?php

include_once __DIR__ . '/variables.service.php';
include_once __DIR__ . '/app-register.trait.php';
include_once __DIR__ . '/powerbi.trait.php';

class TokenService {
  use PowerBiTrait, AppRegisterTrait;

  public function getCredentials() {
    try{
      $token = $this->getToken();
      $reportData = $this->getReportDatasetId($token);
      $embedToken = $this->getEmebedToken($token, $reportData['datasetId']);
      return [
        'embedToken' => $embedToken,
        'embedUrl' => $reportData['embedUrl']
      ];
    } catch (Exception $e) {
      error_log($e->getMessage());
      throw new Exception('Cant get credentials.');
    }
  }
}
