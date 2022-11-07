<?php
namespace App\Service;

use App\Models\Translate;

class TranslateService
{
    public function translateCreate($data)
    {
        return Translate::create([
            'ru'    =>  $data['ru'],
            'kz'    =>  $data['kz'],
            'en'    =>  $data['en'],
        ]);
    }

    public function translateUpdate($id, $data)
    {
        return Translate::find($id)->update([
            'ru'    =>  $data['ru'],
            'kz'    =>  $data['kz'],
            'en'    =>  $data['en'],
        ]);
    }
}
