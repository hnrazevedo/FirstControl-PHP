<?php

namespace App\Helpers;

trait Converter
{
    public function replaceBase64(string $data): array
    {
        $type = null;

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]);
        
            if (!in_array($type, ['jpg','jpeg','png'])) {
                throw new \RuntimeException('invalid image type');
            }

            $data = str_replace(' ', '+', $data );
            $data = base64_decode($data);
        
            if ($data === false) {
                throw new \RuntimeException('base64_decode failed');
            }
        } else {
            throw new \RuntimeException('did not match data URI with image data');
        }
        
        return ['data' => $data, 'ext' => $type];
    }
}
