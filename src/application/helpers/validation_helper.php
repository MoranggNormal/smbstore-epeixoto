<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('check_required_fields')) {
    function check_required_fields($data, $required_fields)
    {
        if ($required_fields === null) {
            throw new InvalidArgumentException(
                "Missing the required_fields"
            );
        }

        foreach ($required_fields as $field => $field_name) {
            if (!isset($data[$field]) || (is_array($data[$field]) && count($data[$field]) === 0)) {
                throw new InvalidArgumentException(
                    "Missing the required parameter $field_name when validation field"
                );
            }
        }
    }
}
