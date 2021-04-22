<?php

namespace App\Facades\Parser;

use App\Facades\Faker\Faker;
use App\Helpers\Storage;
use App\Model\Image;

class Facade
{
    protected static function getImage(int $cid, string $name, string $from, string $ext='gif')
    {
        if (app('force_update_images') === false) {
            return false;
        }
        
        Storage::disk('public')->make('images');
        
        if ($cid === 0 || $cid === null) {
            return false;
        }
        
        if (empty(Image::where(['cid', '=', $cid])->findOrFail())
            && is_file(storage_path('private/images/'.$from.'/'.$cid.'.'.$ext))
        ) {
            do {
                $hash = Faker::hash(50);
                $res = Image::where(['hash', '=', $hash])->findOrFail();
            } while(! empty($res));
            
            copy (
                storage_path('private/images/'.$from.'/'.$cid.'.'.$ext),
                storage_path('public/images/'.$hash.'.'.$ext)
            );
            Image::insert([
                'name' => $name,
                'cid' => $cid,
                'hash' => $hash,
                'path' => 'images/',
                'created_by' => 1,
                'ext' => $ext
            ]);
        }
    }
}
