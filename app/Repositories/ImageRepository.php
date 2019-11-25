<?php
namespace App\Repositories;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageRepository
{
    public function saveImage($image)
    {
        if (!is_null($image))
        {
            foreach($image as $imagem){
                // dd($image);
                $file = $imagem;

                $extension = $imagem->getClientOriginalExtension();

                $fileName = time() . random_int(100, 999) .'.' . $extension;

                $destinationPath = public_path('images/');

                $fullPath = $destinationPath.$fileName;

                if (!file_exists($destinationPath)) {

                    File::makeDirectory($destinationPath, 0775);
                }

                $imagem = Image::make($file)->encode('jpg');

                $imagem->save($fullPath, 100);

                if(!empty($fileName))
                    return 'public/imagens/' . $fileName;
                else
                    return 'nome do arquivo vazio';
            }
        }else{
            return 'Imagem vazia';
        }
    }
}
