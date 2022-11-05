<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AboutUsBlockResource;
use App\Http\Resources\BrandsResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ReviewResource;
use App\Models\AboutUsBlock;
use App\Models\City;
use App\Models\Contacts;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Filter;
use App\Models\Product;
use App\Models\ProductFilterRelations;
use App\Models\Review;
use App\Models\StaticSeo;
use App\Models\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MainBlocksApiController extends Controller
{
    public function getHeader(Request $request)
    {
        $lang = request('lang');

        $data['cities'] = City::join('translates as c_title', 'c_title.id', 'cities.title')
            ->select('cities.id', 'c_title.' . $lang . ' as title')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['brands'] = Brand::join('translates as c_title', 'c_title.id', 'brands.title')
            ->select('brands.id', 'c_title.' . $lang . ' as title', 'brands.slug', 'brands.image', 'brands.meta_title', 'brands.meta_description')
            ->distinct()
            ->orderBy('title')
            ->get();


        $data['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->whereNull('categories.parent_id')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
            ->orderBy('menu_position', 'ASC')
            ->limit(11)
            ->get();

        foreach ($data['categories'] as $item) {
            $item['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
                ->where('categories.parent_id', $item->id)
                ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->orderBy('title', 'ASC')->get();
        }
        //->select('contacts.id', 'c_title.'.$lang.' as title', 'c_description.'.$lang.' as description', 'c_title.'.$lang.' as description', 'c_address.'.$lang.' as address', 'phone_number');
        return response()->json($data);
    }

    public function getFooter(Request $request)
    {
        $lang = request('lang');
        $data['contacts'] = Contacts::select('contacts.id', 'contacts.phone_number', 'contacts.whats_app', 'contacts.telegram', 'contacts.instagram', 'contacts.vk', 'contacts.facebook', 'contacts.created_at', 'contacts.meta_title', 'contacts.meta_description')
            ->orderBy('contacts.id', 'DESC')->first();
        $data['contacts']->phone_number = unserialize($data['contacts']->phone_number);
        if ($data['contacts']->meta_title != NULL) {
            $data['page_meta']['title'] = Contacts::where('contacts.id', $data['contacts']->id)
                ->join('translates as meta_title', 'meta_title.id', 'contacts.meta_title')
                ->select('meta_title.' . $lang . ' as meta_title')
                ->first();
        } else {
            $data['page_meta']['title'] = NULL;
        }
        if ($data['contacts']->meta_description != NULL) {
            $data['page_meta']['description'] = Contacts::where('contacts.id', $data['contacts']->id)
                ->join('translates as meta_description', 'meta_description.id', 'contacts.meta_description')
                ->select('meta_description.' . $lang . ' as meta_description')
                ->first();
        } else {
            $data['page_meta']['description'] = NULL;
        }

        $data['page_meta'] = StaticSeo::where('static_seos.page', 'contacts')->join('translates as title', 'title.id', 'static_seos.meta_title')->join('translates as description', 'description.id', 'static_seos.meta_title')
            ->select('static_seos.id', 'title.' . $lang . ' as meta_title', 'description.' . $lang . ' as meta_description', 'static_seos.created_at')->first();
        return response()->json($data);
    }

    public function mail(Request $request)
    {
        $requestData = $request->all();

        $mail = new Mail();
        $mail->title = $requestData['title'];

        if ($mail->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function categories(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $lang = $request->lang;
        $categories = Category::whereNull('categories.parent_id')->orderBy('menu_position', 'ASC')->get();

        return response()->json([
            'data' => CategoryResource::collection($categories)
        ]);
    }

    public function products(Request $request)
    {
        if (count($request['category_id']) == 1) {
            $category = Category::where('id', $request['category_id'][0])->first();
            if ($category->parent_id == null) {
                $subCats = $category->getChilds->pluck('id')->toArray();
                $products = Product::whereIn('category_id', $subCats)->orderBy('created_at', 'desc')->get();
                if ($request['filter_id']) {
                    foreach ($request['filter_id'] as $item) {
                        $filterProducts = ProductFilterRelations::where('filter_item_id', $item)->pluck('product_id')->toArray();
                        $products = $products->whereIn('id', $filterProducts);
                    }
                }
                if ($request['brand_id']) {
                    $products = $products->whereIn('brand_id', $request['brand_id']);
                }
                $collection = ProductsResource::collection($products);
                $paginator = $this->paginate($collection);

                return response()->json([
                    'data' => $paginator,
                ]);
            }
        }

        $products = Product::orderBy('created_at', 'desc')->get();
        if ($request['category_id']) {
            $products = $products->whereIn('category_id', $request['category_id']);
        }
        if ($request['filter_id']) {
            foreach ($request['filter_id'] as $item) {
                $filterProducts = ProductFilterRelations::where('filter_item_id', $item)->pluck('product_id')->toArray();
                $products = $products->whereIn('id', $filterProducts);
            }
        }
        if ($request['brand_id']) {
            $products = $products->whereIn('brand_id', $request['brand_id']);
        }
        $collection = ProductsResource::collection($products);
        $paginator = $this->paginate($collection);

        return response()->json([
            'data' => $paginator,
        ]);
    }

    public function product(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ], [
            'products.exists' => 'Продукта не существует'
        ]);
        $lang = $request->lang;
        $product = Product::find($request['product_id']);
        $reviews = Review::where('product_id', $request['product_id'])->get();
        $delivery = AboutUsBlock::where('slug', 'delivery')->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
            ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
            ->select('about_us_blocks.id', 'c_description.' . $lang . ' as description', 'c_title.' . $lang . ' as title')
            ->first();
        $payment = AboutUsBlock::where('slug', 'payment')->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
            ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
            ->select('about_us_blocks.id', 'c_description.' . $lang . ' as description', 'c_title.' . $lang . ' as title')
            ->first();
        $sumRating = Review::where('product_id', $request['product_id'])->sum('rating');

        return response()->json([
            'data' => new ProductResource($product),
            'characteristics' => [],
            'reviews' => ReviewResource::collection($reviews),
            'payment' => $payment,
            'delivery' => $delivery,
            'rating' => count($reviews) > 0 ? $sumRating / count($reviews) : 0,
        ]);
    }

    public function productBySlug(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:products,slug'
        ], [
            'slug.exists' => 'Продукта не существует'
        ]);
        $lang = $request->lang;
        $product = Product::where('slug', $request['slug'])->first();
        $reviews = Review::where('product_id', $product->id)->get();
        $delivery = AboutUsBlock::where('slug', 'delivery')->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
            ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
            ->select('about_us_blocks.id', 'c_description.' . $lang . ' as description', 'c_title.' . $lang . ' as title')
            ->first();
        $payment = AboutUsBlock::where('slug', 'payment')->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
            ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
            ->select('about_us_blocks.id', 'c_description.' . $lang . ' as description', 'c_title.' . $lang . ' as title')
            ->first();
        $sumRating = Review::where('product_id', $request['product_id'])->sum('rating');

        return response()->json([
            'data' => new ProductResource($product),
            'characteristics' => [],
            'reviews' => ReviewResource::collection($reviews),
            'payment' => $payment,
            'delivery' => $delivery,
            'rating' => count($reviews) > 0 ? $sumRating / count($reviews) : 0,
        ]);
    }

    public function bySlug(Request $request)
    {
        $request->validate([
            'slug' => 'required',
        ]);
        $slugs = AboutUsBlock::pluck('slug')->toArray();
        if (!in_array($request['slug'], $slugs)) {
            return response()->json([
                'message' => 'Неправильный slug'
            ], 400);
        }
        $page = AboutUsBlock::where('slug', $request['slug'])->get();

        return response()->json([
            'data' => AboutUsBlockResource::collection($page),
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 12, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
