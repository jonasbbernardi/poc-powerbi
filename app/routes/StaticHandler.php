<?php

class StaticHandler {
    public static function handle($request_uri) {
        $file_path = __DIR__ . '/../public' . $request_uri;

        if (is_dir($file_path)) {
            $file_path .= '/index.html';
        }

        if (file_exists($file_path) && is_file($file_path)) {
            $mime_type = StaticHandler::getMimeType($file_path);
            header('Content-Type: ' . $mime_type);
            readfile($file_path);
            exit(0);
        }

        header("HTTP/1.0 404 Not Found");
        header('Content-Type: application/json');
        echo json_encode([
            'status'  => 'error',
            'message' => 'Page not found'
        ]);
        exit(0);
    }

    public static function getMimeType($file_path) {
        $ext = pathinfo($file_path, PATHINFO_EXTENSION);
        $mime_types = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'html' => 'text/html',
        ];
        return isset($mime_types[$ext]) ? $mime_types[$ext] : mime_content_type($file_path);
    }
}