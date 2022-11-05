<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandsResource;
use App\Http\Resources\FilterResource;
use App\Models\AboutUsBlock;
use App\Models\Address;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Certificate;
use App\Models\City;
use App\Models\Country;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Funds;
use App\Models\News;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Region;
use App\Models\SalesBlock;
use App\Models\Slider;
use App\Models\Contacts;
use App\Models\ProductFilterRelations;
use App\Models\CategoryFilterRelations;
use App\Models\Feedback;
use App\Models\Filter;
use App\Models\FilterItems;
use App\Models\Order;
use App\Models\StaticSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use function Sodium\add;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
        $token = Str::random(80);

        $request->user()->forceFill([
            'token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }

    public function getHeader(Request $request)
    {
        $lang = request('lang');

        $data['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->whereNull('categories.parent_id')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
            ->orderBy('menu_position', 'ASC')
            ->get();
        foreach ($data['categories'] as $item) {
            $item['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
                ->where('categories.parent_id', $item->id)
                ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->orderBy('title', 'ASC')->get();
        }
        $data['contacts'] = Contacts::select('contacts.id', 'phone_number', 'contacts.created_at')
            ->orderBy('contacts.id', 'DESC')->first();
        //->select('contacts.id', 'c_title.'.$lang.' as title', 'c_description.'.$lang.' as description', 'c_title.'.$lang.' as description', 'c_address.'.$lang.' as address', 'phone_number');
        $data['contacts']->phone_number = unserialize($data['contacts']->phone_number);
        return response()->json($data);
    }

    public function getFooter(Request $request)
    {
        $lang = request('lang');
        $data['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->whereNull('categories.parent_id')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
            ->orderBy('title', 'ASC')
            ->get();

        $data['contacts'] = Contacts::join('translates as c_title', 'c_title.id', 'contacts.title')
            ->join('translates as c_description', 'c_description.id', 'contacts.description')
            ->join('translates as c_address', 'c_address.id', 'contacts.address')
            ->select('contacts.id', 'phone_number', 'contacts.created_at', 'c_address.' . $lang . ' as address', 'email', 'whats_app', 'telegram', 'instagram')
            ->orderBy('contacts.id', 'DESC')->first();
        //->select('contacts.id', 'c_title.'.$lang.' as title', 'c_description.'.$lang.' as description', 'c_title.'.$lang.' as description', 'c_address.'.$lang.' as address', 'phone_number')
        $data['contacts']->phone_number = unserialize($data['contacts']->phone_number);
        return response()->json($data);
    }

    public function homePage(Request $request)
    {
        $lang = request('lang');
        $data['header']['categories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->whereNull('categories.parent_id')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
            ->orderBy('title', 'ASC')
            ->get();
        foreach ($data['header']['categories'] as $item) {
            $item['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
                ->where('categories.parent_id', $item->id)
                ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->orderBy('title', 'ASC')->get();
        }
        // $data['header']['brands'] = Brand::join('translates as brand', 'brand.id', 'brands.title')
        // ->select('brands.id','brand.'.$lang.' as title',)
        // ->orderBy('title', 'ASC')
        // ->get();
        $data['slider'] = Slider::join('translates as s_title', 's_title.id', 'sliders.title')
            ->join('translates as s_content', 's_content.id', 'sliders.content')
            ->join('translates as s_url', 's_url.id', 'sliders.url')
            ->select('sliders.id', 's_title.' . $lang . ' as title', 's_content.' . $lang . ' as content', 's_url.' . $lang . ' as url', 'sliders.image', 'sliders.created_at')
            ->latest()->get();

        $data['categories']['category_top'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->where('categories.position', 'top')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.image', 'categories.slug', 'categories.created_at')
            ->limit(2)->orderBy('menu_position', 'ASC')->get();

        $data['categories']['category_bottom'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
            ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.image', 'categories.slug', 'categories.created_at')
            ->where('position', 'bottom')->limit(3)->orderBy('menu_position', 'ASC')->get();

        $data['products']['new'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.price', 'products.current_price', 'products.sale', 'products.slug', 'products.created_at')
            ->limit(8)->latest()->get();
        foreach ($data['products']['new'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        $data['products']['best'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->where('products.best', 1)
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.price', 'products.current_price', 'products.sale', 'products.slug', 'products.created_at')
            ->limit(4)->get();
        foreach ($data['products']['best'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        $data['block_sales'] = SalesBlock::where('sales_blocks.status', 1)
            ->join('translates as sales_title', 'sales_title.id', 'sales_blocks.title')
            ->join('translates as sales_content', 'sales_content.id', 'sales_blocks.content')
            ->join('translates as sales_url', 'sales_url.id', 'sales_blocks.url')
            ->select('sales_blocks.id', 'sales_title.' . $lang . ' as title', 'sales_content.' . $lang . ' as content', 'sales_url.' . $lang . ' as url', 'sales_blocks.image', 'sales_blocks.created_at')
            ->latest()->get();

        $data['block_blog'] = Blog::join('translates as blog_title', 'blog_title.id', 'blogs.title')
            ->join('translates as blog_content', 'blog_content.id', 'blogs.content')
            ->select('blogs.id', 'blog_title.' . $lang . ' as title', 'blog_content.' . $lang . ' as content', 'blogs.image', 'blogs.slug', 'blogs.created_at')
            ->latest()->first();

        $data['page_meta'] = StaticSeo::where('static_seos.page', 'home')->join('translates as title', 'title.id', 'static_seos.meta_title')->join('translates as description', 'description.id', 'static_seos.meta_title')
            ->select('static_seos.id', 'title.' . $lang . ' as meta_title', 'description.' . $lang . ' as meta_description', 'static_seos.created_at')->first();

        return response()->json($data);
    }

    public function search(Request $request)
    {
        $keyword = request('text');
        $lang = request('lang');

        $data = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as brands_title', 'brands_title.id', 'brands.title')
            ->where('p_title.' . $lang, 'LIKE', '%' . $keyword . '%')
            ->orWhere('brands_title.' . $lang, 'LIKE', '%' . $keyword . '%')
            ->orWhere('p_description.' . $lang, 'LIKE', '%' . $keyword . '%')
            ->select('p_title.' . $lang . ' as title', 'products.slug', 'products.current_price', 'products.sale', 'products.created_at')
            ->orderBy('title', 'ASC')
            ->paginate(12)->withQueryString();

        return response()->json($data);
    }

    public function searchPage(Request $request)
    {
        $requestData = $request->all();
        $keyword = request('text');
        $lang = request('lang');
        if (isset($requestData['order_by'])) {
            $type = 'products.current_price';
            $order_by = $requestData['order_by'];
        } else {
            $type = 'products.id';
            $order_by = 'DESC';
        }
        $products_id = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as brands_title', 'brands_title.id', 'brands.title')
            ->where('p_title.' . $lang, 'LIKE', '%' . $keyword . '%')
            ->orWhere('brands_title.' . $lang, 'LIKE', '%' . $keyword . '%')
            ->orWhere('p_description.' . $lang, 'LIKE', '%' . $keyword . '%')
            ->select('products.id')
            ->get()->toArray();

        $data['brands'] = Brand::join('products', 'products.brand_id', 'brands.id')
            ->whereIn('products.id', $products_id)
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->select('brands.id', 'b_title.' . $lang . ' as title')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['countries'] = Country::join('products', 'products.country_id', 'countries.id')
            ->whereIn('products.id', $products_id)
            ->join('translates as c_title', 'c_title.id', 'countries.title')
            ->select('countries.id', 'c_title.' . $lang . ' as title')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['filters'] = Filter::join('translates as f_title', 'f_title.id', 'filters.title')
            ->join('filter_items', 'filter_items.filter_id', 'filters.id')
            ->join('p_f_relations', 'filter_items.id', 'p_f_relations.filter_item_id')
            ->whereIn('p_f_relations.product_id', $products_id)
            ->select('filters.id', 'f_title.' . $lang . ' as title', 'filters.position')
            ->orderBy('filters.position', 'ASC')
            ->distinct()
            ->get();

        foreach ($data['filters'] as $item) {
            $build_filter = FilterItems::where('filter_id', $item->id)
                ->join('translates as f_title', 'f_title.id', 'filter_items.title')
                ->join('p_f_relations', 'p_f_relations.filter_item_id', 'filter_items.id')
                ->join('products', 'products.id', 'p_f_relations.product_id')
                ->whereIn('p_f_relations.product_id', $products_id);

            $item['filter_items'] = $build_filter->select('filter_items.id', 'f_title.' . $lang . ' as title', 'filter_items.position')
                ->orderBy('position', 'ASC')
                ->distinct()
                ->get();
        }
        $builder = Product::whereIn('products.id', $products_id)->join('translates as p_title', 'p_title.id', 'products.title');
        if (request('brand_id')) {
            $builder->whereIn('products.brand_id', request('brand_id'));
        }
        if (request('country_id')) {
            $builder->whereIn('products.country_id', $requestData['country_id']);
        }
        if (request('filter_id')) {
            $filters = ProductFilterRelations::whereIn('filter_item_id', $requestData['filter_id'])->select('product_id')->get()->toArray();

            $builder->whereIn('products.id', $filters);
        }
        $data['products'] = Product::whereIn('products.id', $products_id)->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.slug', 'products.price', 'products.current_price', 'products.sale', 'products.created_at')
            ->orderBy($type, $order_by)
            ->paginate(12)->withQueryString();
        foreach ($data['products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        return response()->json($data);
    }

    public function getProducts(Request $request)
    {
        $requestData = $request->all();
        $lang = request('lang');
        $id = request('category_id');
        if (isset($requestData['order_by'])) {
            $type = 'products.current_price';
            $order_by = $requestData['order_by'];
        } else {
            $type = 'products.id';
            $order_by = 'DESC';
        }

        $category = Category::where('id', $id)->first();

        $data['category'] = Category::where('categories.id', $category->id)
            ->join('translates as c_title', 'c_title.id', 'categories.title')
            ->select('categories.id as category_id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.parent_id', 'categories.created_at', 'meta_title', 'meta_description')
            ->first();
        if ($data['category']->meta_title != NULL) {
            $data['page_meta']['title'] = Category::where('categories.id', $category->id)
                ->join('translates as meta_title', 'meta_title.id', 'categories.meta_title')
                ->select('meta_title.' . $lang . ' as meta_title')
                ->first();
        } else {
            $data['page_meta']['title'] = NULL;
        }
        if ($data['category']->meta_description != NULL) {
            $data['page_meta']['description'] = Category::where('categories.id', $category->id)
                ->join('translates as meta_description', 'meta_description.id', 'categories.meta_description')
                ->select('meta_description.' . $lang . ' as meta_description')
                ->first();
        } else {
            $data['page_meta']['description'] = NULL;
        }
        if ($data['category']->parent_id != NULL) {
            $data['category_parent'] = Category::where('categories.id', $data['category']->parent_id)
                ->join('translates as c_title', 'c_title.id', 'categories.title')
                ->select('categories.id as parent_id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->first();
        }

        $check_child = Category::where('parent_id', $category->id)->first();
        if ($check_child) {
            $sub_category = Category::where('parent_id', $category->id)->select('id')->get()->toArray();
            $builder = CategoryFilterRelations::whereIn('category_id', $sub_category)
                ->orWhere('category_id', $category->id)
                ->join('filters', 'c_f_relations.filter_id', 'filters.id');

            $builder_brands = Brand::join('products', 'products.brand_id', 'brands.id')
                ->whereIn('products.category_id', $sub_category)
                ->orWhere('products.category_id', $category->id);

            $builder_countries = Country::join('products', 'products.country_id', 'countries.id')
                ->whereIn('products.country_id', $sub_category)
                ->orWhere('products.country_id', $category->id);

        } else {
            $builder = CategoryFilterRelations::where('category_id', $category->id)->join('filters', 'c_f_relations.filter_id', 'filters.id');

            $builder_brands = Brand::join('products', 'products.brand_id', 'brands.id')
                ->orWhere('products.category_id', $category->id);

            $builder_countries = Country::join('products', 'products.country_id', 'countries.id')
                ->orWhere('products.category_id', $category->id);
        }

        $data['filters'] = $builder->join('translates as f_title', 'f_title.id', 'filters.title')
            ->select('filters.id', 'f_title.' . $lang . ' as title', 'filters.position')
            ->orderBy('position', 'ASC')
            ->distinct()
            ->get();
        foreach ($data['filters'] as $item) {
            $build_filter = FilterItems::where('filter_id', $item->id)
                ->join('translates as f_title', 'f_title.id', 'filter_items.title')
                ->join('p_f_relations', 'p_f_relations.filter_item_id', 'filter_items.id')
                ->join('products', 'products.id', 'p_f_relations.product_id');
            if ($check_child) {
                $build_filter->whereIn('products.category_id', $sub_category)
                    ->orWhere('products.category_id', $category->id);
            } else {
                $build_filter->where('products.country_id', $category->id);
            }

            $item['filter_items'] = $build_filter->select('filter_items.id', 'f_title.' . $lang . ' as title', 'filter_items.position')
                ->orderBy('position', 'ASC')
                ->distinct()
                ->get();
        }

        $data['brands'] = $builder_brands->join('translates as b_title', 'b_title.id', 'brands.title')
            ->select('brands.id', 'b_title.' . $lang . ' as title')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['countries'] = $builder_countries->join('translates as c_title', 'c_title.id', 'countries.title')
            ->select('countries.id', 'c_title.' . $lang . ' as title')
            ->distinct()
            ->orderBy('title')
            ->get();

        $check_product = Product::where('category_id', $category->id)->first();
        if ($check_product) {
            $builder = Product::where('category_id', $category->id);
        } else {
            $sub_category = Category::where('parent_id', $category->id)->select('id')->get()->toArray();
            $builder = Product::whereIn('category_id', $sub_category);
        }
        if (request('brand_id')) {
            $builder->whereIn('brand_id', request('brand_id'));
        }
        if (request('country_id')) {
            $builder->whereIn('country_id', $requestData['country_id']);
        }
        if (request('filter_id')) {
            $filters = ProductFilterRelations::whereIn('filter_item_id', $requestData['filter_id'])->select('product_id')->get()->toArray();

            $builder->whereIn('products.id', $filters);
        }
        $data['products'] = $builder->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.slug', 'products.price', 'products.current_price', 'products.sale', 'products.created_at')
            ->orderBy($type, $order_by)
            ->paginate(12)->withQueryString();
        foreach ($data['products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        return response()->json($data);
    }

    public function product(Request $request)
    {
        $lang = request('lang');
        $data['product'] = Product::where('products.slug', request('slug'))
            ->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as short_description', 'short_description.id', 'products.short_description')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->join('countries', 'countries.id', 'products.country_id')
            ->join('translates as country_name', 'country_name.id', 'countries.title')
            ->join('translates as brand_name', 'brand_name.id', 'brands.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'short_description.' . $lang . ' as short_description', 'p_description.' . $lang . ' as description', 'products.slug as product_slug', 'products.price', 'products.current_price', 'products.sale', 'products.created_at', 'products.category_id', 'products.stock', 'products.artikul', 'brand_name.' . $lang . ' as brand_name', 'country_name.' . $lang . ' as country_name', 'brands.slug as brand_slug', 'products.meta_title', 'products.meta_description')
            ->first();

        if ($data['product']->meta_title != NULL) {
            $data['page_meta']['title'] = Product::where('products.id', $data['product']->id)
                ->join('translates as meta_title', 'meta_title.id', 'products.meta_title')
                ->select('meta_title.' . $lang . ' as meta_title')
                ->first();

        } else {
            $data['page_meta']['title'] = NULL;
        }
        if ($data['product']->meta_description != NULL) {
            $data['page_meta']['description'] = Product::where('products.id', $data['product'])
                ->join('translates as meta_description', 'meta_description.id', 'products.meta_description')
                ->select('meta_description.' . $lang . ' as meta_description')
                ->first();
        } else {
            $data['page_meta']['description'] = NULL;
        }

        $data['product']['product_images'] = ProductImages::where('product_id', $data['product']->id)->select('image')->get();

        $data['category'] = Category::where('categories.id', $data['product']->category_id)
            ->join('translates as c_title', 'c_title.id', 'categories.title')
            ->select('categories.id as category_id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.parent_id', 'categories.created_at')
            ->first();

        if ($data['category']->parent_id != NULL) {
            $data['category_parent'] = Category::where('categories.id', $data['category']->parent_id)
                ->join('translates as c_title', 'c_title.id', 'categories.title')
                ->select('categories.id as parent_id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->first();
        }

        $data['recomend_products'] = Product::where('category_id', $data['product']->category_id)
            ->where('products.id', '<>', $data['product']->id)
            ->join('translates as p_title', 'p_title.id', 'products.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.created_at')
            ->inRandomOrder()->limit(8)->get();
        foreach ($data['recomend_products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->get();
        }

        return response()->json($data);
    }

    public function getBlogs(Request $request)
    {
        $lang = request('lang');
        $data['blogs'] = Blog::join('translates as blog_title', 'blog_title.id', 'blogs.title')
            ->join('translates as blog_content', 'blog_content.id', 'blogs.content')
            ->select('blogs.id', 'blog_title.' . $lang . ' as title', 'blogs.image', 'blogs.slug', 'blogs.created_at', 'blogs.updated_at')
            ->orderBy('blogs.updated_at', 'DESC')
            ->paginate(12)->withQueryString();

        $data['page_meta'] = StaticSeo::where('static_seos.page', 'blogs')->join('translates as title', 'title.id', 'static_seos.meta_title')->join('translates as description', 'description.id', 'static_seos.meta_title')
            ->select('static_seos.id', 'title.' . $lang . ' as meta_title', 'description.' . $lang . ' as meta_description', 'static_seos.created_at')->first();
        return response()->json($data);
    }

    public function getBlog(Request $request)
    {
        $lang = request('lang');
        $slug = request('slug');
        $data['blog'] = Blog::where('slug', $slug)->join('translates as blog_title', 'blog_title.id', 'blogs.title')
            ->join('translates as blog_content', 'blog_content.id', 'blogs.content')
            ->select('blogs.id', 'blog_title.' . $lang . ' as title', 'blog_content.' . $lang . ' as content', 'blogs.image', 'blogs.slug', 'blogs.created_at', 'blogs.meta_title', 'blogs.meta_description')
            ->first();

        if ($data['blog']->meta_title != NULL) {
            $data['page_meta']['title'] = Blog::where('blogs.id', $data['blog']->id)
                ->join('translates as meta_title', 'meta_title.id', 'blogs.meta_title')
                ->select('meta_title.' . $lang . ' as meta_title')
                ->first();
        } else {
            $data['page_meta']['title'] = NULL;
        }
        if ($data['blog']->meta_description != NULL) {
            $data['page_meta']['description'] = Blog::where('blogs.id', $data['blog']->id)
                ->join('translates as meta_description', 'meta_description.id', 'blogs.meta_description')
                ->select('meta_description.' . $lang . ' as meta_description')
                ->first();
        } else {
            $data['page_meta']['description'] = NULL;
        }

        $data['others'] = Blog::where('slug', '<>', $slug)->join('translates as blog_title', 'blog_title.id', 'blogs.title')
            ->join('translates as blog_content', 'blog_content.id', 'blogs.content')
            ->select('blogs.id', 'blog_title.' . $lang . ' as title', 'blogs.image', 'blogs.slug', 'blogs.created_at', 'blogs.updated_at')
            ->orderBy('blogs.updated_at', 'DESC')
            ->limit(3)->get();

        return response()->json($data);
    }

    public function getBrands(Request $request)
    {
        $lang = request('lang');
        $brand_letter = request('brand_letter');
        $arr_en = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $arr_EN = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $arr_num = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $data['popular'] = Brand::join('translates as b_title', 'b_title.id', 'brands.title')
            ->where('brands.popular', 1)
            ->select('brands.id', 'b_title.' . $lang . ' as title', 'brands.image', 'brands.slug')
            ->orderBy('b_title.' . $lang, 'ASC')
            ->limit(5)
            ->get()->toArray();
        if ($brand_letter) {
            $data['all'][$brand_letter] = Brand::join('translates as b_title', 'b_title.id', 'brands.title')
                ->where('b_title.' . $lang, 'LIKE', $brand_letter . '%')
                ->select('brands.id', 'b_title.' . $lang . ' as title', 'brands.slug')
                ->orderBy('b_title.' . $lang, 'ASC')
                ->get();
        } else {
            foreach ($arr_EN as $key => $value) {
                $data['all'][$value] = Brand::join('translates as b_title', 'b_title.id', 'brands.title')
                    ->where('b_title.' . $lang, 'LIKE', $value . '%')
                    ->orWhere('b_title.' . $lang, 'LIKE', $arr_en[$key] . '%')
                    ->select('brands.id', 'b_title.' . $lang . ' as title', 'brands.slug')
                    ->orderBy('b_title.' . $lang, 'ASC')
                    ->get()->toArray();
            }
            foreach ($arr_num as $key => $value) {
                $data['other'][$value] = Brand::join('translates as b_title', 'b_title.id', 'brands.title')
                    ->where('b_title.' . $lang, 'LIKE', $value . '%')
                    ->select('brands.id', 'b_title.' . $lang . ' as title', 'brands.slug')
                    ->orderBy('b_title.' . $lang, 'ASC')
                    ->get()->toArray();
            }
        }

        $data['page_meta'] = StaticSeo::where('static_seos.page', 'brands')->join('translates as title', 'title.id', 'static_seos.meta_title')->join('translates as description', 'description.id', 'static_seos.meta_title')
            ->select('static_seos.id', 'title.' . $lang . ' as meta_title', 'description.' . $lang . ' as meta_description', 'static_seos.created_at')->first();
        return response()->json($data);
    }

    public function getContacts(Request $request)
    {
        $lang = request('lang');

        $contact = Contacts::join('translates as title', 'title.id', 'contacts.title')->join('translates as description', 'description.id', 'contacts.description')
            ->join('translates as main_address', 'main_address.id', 'contacts.main_address')
            ->select('contacts.id', 'contacts.email', 'contacts.telegram', 'contacts.whats_app', 'contacts.instagram', 'contacts.vk', 'contacts.facebook', 'title.' . $lang . ' as title', 'description.' . $lang . ' as description', 'main_address.' . $lang . ' as main_address', 'contacts.vk', 'contacts.map', 'contacts.retail_sale', 'contacts.wholesale', 'contacts.facebook')
            ->first();
        $numbers = $this->getUnserialize(Contacts::first()->phone_number);
        $addresses = $this->getUnserialize(Contacts::first()->address);
        $arr = [];
        if (count($numbers) == count($addresses)) {
            for ($i = 0; $i < count($numbers); $i++) {
                $arr[$i] = [
                    'phone' => $numbers[$i],
                    'city' => $addresses[$i]
                ];
            }
        }

        return response()->json([
            'data' => $contact,
            'cities' => $arr,
        ]);
//        $data['contacts'] = Contacts::join('translates as c_title', 'c_title.id', 'contacts.title')
//            ->join('translates as c_description', 'c_description.id', 'contacts.description')
//            ->join('translates as c_address', 'c_address.id', 'contacts.address')
//            ->select('contacts.id', 'c_title.' . $lang . ' as title', 'c_description.' . $lang . ' as description', 'phone_number', 'c_address.' . $lang . ' as address', 'email', 'whats_app', 'telegram', 'instagram', 'contacts.created_at', 'contacts.meta_title', 'contacts.meta_description')
//            ->orderBy('contacts.id', 'DESC')
//            ->first();

//        if ($data['contacts']->meta_title != NULL) {
//            $data['page_meta']['title'] = Contacts::where('contacts.id', $data['contacts']->id)
//                ->join('translates as meta_title', 'meta_title.id', 'contacts.meta_title')
//                ->select('meta_title.' . $lang . ' as meta_title')
//                ->first();
//        } else {
//            $data['page_meta']['title'] = NULL;
//        }
//        if ($data['contacts']->meta_description != NULL) {
//            $data['page_meta']['description'] = Contacts::where('contacts.id', $data['contacts']->id)
//                ->join('translates as meta_description', 'meta_description.id', 'contacts.meta_description')
//                ->select('meta_description.' . $lang . ' as meta_description')
//                ->first();
//        } else {
//            $data['page_meta']['description'] = NULL;
//        }

//        $data['page_meta'] = StaticSeo::where('static_seos.page', 'contacts')->join('translates as title', 'title.id', 'static_seos.meta_title')->join('translates as description', 'description.id', 'static_seos.meta_title')
//            ->select('static_seos.id', 'title.' . $lang . ' as meta_title', 'description.' . $lang . ' as meta_description', 'static_seos.created_at')->first();

//        return response()->json($data);
    }

    public function callback(Request $request)
    {
        $requestData = $request->all();

        $feedback = new Feedback();
        $feedback->name = $requestData['formData']['name'];
        $feedback->phone_number = $requestData['formData']['phone'];
        $feedback->email = $requestData['formData']['email'];
        $feedback->comment = $requestData['formData']['comment'];
        if (isset($requestData['formData']['company'])) {
            $feedback->company = $requestData['formData']['company'];
        }

        if ($feedback->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function order(Request $request)
    {
        $requestData = $request->all();

        $order = new Order();
        $order->name = $requestData['formData']['name'];
        $order->phone = $requestData['formData']['phone'];
        $order->email = $requestData['formData']['email'];
        $order->comment = $requestData['formData']['comment'];
        $order->product_id = $requestData['formData']['product_id'];
        $order->count = $requestData['formData']['count'];

        if ($order->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function new()
    {
        $lang = request('lang');

        $data['products'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.price', 'products.current_price', 'products.sale', 'products.slug', 'products.created_at')
            ->limit(16)->latest()->get();
        foreach ($data['products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        return response()->json($data);
    }

    public function bestSeller()
    {
        $lang = request('lang');

        $data['products'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->where('products.best', 1)
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.price', 'products.current_price', 'products.sale', 'products.slug', 'products.created_at')
            ->limit(16)->latest()->get();
        foreach ($data['products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        return response()->json($data);
    }

    public function about()
    {
        $lang = request('lang');

        $data = AboutUsBlock::join('translates as content', 'content.id', 'about_us_blocks.content')
            ->select('about_us_blocks.id', 'content.' . $lang . ' as title', 'about_us_blocks.image', 'about_us_blocks.created_at')
            ->latest()->get();

        return response()->json($data);
    }

    public function getBrandProducts(Request $request)
    {
        $requestData = $request->all();
        $lang = request('lang');
        $id = request('brand_id');
        if (isset($requestData['order_by'])) {
            $type = 'products.current_price';
            $order_by = $requestData['order_by'];
        } else {
            $type = 'products.id';
            $order_by = 'DESC';
        }
        $data['countries'] = Country::join('products', 'countries.id', 'products.country_id')->join('translates as c_title', 'c_title.id', 'countries.title')
            ->where('products.brand_id', $id)
            ->select('countries.id', 'c_title.' . $lang . ' as title')
            ->distinct()
            ->orderBy('title')
            ->get();

        $data['filters'] = ProductFilterRelations::join('products', 'products.id', 'p_f_relations.product_id')->join('filter_items', 'filter_items.id', 'p_f_relations.filter_item_id')
            ->join('filters', 'filters.id', 'filter_items.filter_id')
            ->join('translates as f_title', 'f_title.id', 'filters.title')
            ->where('products.brand_id', $id)
            ->orderBy('filters.position', 'ASC')
            ->select('filters.id', 'f_title.' . $lang . ' as title', 'filters.position')
            ->distinct()
            ->get();
        foreach ($data['filters'] as $item) {
            $item['filter_items'] = FilterItems::where('filter_id', $item->id)
                ->join('translates as f_title', 'f_title.id', 'filter_items.title')
                ->select('filter_items.id', 'f_title.' . $lang . ' as title', 'filter_items.position')
                ->orderBy('position', 'ASC')
                ->get();
        }

        $builder = Product::where('brand_id', $id);

        if (request('country_id')) {
            $builder->whereIn('brand_id', $requestData['country_id']);
        }
        if (request('filter_id')) {
            $filters = ProductFilterRelations::whereIn('filter_item_id', $requestData['filter_id'])->select('product_id')->get()->toArray();
            $builder->whereIn('products.id', $filters);
        }
        $data['products'] = $builder->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.slug', 'products.price', 'products.current_price', 'products.sale', 'products.created_at')
            ->orderBy($type, $order_by)
            ->paginate(12)->withQueryString();
        foreach ($data['products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }
        $data['brand'] = Brand::join('translates as b_title', 'b_title.id', 'brands.title')
            ->where('brands.id', $id)
            ->select('brands.id', 'b_title.' . $lang . ' as title', 'brands.slug')
            ->first();
        return response()->json($data);
    }

    public function cardProduct(Request $request)
    {
        $requestData = $request->all();
        $lang = request('lang');
        $id = request('product_id');
        $data = Product::whereIn('products.id', $id)
            ->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'b_title.' . $lang . ' as brand_name', 'products.price', 'products.current_price as price', 'products.created_at')
            ->get();
        foreach ($data as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        return response()->json($data, 200);
    }

    public function news(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $news = News::join('translates as title', 'title.id', 'news.title')->join('translates as description', 'description.id', 'news.description')
            ->select('news.id', 'news.shows', 'news.image', 'news.created_at', 'title.' . $request->lang . ' as title', 'description.' . $request->lang . ' as description')
            ->get();

        return response()->json([
            'data' => $news
        ]);
    }

    public function newsById(Request $request)
    {
        $request->validate([
            'lang' => 'required',
            'news_id' => 'required|exists:news,id'
        ]);
        $news = News::join('translates as title', 'title.id', 'news.title')->join('translates as description', 'description.id', 'news.description')
            ->where('news.id', $request->news_id)
            ->select('news.id', 'news.shows', 'news.image', 'news.created_at', 'title.' . $request->lang . ' as title', 'description.' . $request->lang . ' as description')
            ->first();
        $news->fill([
            'shows' => $news->shows + 1
        ])->save();

        return response()->json([
            'data' => $news
        ]);
    }

    public function cities(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $cities = City::get();
        if ($request->region_id) {
            $cities = City::join('translates as title', 'title.id', 'cities.title')->where('region_id', $request->region_id)
                ->select('cities.id', 'cities.region_id', 'title.' . $request->lang . ' as title')->get();
        } else {
            $cities = City::join('translates as title', 'title.id', 'cities.title')
                ->select('cities.id', 'cities.region_id', 'title.' . $request->lang . ' as title')->get();
        }

        return response()->json([
            'data' => $cities
        ]);
    }

    public function regions(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $regions = Region::join('translates as title', 'title.id', 'regions.title')
            ->select('regions.id', 'title.' . $request->lang . ' as title')->get();

        return response()->json([
            'data' => $regions,
        ]);
    }

    public function addresses(Request $request)
    {
        $request->validate([
            'lang' => 'required',
        ]);
        $addresses = Address::get();

        return response()->json([
            'data' => AddressResource::collection($addresses),
        ]);
    }

    public function certificates(Request $request)
    {
        return response()->json([
            'data' => Certificate::get(),
        ]);
    }

    public function delivery(Request $request)
    {
        return response()->json([
            'price' => Delivery::first()->value('price'),
        ]);
    }

    public function filters(Request $request)
    {
        $request->validate([
            'lang'  =>  'required'
        ]);
        $filters = Filter::get();
        $brands = Brand::get();

        if ($request->category_id) {
            $categoryFilters = CategoryFilterRelations::whereIn('category_id', $request['category_id'])->pluck('filter_id')->toArray();
            $filters = $filters->whereIn('id', $categoryFilters);
            $products = Product::whereIn('category_id', $request['category_id'])->pluck('brand_id')->toArray();
            $brands = $brands->whereIn('id', $products);
        }

        return response()->json([
            'filters'  =>  FilterResource::collection($filters),
            'brands'    => count($brands) > 0 ? BrandResource::collection($brands) : BrandResource::collection(Brand::get())
        ]);
    }

    public function funds(Request $request)
    {
        if ($request->funds) {
            return response()->json([
                'funds' =>  Funds::find($request->funds),
            ]);
        }
        return response()->json([
            'funds' =>  Funds::get()
        ]);
    }

    public function login(Request $request)
    {
        return view('auth.login');
    }
}
