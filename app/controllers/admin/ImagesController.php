<?php

namespace App\Controllers\Admin;

use App\Facades\Faker\Faker;
use App\Facades\Http\Request;
use App\Facades\Http\Response;
use App\Helpers\Storage;
use App\Model\Image;

class ImagesController extends DashController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->render();
    }

    public function add()
    {
        return $this->render();
    }

    public function store(Request $request)
    {
        if ($request->has('img')) {
            if (! $this->validate($request->all(), [
                'name' => 'required|min:3|unique:'.Image::class,
                'img' => 'required'
            ])) $this->sendError();
        } else {
            if (! $this->validate(array_merge($request->file(), $request->all()), [
                'name' => 'required|min:3|unique:'.Image::class,
                'file' => 'checkFile|required'
            ])) $this->sendError();
        }
        
        do {
            $hash = Faker::hash(50);
            $res = Image::where(['hash', '=', $hash])->findOrFail();
        } while(! empty($res));
        
        if ((bool) strpos($request->get('img'), ',')) {
            $img = substr($request->get('img'), strpos($request->get('img'), ',') + 1);
            $img = str_replace( ' ', '+', $img);
            file_put_contents(
                storage_path('public/images/'.$hash.'.jpg'),
                base64_decode($img)
            );
        } else {
            if (! Storage::disk('public')
                ->upload($request->file('file'), '/images/', $hash)
            ) {
                $this->sendError('Nie można załadować zdjęcia!');
            }
        }

        Image::insert([
            'name' => $request->get('name'),
            'path' => 'images/',
            'hash' => $hash,
            'cid'  => $request->get('cid') ?? null,
            'ext'  => strtolower(pathinfo($request->file('file')['name'], PATHINFO_EXTENSION)),
            'created_by' => $this->user['id']
        ]);
        
        $this->sendSuccess('Zdjęcie dodane');
    }

    public function update(Request $request)
    {

    }
    
    public function show(Request $request)
    {
        if ($request->has('search')) {
            $images = Image::select(['images.hash', 'images.path', 'images.name', 'images.ext', 'i.name as item_name', 'm.name as monster_name'])
                ->leftJoin(['items as i', 'images.cid', '=', 'i.cid'])
                ->leftJoin(['monsters as m', 'images.cid', '=', 'm.cid'])
                ->where(['images.name', 'like', '%'.$request->get('search').'%'])
                ->get();
        } else {
            $images = Image::select(['hash', 'path', 'name', 'ext'])->get();
        }
        
        return $this->render([
            'images' => $images
        ]);
    }

    public function edit(int $id)
    {

    }
    
    public function find(string $name)
    {
        $images = Image::select(['path', 'hash', 'id', 'name', 'ext'])
            ->where(['name', 'like', '%'.$name.'%'])
            ->get();
        
        $response = [];
        foreach ($images as $img) {
            $response[] = [
                'text' => '<img style="width: 20px;" src="storage/public/'.$img['path'].$img['hash'].'.'.$img['ext'].'">'. $img['name'],
                'value' => $img['id']
            ];
        }
        
        Response::json($response);
    }
    
    public function draw(int $imageId)
    {
        $img = Image::select('*')->where(['id', '=', $imageId])->findOrFail();
        if ($img) {
            return $this->render(['img' => $img['path'].$img['hash'].'.'.$img['ext']]);
        } else {
            $this->redirect('');
        }
    }
    
    public function setImage(Request $request)
    {
        if ($request->has('img')) {
            $this->sendSuccess('Zaraz nastąpi przekierowanie', 'images/draw/'.$request->get('img'));
        } else {
            return $this->render();
        }
    }
    
//    public function reload()
//    {
//        $img = Storage::disk('private')->get('images/outfits/', '*', GLOB_BRACE, false);
//
//        foreach ($img as $value) {
//            $name = pathinfo($value);
//            if (! Image::where(['cid', '=', $name['filename']])->findOrFail()) {
//                do {
//                    $hash = Faker::hash(50);
//                    $res = Image::where(['hash', '=', $hash])->findOrFail();
//                } while(! empty($res));
//
//                copy (
//                    $value,
//                    storage_path('public/images/'.$hash.'.'.$name['extension'])
//                );
//                Image::insert([
//                    'name' => $name['filename'],
//                    'cid' => $name['filename'],
//                    'hash' => $hash,
//                    'path' => 'images/',
//                    'created_by' => 1,
//                    'ext' => $name['extension']
//                ]);
//            }
//        }
//    }
}
