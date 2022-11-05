<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BestProductResource;
use App\Http\Resources\BrandsResource;
use App\Http\Resources\SaleProductResource;
use App\Models\Banner;
use App\Models\News;
use App\Models\Product;
use App\Models\Category;
use App\Models\StaticSeo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Size;
use App\Models\SizeItems;
use App\Models\AboutUsBlock;
use App\Models\Article;
use App\Models\Instum;
use App\Models\Brand;
use Laravel\Sanctum\PersonalAccessToken;

class HomePageApiController extends Controller
{
    public function homePage(Request $request)
    {
        $lang = request('lang');

        $data['slider'] = Slider::select('sliders.id', 'sliders.url', 'sliders.image', 'sliders.image_mobile', 'sliders.created_at')
            ->latest()->get();

        $data['products']['new'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->where('products.new', 1)
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.main_image', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.stock', 'products.created_at')
            ->orderBy('menu_position', 'ASC')
            ->get();

        foreach ($data['products']['new'] as $item) {
            $item['size_type'] = Size::join('translates as c_title', 'c_title.id', 'sizes.title')
                ->where('sizes.id', $item->size_id)
                ->select('sizes.id', 'c_title.' . $lang . ' as title', 'sizes.created_at')
                ->orderBy('title', 'ASC')->get();

            foreach ($item['size_type'] as $items) {
                $item['size_items'] = SizeItems::join('translates as f_title', 'f_title.id', 'size_items.title')
                    ->join('p_s_relations', 'size_items.id', 'p_s_relations.size_item_id')
                    ->where('p_s_relations.product_id', $item->id)
                    ->where('size_items.size_id', $items->id)
                    ->select('size_items.id', 'f_title.' . $lang . ' as title')
                    ->get();
            }
        }

        $data['products']['best'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->where('products.best', 1)
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.main_image', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.stock', 'products.created_at')
            ->orderBy('menu_position', 'ASC')
            ->get();
        // foreach ($data['products']['best'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }
        foreach ($data['products']['best'] as $item) {
            $item['size_type'] = Size::join('translates as c_title', 'c_title.id', 'sizes.title')
                ->where('sizes.id', $item->size_id)
                ->select('sizes.id', 'c_title.' . $lang . ' as title', 'sizes.created_at')
                ->orderBy('title', 'ASC')->get();

            foreach ($item['size_type'] as $items) {
                $item['size_items'] = SizeItems::join('translates as f_title', 'f_title.id', 'size_items.title')
                    ->join('p_s_relations', 'size_items.id', 'p_s_relations.size_item_id')
                    ->where('p_s_relations.product_id', $item->id)
                    ->where('size_items.size_id', $items->id)
                    ->select('size_items.id', 'f_title.' . $lang . ' as title')
                    ->get();
            }
        }

        $data['products']['sale'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->where('products.stock', '1')
            ->whereNotNull('products.sale')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.size_id', 'products.main_image', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.stock', 'products.created_at')
            ->orderBy('menu_position', 'ASC')
            ->get();
        // foreach ($data['products']['sale'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }
        foreach ($data['products']['sale'] as $item) {
            $item['size_type'] = Size::join('translates as c_title', 'c_title.id', 'sizes.title')
                ->where('sizes.id', $item->size_id)
                ->select('sizes.id', 'c_title.' . $lang . ' as title', 'sizes.created_at')
                ->orderBy('title', 'ASC')->get();

            foreach ($item['size_type'] as $items) {
                // $item['size_items'] = SizeItems::join('translates as c_title', 'c_title.id', 'sizes.title')
                // ->where('sizes.id', $item->size_id)
                // ->select('sizes.id','c_title.'.$lang.' as title','sizes.created_at')
                // ->orderBy('title', 'ASC')->get();
                $item['size_items'] = SizeItems::join('translates as f_title', 'f_title.id', 'size_items.title')
                    ->join('p_s_relations', 'size_items.id', 'p_s_relations.size_item_id')
                    ->where('p_s_relations.product_id', $item->id)
                    ->where('size_items.size_id', $items->id)
                    ->select('size_items.id', 'f_title.' . $lang . ' as title')
                    //->distinct()
                    ->get();
            }
        }
        $data['products']['soon'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->where('products.stock', '2')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.slug', 'products.main_image', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.stock', 'products.created_at')
            ->orderBy('menu_position', 'ASC')
            ->get();
        // foreach ($data['products']['soon'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }

        // $data['banners'] = AboutUsBlock::where('slug','banner')
        // ->join('translates as title', 'title.id', 'about_us_blocks.title')
        // ->join('translates as description', 'description.id', 'about_us_blocks.description')
        // ->select('about_us_blocks.id','title.'.$lang.' as title','description.'.$lang.' as description','about_us_blocks.image','about_us_blocks.image_mobile','about_us_blocks.url','about_us_blocks.created_at')
        // ->latest()->first();

        $data['banners'] = Banner::join('translates as c_title', 'c_title.id', 'banners.title')
            ->join('translates as description', 'description.id', 'banners.description')
            ->select('banners.id', 'banners.link', 'banners.image_desktop', 'banners.image_mobile', 'banners.created_at', 'c_title.' . $lang . ' as title', 'description.' . $lang . ' as description')
            ->latest()->first();

        $data['brands'] = Brand::join('translates as c_title', 'c_title.id', 'brands.title')
            ->select('brands.id', 'c_title.' . $lang . ' as title', 'brands.slug', 'brands.image')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->where('categories.position', '1')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.image', 'categories.slug', 'categories.created_at')
            ->limit(3)->orderBy('menu_position', 'ASC')->get();

        $data['insta'] = Instum::select('instas.id', 'instas.image', 'instas.link', 'instas.created_at')
            ->limit(4)->get();


        $data['article'] = Article::join('translates as title', 'title.id', 'articles.title')
            ->join('translates as description', 'description.id', 'articles.description')
            ->select('articles.id', 'title.' . $lang . ' as title', 'description.' . $lang . ' as description', 'articles.image', 'articles.created_at')
            ->get();


        $data['page_meta'] = StaticSeo::where('static_seos.page', 'home')->join('translates as title', 'title.id', 'static_seos.meta_title')->join('translates as description', 'description.id', 'static_seos.meta_title')
            ->select('static_seos.id', 'title.' . $lang . ' as meta_title', 'description.' . $lang . ' as meta_description', 'static_seos.created_at')->first();

        return response()->json($data);
    }

