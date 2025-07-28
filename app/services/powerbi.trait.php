<?php



trait PowerBiTrait {
  protected function getReportDatasetId($token) {
    $vars = Variables::get();
    $workspaceId = $vars['workspaceId'];
    $reportId = $vars['reportId'];
    $url = "https://api.powerbi.com/v1.0/myorg/groups/$workspaceId/reports/$reportId";
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode >= 400) throw new Exception('PowerBi::getReportDatasetId > ' . $httpCode . ' Permission denied');
    if(curl_errno($ch)) throw new Exception('PowerBi::getReportDatasetId > ' . curl_error($ch));
    curl_close($ch);

    $result = json_decode($resp, true);
    $embedUrl  = isset($result['embedUrl']) ? $result['embedUrl'] : null;
    $datasetId = isset($result['datasetId']) ? $result['datasetId'] : null;
  
    return [
      'embedUrl'  => $embedUrl,
      'datasetId' => $datasetId 
    ];
  }

  protected function getEmebedToken($token, $datasetId) {
    $vars = Variables::get();
    $workspaceId = $vars['workspaceId'];
    $reportId = $vars['reportId'];
    $url = "https://api.powerbi.com/v1.0/myorg/GenerateToken";
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ];
    $reportData = [
      "reports" => [ ["id" => $reportId] ],
      "datasets" => [ ["id" => $datasetId] ],
      "targetWorkspaces" => [ ["id" => $workspaceId] ]
    ];
    $data_json = json_encode($reportData);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($httpCode >= 400) throw new Exception('PowerBi::getEmebedToken > Permission denied');
    if(curl_errno($ch)) throw new Exception('PowerBi::getEmebedToken > ' . curl_error($ch));
    curl_close($ch);

    $result = json_decode($resp, true);
    $token = isset($result['token']) ? $result['token'] : null;

    return $token;
  }
}
