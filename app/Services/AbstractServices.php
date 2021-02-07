<?php

namespace App\Services;

use Config;
use Log;
use App\Models\ApiCall;

/**
 * @author Jeremy Layson <jeremy.b.layon@gmail.com>
 * @version 1.0
 * @since 07.28.2018
 */
abstract class AbstractServices
{

    /**
     * Setup a custom response mechanism
     * @param  string $type
     * @param  array $data
     * @param  integer $responseCode
     * @return json
     */
    protected function response($type = 'success', $data = null, $responseCode = 200)
    {
        $response = [
            'status'  => true,
            'code'    => $responseCode
        ];

        if ($type === 'error') {
            $response['status']  = false;
            $response['errors']  = $data;
        }

        // return success message with data
        if ($type === 'success') {
            $response['responseData'] = $data;
        }

        return response($response, $responseCode);
    }

    public function getParameter($value, $default = '')
    {
        if (is_null($value) === TRUE) return $default;

        if ($value === '') return TRUE;

        return $value;
    }
}
