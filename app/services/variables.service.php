<?php

class Variables {
  public static function get() {
    $env = parse_ini_file('/usr/local/etc/.env');
    return [
      'workspaceId'   => $env['WORKSPACEID'],
      'reportId'      => $env['REPORTID'],
      'tenant_id'     => $env['TENANT_ID'],
      'client_id'     => $env['CLIENT_ID'],
      'client_secret' => $env['CLIENT_SECRET'],
    ];
  }
}
