<?php

namespace App\Helpers;

use Exception;

trait Converter{
    public function replaceBase64(string $data): array
    {
        $type = null;

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]);
        
            if (!in_array($type, ['jpg','jpeg','png'])) {
                throw new Exception('invalid image type');
            }

            $data = str_replace(' ', '+', $data );
            $data = base64_decode($data);
        
            if ($data === false) {
                throw new Exception('base64_decode failed');
            }
        } else {
            var_dump($data);
            var_dump($type);
            throw new Exception('did not match data URI with image data');
        }
        
        return ['data' => $data, 'ext' => $type];
    }
}