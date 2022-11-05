<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductFeature;
use App\Models\ProductPriceTypes;
use Carbon\Carbon;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter\AlignFormatter;
use Zip;
use App\Models\Image;
use App\Models\Product;
use App\Models\Translate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Imports\ProductImport;
use App\Models\ColorRelations;
use App\Models\SizeItems;
use App\Models\FiltersRelations;
use App\Models\ProductSizeRelations;
use App\Models\FeaturesRelations;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProductFilterRelations;
use Illuminate\Support\Facades\Storage;


class ImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx|max:20480',
        ], [
            'file.max' => 'Размер файла не может быть более 20 Мегабайтов.',
            'file.required' => 'Выберите файл.',
            'file.mimes' => 'Выберите файл excel'
        ]);

        $array = Excel::toArray(new ProductImport, request()->file('file'));
        $i = 0;
        $errors = 0;
        $articul = '';
        foreach ($array[0] as $item) {
            set_time_limit(30);
            $check_isset = Product::where('slug', Str::slug($item['naimenovanie_ru']))->first();
            try {
                if ($check_isset) {
                    if ($item['artikul'] != NULL) {
                        $check_isset->artikul = $item['artikul'];
                    }
                    if ($item['naimenovanie_ru'] != NULL) {
                        $title = Translate::where('id', $check_isset->title)->first();
                        $title->ru = $item['naimenovanie_ru'];
                        $title->en = $item['naimenovanie_en'];
                        $title->kz = $item['naimenovanie_kz'];
                        $title->update();
                    }
//                    if ($item['besceller'] != NULL) {
//                        $check_isset->best = intval($item['besceller']);
//                    }
                    if ($item['opisanie_ru'] != NULL) {
                        $description = Translate::where('id', $check_isset->description)->first();
                        $description->ru = $item['opisanie_ru'];
                        $description->en = $item['opisanie_en'];
                        $description->kz = $item['opisanie_kz'];
                        $description->update();
                    }
//                    if ($item['novoe_postuplenie'] != NULL) {
//                        $check_isset->new = $item['novoe_postuplenie'];
//                    }
                    if ($item['cena'] != NULL) {
                        $check_isset->price = $item['cena'];
                    }
                    if ($item['skidka'] != NULL) {
                        $check_isset->sale = $item['skidka'];
                    }
                    if ($item['skidka'] != NULL) {
                        $check_isset->current_price = (intval($item['cena']) * (100 - intval($item['skidka']))) / 100;
                    } else {
                        $check_isset->current_price = $item['cena'];
                    }
                    if ($item['id_brenda'] != NULL) {
                        $check_isset->brand_id = $item['id_brenda'];
                    }
                    if ($item['id_strany'] != NULL) {
                        $check_isset->country_id = $item['id_strany'];
                    }
                    if ($item['v_nalicii'] != NULL) {
                        $check_isset->stock = $item['v_nalicii'];
                    }
                    if ($item['id_kategorii'] != NULL) {
                        $check_isset->category_id = $item['id_kategorii'];
                    }

//                    if ($item['id_tip_razmera'] != NULL) {
//                        $check_isset->size_id = $item['id_tip_razmera'];
//                    }
                    if (ProductFeature::where('product_id', $check_isset->id)->exists()) {
                        $feature = ProductFeature::where('product_id', $check_isset->id)->first();
                        if (isset($feature->type)) {
                            Translate::find($feature->type)->update([
                                'ru' => $item['tip_ru'],
                                'kz' => $item['tip_kz'],
                                'en' => $item['tip_en'],
                            ]);
                        }
                        if (isset($feature->size)) {
                            Translate::find($feature->size)->update([
                                'ru' => $item['razmer_ru'],
                                'kz' => $item['razmer_kz'],
                                'en' => $item['razmer_en'],
                            ]);
                        }
                        if (isset($feature->purpose)) {
                            Translate::find($feature->purpose)->update([
                                'ru' => $item['naznacenie_ru'],
                                'kz' => $item['naznacenie_kz'],
                                'en' => $item['naznacenie_en'],
                            ]);
                        }
                        if (isset($feature->quantity)) {
                            Translate::find($feature->quantity)->update([
                                'ru' => $item['kolicestvo_ru'],
                                'kz' => $item['kolicestvo_kz'],
                                'en' => $item['kolicestvo_en'],
                            ]);
                        }
                    }
                    if (ProductPriceTypes::where('product_id', $check_isset->id)->exists()) {
                        $cena1 = ProductPriceTypes::where('product_id', $check_isset->id)->where('price_type_id', $item['cena_1_id'])->first();
                        $cena2 = ProductPriceTypes::where('product_id', $check_isset->id)->where('price_type_id', $item['cena_2_id'])->first();
                        $cena3 = ProductPriceTypes::where('product_id', $check_isset->id)->where('price_type_id', $item['cena_3_id'])->first();
                        $cena4 = ProductPriceTypes::where('product_id', $check_isset->id)->where('price_type_id', $item['cena_4_id'])->first();
                        $cena5 = ProductPriceTypes::where('product_id', $check_isset->id)->where('price_type_id', $item['cena_5_id'])->first();
                        if (isset($cena1)) {
                            $cena1->update([
                                'price' => $item['cena_1']
                            ]);
                        }
                        if (isset($cena2)) {
                            $cena2->update([
                                'price' => $item['cena_2']
                            ]);
                        }
                        if (isset($cena3)) {
                            $cena3->update([
                                'price' => $item['cena_3']
                            ]);
                        }
                        if (isset($cena4)) {
                            $cena4->update([
                                'price' => $item['cena_4']
                            ]);
                        }
                        if (isset($cena5)) {
                            $cena5->update([
                                'price' => $item['cena_5']
                            ]);
                        }
                    }
                    if ($check_isset->update()) {
                        if ($item['id_cveta'] != null) {
                            $colors = explode(";", $item['id_cveta']);
                            foreach ($colors as $key => $value) {
                                $relation = ColorRelations::where('product_id', $check_isset->id)->where('color_id', $value)->first();
                                $relation->product_id = $check_isset->id;
                                $relation->color_id = $value;
                                $relation->update();
                            }
                        }

                        if ($item['id_razmera'] != null) {
                            $size_items = explode(";", $item['id_razmera']);

                            foreach ($size_items as $key => $value) {
                                $size_relation = ProductSizeRelations::where('product_id', $check_isset->id)->where('size_item_id', $value)->first();
                                //$size_relation = new ProductSizeRelations();
                                $size_relation->product_id = $check_isset->id;
                                $size_relation->size_item_id = $value;
                                $size_relation->update();
                            }
                        }

                        if ($item['id_filtra'] != null) {
                            $filters = explode(";", $item['id_filtra']);

                            foreach ($filters as $key => $value) {
                                $filter_relation = ProductFilterRelations::where('product_id', $check_isset->id)->where('filter_item_id', $value)->first();
                                //$filter_relation = new ProductFilterRelations();
                                $filter_relation->product_id = $check_isset->id;
                                $filter_relation->filter_item_id = $value;
                                $filter_relation->update();
                            }
                        }
                    }
                } else {
                    $product = new Product();
                    if ($item['artikul'] != NULL) {
                        $product->artikul = $item['artikul'];
                    }
                    if ($item['naimenovanie_ru'] != NULL) {
                        $title = new Translate();
                        $title->ru = $item['naimenovanie_ru'];
                        $title->en = $item['naimenovanie_en'];
                        $title->kz = $item['naimenovanie_kz'];
                        $title->save();
                        $product->title = $title->id;
                    }
                    if ($item['opisanie_ru'] != NULL) {
                        $description = new Translate();
                        $description->ru = $item['opisanie_ru'];
                        $description->en = $item['opisanie_en'];
                        $description->kz = $item['opisanie_kz'];
                        $description->save();
                        $product->description = $description->id;
                    }

                    if ($item['cena'] != NULL) {
                        $product->price = $item['cena'];
                    }
                    if ($item['skidka'] != NULL) {
                        $product->sale = $item['skidka'];
                    }
                    if ($item['skidka'] != NULL) {
                        $product->current_price = (intval($item['cena']) * (100 - intval($item['skidka']))) / 100;
                    } else {
                        $product->current_price = $item['cena'];
                    }
                    if ($item['id_brenda'] != NULL) {
                        $product->brand_id = $item['id_brenda'];
                    }
                    if ($item['id_strany'] != NULL) {
                        $product->country_id = $item['id_strany'];
                    }
                    if ($item['v_nalicii'] != NULL) {
                        $product->stock = $item['v_nalicii'];
                    }
                    if ($item['id_kategorii'] != NULL) {
                        $product->category_id = $item['id_kategorii'];
                    }
                    $product->slug = Str::slug($item['naimenovanie_ru']);
                    if ($product->save()) {
//                        if ($item['id_cveta'] != null) {
//                            $colors = explode(";", $item['id_cveta']);
//                            foreach ($colors as $key => $value) {
//                                $relation = new ColorRelations();
//                                $relation->product_id = $product->id;
//                                $relation->color_id = $value;
//                                $relation->save();
//                            }
//                        }
//                        if ($item['id_razmera'] != null) {
//                            $size_items = explode(";", $item['id_razmera']);
//                            foreach ($size_items as $key => $value) {
//                                $size_relation = new ProductSizeRelations();
//                                $size_relation->product_id = $product->id;
//                                $size_relation->size_item_id = $value;
//                                $size_relation->save();
//                            }
//                        }
                        if ($item['tip_en'] != null && $item['tip_kz'] != null && $item['tip_ru'] != null) {
                            $type = Translate::create([
                                'ru' => $item['tip_ru'],
                                'kz' => $item['tip_kz'],
                                'en' => $item['tip_en'],
                            ]);
                        }
                        if ($item['razmer_ru'] != null && $item['razmer_kz'] != null && $item['razmer_en'] != null) {
                            $size = Translate::create([
                                'ru' => $item['razmer_ru'],
                                'kz' => $item['razmer_kz'],
                                'en' => $item['razmer_en'],
                            ]);
                        }
                        if ($item['naznacenie_ru'] != null && $item['naznacenie_kz'] != null && $item['naznacenie_en'] != null) {
                            $purpose = Translate::create([
                                'ru' => $item['naznacenie_ru'],
                                'kz' => $item['naznacenie_kz'],
                                'en' => $item['naznacenie_en'],
                            ]);
                        }
                        if ($item['kolicestvo_ru'] != null && $item['kolicestvo_kz'] != null && $item['kolicestvo_en'] != null) {
                            $quantity = Translate::create([
                                'ru' => $item['kolicestvo_ru'],
                                'kz' => $item['kolicestvo_kz'],
                                'en' => $item['kolicestvo_en'],
                            ]);
                        }
                        $feat = ProductFeature::create([
                            'product_id' => $product->id,
                            'type' => $type->id ?? null,
                            'size' => $size->id ?? null,
                            'quantity' => $quantity->id ?? null,
                            'purpose' => $purpose->id ?? null,
                            'created_at' => Carbon::now(),
                        ]);
                        ProductPriceTypes::insert([
                            'product_id' => $product->id,
                            'price_type_id' => $item['cena_1_id'],
                            'price' => $item['cena_1']
                        ]);
                        ProductPriceTypes::insert([
                            'product_id' => $product->id,
                            'price_type_id' => $item['cena_2_id'],
                            'price' => $item['cena_2']
                        ]);
                        ProductPriceTypes::insert([
                            'product_id' => $product->id,
                            'price_type_id' => $item['cena_3_id'],
                            'price' => $item['cena_3']
                        ]);
                        ProductPriceTypes::insert([
                            'product_id' => $product->id,
                            'price_type_id' => $item['cena_4_id'],
                            'price' => $item['cena_4']
                        ]);
                        ProductPriceTypes::insert([
                            'product_id' => $product->id,
                            'price_type_id' => $item['cena_5_id'],
                            'price' => $item['cena_5']
                        ]);
                    }
                    $filters = explode(";", $item['id_filtra']);

                    foreach ($filters as $key => $value) {
                        $filter_relation = new ProductFilterRelations();
                        $filter_relation->product_id = $product->id;
                        $filter_relation->filter_item_id = $value;
                        $filter_relation->save();
                    }

                }
                $i++;
            } catch (\Exception $e) {
                //return back()->with('success', $e);
                $errors++;
                $articul = $articul . ', ' . $item['artikul'];
            }
        }

        return redirect('/admin/product')->with('success', 'Файл успешно импортирован! Загружено ' . $i . ', не загужено ' . $errors . '(' . $articul . ')');
    }

    public function importZip(Request $request)
    {

        if ($request->post()) {
            $request->validate([
                'file' => 'required|file|mimes:zip|max:20480',
            ], [
                'file.max' => 'Размер файла не может быть более 20 Мегабайтов.',
                'file.required' => 'Выберите файл.',
                'file.mimes' => 'Выберите файл zip'
            ]);

            $uploadedFilePath = $request->file('file')->getRealPath();
            if (!Zip::check($uploadedFilePath)) {
                return redirect()->back()->withErrors(['file' => 'Недействительный ZIP']);
            }


            $zip = Zip::open($uploadedFilePath);
            $zipContent = $zip->listFiles();

            $files = [];
            $allFiles = [];
            $codes = [];
            $mot_product = '';
            $data['changed_count'] = 0;
            foreach ($zipContent as $file) {
                set_time_limit(10);

                $zip->setMask(0755);

                if (Str::contains('/', $file) || !preg_match('/\.[a-z]+$/', $file)) continue;

                $array = explode('.', $file);
                $ext = end($array);

                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
//                    $code = preg_replace('/(-[0-9]+)?(\.[a-z]+$)/', '', $file);
                    $code = preg_replace('/_.*/s', '', $file);
                    $storagePath = Storage::disk('static')->getDriver()->getAdapter()->getPathPrefix();
                    $zip->extract($storagePath, $file);
                    $ext = preg_replace('/^.*\.([^.]+)$/', '$1', $file);

                    $product = Product::where('artikul', $code)->first();
                    if (isset($product)) {
                        $filename = "product/" . $product->slug . "/" . Str::random(28) . '.' . $ext;
                        ////$filename = $storagePath . "/product/test".$product->slug.'/'.Str::random(28).'.'.$ext;
                        //$filename = $storagePath . "/product/test".$product->slug.'/'.Str::random(28).'.'.$ext;
                        //if(!File::has($storagePath . "/product"."/".$product->slug)){
                        File::makeDirectory($storagePath . "/product/" . $product->slug, 0755, true, true);
                        //}
                        //dd('done');
                        //rename($storagePath . $file, $storagePath . "product/".$product->slug.'/'.$filename);
                        if ($product) {
                            //rename($storagePath . $file, $storagePath);
                            /////rename($storagePath . $file, $storagePath . "/product"."/".$product->slug.'/'. $filename);
                            rename($storagePath . $file, $storagePath . "/" . $filename);
                            //Storage::move($storagePath . $file, $storagePath . "/product/test/" . $filename);
                            $item = new ProductImages();
                            $item->product_id = $product->id;
                            $item->image = $filename;
                            $item->save();
                            $data['changed_count']++;
                        } else {
                            $mot_product .= $code . ', ';
                        }
                    } else {
                        return redirect()->back()->with('success', 'Неверный артикул!');
                    }
                }
            }
            $mot_product = mb_substr($mot_product, 0, -2);
        }

        return redirect()->back()->with('success', 'Загружено ' . $data['changed_count'] . ' изображения из ' . count($zipContent) . '. Несоответствующие изображения: ' . $mot_product);
    }
}
