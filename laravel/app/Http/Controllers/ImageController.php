<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image as ImageModel;
use App\Services\StoreImage;
use Illuminate\Http\Request;
use Ramsey\Uuid\Nonstandard\Uuid;
use Image;

class ImageController extends Controller
{
    protected $image_name;
    protected $drive;
    protected $image_extension;
    protected $store_image_service;
    protected $image_orginal_name;

    public function __construct(Request $request)
    {
        $this->drive = 'uploads/' . $request->get('drive') ?? 'images';
        $this->image_name = Uuid::uuid4();
        $this->store_image_service = new StoreImage();
    }
    public function index(Request $request)
    {
        $docs = ImageModel::get();
        return ApiResponse::returnListContent($docs);
    }
    public function store(Request $request)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $this->image_extension = $request->file('image')->getClientOriginalExtension();
            $this->image_orginal_name = $request->file('image')->getClientOriginalName();



            return $this->storeImage('file', $request->file('image'));
        } elseif ($this->isBase64Valid($request->get('image'))) {

            $regex = "/data:image\/(?<extension>\w+);/";
            preg_match($regex, $request->get('image'), $result);
            $this->image_extension = $result['extension'];
            $this->image_orginal_name = 'unnamed';

            return $this->storeImage('base64', $request->get('image'));
        }

        return response()->json(['message' => 'Formato de imagem inválido.'], 422);
    }

    private function isBase64Valid($string)
    {
        return (bool) preg_match("/data:\w+\/\w+;base64,/", $string);
    }

    private function storeImage($type, $image)
    {
        $image_name = "{$this->image_name}.{$this->image_extension}";
        $image_path = "{$this->drive}/{$image_name}";

        try {
            if ($type === 'file') {
                $this->store_image_service->storeFile($image, $this->drive, $image_name);
            }
            if ($type === 'base64') {
                $this->store_image_service->storeBase64($image, $this->drive, $image_name);
            }
            /// resize
            $imgExt = explode('.', $image_name);
            $allowExt = array('png', 'jpg', 'jpeg');

            // TODO: FIX RESIZE FUNCTION
            // if (in_array($imgExt[1], $allowExt)) {

            //     $img = Image::make(sprintf('uploads/images/%s', $image_name))
            //         ->resize(900, null, function ($constraint) {
            //             $constraint->aspectRatio();
            //         });
            //     $img->save($image_path);
            // }
            // salvar no banc
            $image = ImageModel::create([
                'path' => $image_path,
                'original_name' => $this->image_orginal_name,
            ]);
            $image->url = url($image->path);


            return response()->json(compact('image'), 200);
        } catch (\Throwable $th) {
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            return response()->json(['message' => 'Erro ao salvar imagem'], 422);
        }
    }
}
