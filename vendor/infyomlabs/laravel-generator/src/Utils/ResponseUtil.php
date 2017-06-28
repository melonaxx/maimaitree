<?php

namespace InfyOm\Generator\Utils;

class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data, $code)
    {
        return [
            'e' => $code,
            'm' => $message,
            'data'    => $data,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data, $code)
    {
        $res = [
            'e' => $code,
            'm' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
