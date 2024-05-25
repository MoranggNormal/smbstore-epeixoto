<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('http_response_code_map')) {
    function http_response_code_map($status = NULL)
    {
        if ($status !== NULL) {
            switch ($status) {
                case 'OK':
                    return 200;
                case 'CREATED':
                    return 201;
                case 'BAD_REQUEST':
                    return 400;
                case 'UNAUTHORIZED':
                    return 401;
                case 'FORBIDDEN':
                    return 403;
                case 'NOT_FOUND':
                    return 404;
                case 'INTERNAL_SERVER_ERROR':
                    return 500;
                default:
                    return 500;
            }
        }
        return NULL;
    }
}
