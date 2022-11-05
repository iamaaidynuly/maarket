<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quantity;
use App\Models\ColorRelations;
use App\Models\ProductSizeRelations;
use Illuminate\Http\Request;

class MyScriptController extends Controller
{
   public function run(Request $request)
   {
      $products = Product::all();
      foreach ($products as $product) {
         $colors = ColorRelations::where('product_id', $product->id)->get();
         
         $sizes = ProductSizeRelations::where('product_id', $product->id)->get();
         foreach ($colors as $color) {
            foreach ($sizes as $size) {
               $quantity = new Quantity();
               $quantity->product_id = $product->id;
               $quantity->color_id = $color->color_id;
               $quantity->size_id = $size->size_item_id;
               $quantity->quantity = 2;
               echo $product->id . " ---> " . $color->color_id . " ---> " .
               $size->size_item_id . "<br>";
               $quantity->save();
            }
         }
      }
      
   }
}