    public function page(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $lang = $request->lang;

        $data['slider'] = Slider::join('translates as title', 'title.id', 'sliders.title')->join('translates as content', 'content.id', 'sliders.content')
            ->select('sliders.id', 'sliders.url', 'sliders.image', 'sliders.image_mobile', 'sliders.created_at', 'title.' . $lang . ' as title', 'content.' . $lang . ' as content')
            ->latest()->get();

        $data['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->whereNull('categories.parent_id')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at', 'categories.image')
            ->orderBy('menu_position', 'ASC')
            ->get();

//        $data['products']['best'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
//            ->join('brands', 'brands.id', 'products.brand_id')
//            ->join('translates as b_title', 'b_title.id', 'brands.title')
//            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
//            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
//            ->where('products.best', 1)
//            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.main_image', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.stock', 'products.created_at')
//            ->orderBy('menu_position', 'ASC')
//            ->get();

//        $data['products']['sale'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
//            ->join('brands', 'brands.id', 'products.brand_id')
//            ->join('translates as b_title', 'b_title.id', 'brands.title')
//            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
//            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
//            ->where('products.stock', '1')
//            ->whereNotNull('products.sale')
//            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.size_id', 'products.main_image', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.stock', 'products.created_at')
//            ->orderBy('menu_position', 'ASC')
//            ->get();

        $data['products']['best'] = BestProductResource::collection(Product::where('products.best', 1)->orderBy('menu_position', 'ASC')->get());

        $data['products']['sale'] = SaleProductResource::collection(Product::where('products.new', 1)->orderBy('menu_position', 'ASC')->get());

        $data['brands'] = Brand::join('translates as c_title', 'c_title.id', 'brands.title')
            ->select('brands.id', 'c_title.' . $lang . ' as title', 'brands.slug', 'brands.image')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['news'] = News::join('translates as title', 'title.id', 'news.title')->join('translates as desc', 'desc.id', 'news.description')
            ->select('news.id', 'news.image', 'news.shows', 'news.created_at', 'title.' . $lang . ' as title', 'desc.' . $lang . ' as description')
            ->get();


        return response()->json([
            'data' => $data,
        ]);
    }

    public function brands(Request $request)
    {
        $request->validate([
            'lang'  =>  'required',
        ]);

        return response()->json([
            'data'  =>  BrandsResource::collection(Brand::get())
        ]);
    }

}
