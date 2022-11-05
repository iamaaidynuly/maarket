<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\BrandItems;
use App\Models\Review;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\StaticSeo;
use App\Models\FilterItems;
use App\Models\Filter;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductFilterRelations;
use App\Models\CategoryFilterRelations;
use App\Models\Promocode;
use App\Models\User;
use App\Models\HistPromo;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\SizeItems;
use App\Models\Color;
use App\Models\ColorRelations;
use App\Models\AboutUsBlock;
use App\Models\Quantity;

class ProductsApiController extends Controller
{
    public function new()
    {
        $lang = request('lang');

        $data['products'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.price', 'products.sale', 'products.current_price', 'products.slug', 'products.created_at')
            ->limit(12)->latest()->get();
        foreach ($data['products'] as $item) {
            $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        }

        return response()->json($data);
    }

    public function sale()
    {
        $lang = request('lang');


        $data['products'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->whereNotNull('products.sale')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.price', 'products.sale', 'products.current_price', 'products.slug', 'products.created_at')
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
        $slug = request('slug');
        if (isset($requestData['order_by'])) {
            if ($requestData['order_by'] == 'top') {
                $type = 'products.best';
                $order_by = 'DESC'; //ask
            } elseif ($requestData['order_by'] == 'sale') {
                $type = 'sale'; //$type = 'products.id';
                $order_by = 'DESC';
            } else {
                $type = 'products.current_price';
                $order_by = $requestData['order_by']; //ask
            }
        } else {
            $type = 'menu_position'; //$type = 'products.id';
            $order_by = 'ASC';
        }

        $category = Category::where('slug', $slug)->first();

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
            $data['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
                ->where('categories.parent_id', $category->parent_id)
                ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->orderBy('title', 'ASC')->get();
        }


        $check_child = Category::where('parent_id', $category->id)->first();
        if ($check_child) {
            $data['subcategories'] = Category::join('translates as c_title', 'c_title.id', 'categories.title')
                ->where('categories.parent_id', $category->id)
                ->select('categories.id', 'c_title.' . $lang . ' as title', 'categories.slug', 'categories.created_at')
                ->orderBy('title', 'ASC')->get();
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
                ->orWhere('products.country_id', $category->id);
        }

        $data['filters'] = $builder->join('translates as f_title', 'f_title.id', 'filters.title')
            ->select('filters.id', 'f_title.' . $lang . ' as title')
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
                $build_filter->where('products.category_id', $category->id);
            }

            $item['filter_items'] = $build_filter->select('filter_items.id', 'f_title.' . $lang . ' as title')
                ->orderBy('title')
                ->distinct()
                ->get();
        }

        // $data['brands'] = $builder_brands->join('translates as b_title', 'b_title.id', 'brands.title')
        // ->select('brands.id','b_title.'.$lang.' as title')
        // ->distinct()
        // ->orderBy('title')
        // ->get();

        // $data['countries'] = $builder_countries->join('translates as c_title', 'c_title.id', 'countries.title')
        // ->select('countries.id','c_title.'.$lang.' as title')
        // ->distinct()
        // ->orderBy('title')
        // ->get();

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
        // if(request('country_id')){
        //     $builder->whereIn('brand_id', $requestData['country_id']);
        // }
        // if(request('filter_id')){
        //     $filter_items = explode(",", request('filter_id'));
        //     //dd($filter_items);
        //     //dd(gettype(request('filter_id')));
        //     $filters = ProductFilterRelations::whereIn('p_f_relations.filter_item_id', $filter_items)->select('product_id')->get()->toArray();
        //     $builder->whereIn('products.id', $filters);
        // }
        if ($requestData['filter_id'][0] != '[]') {
            $filter_items = explode(",", $requestData['filter_id'][0]);
            //dd(ProductFilterRelations::where('p_f_relations.filter_item_id', '5')->select('p_f_relations.product_id')->get());
            //$builder_filt = ProductFilterRelations::whereNotNull('id');
            if (count($filter_items) > 1) {
                $test = ProductFilterRelations::where('p_f_relations.filter_item_id', trim($filter_items[0], '['))->select('p_f_relations.product_id', 'p_f_relations.filter_item_id')->distinct()->get();
                $arr = array();
                //$arr = '';
                foreach ($test as $item2) {
                    foreach ($filter_items as $item) {
                        $item = trim($item, '[');
                        $item = trim($item, ']');
                        if ($item2->filter_item_id != $item) {
                            //dd($item2->product_id, '   ',$item);
                            //$tt = ProductFilterRelations::where('p_f_relations.filter_item_id', $item)->where('p_f_relations.product_id',$item2->product_id)->select('p_f_relations.product_id')->distinct()->first();
                            if (ProductFilterRelations::where('p_f_relations.filter_item_id', $item)->where('p_f_relations.product_id', $item2->product_id)->select('p_f_relations.product_id')->distinct()->get()->toArray() != null) {
                                array_push($arr, $item2->product_id);
                            }
                            //dd($arr);
                        }
                    }

                    // dd($builder_filt->select('p_f_relations.product_id')->distinct()->get()->toArray());
                }
                //$filters = $builder_filt->select('p_f_relations.product_id')->distinct()->get()->toArray();
                //$filters = ProductFilterRelations::whereIn('filter_item_id', $filter_items)->select('product_id')->distinct()->get()->toArray();
                $builder->whereIn('products.id', $arr);
            } else {
                //dd($filter_items[0]);
                $filter_items = trim($filter_items[0], '[');
                $filter_items = trim($filter_items, ']');
                //dd($filter_items);
                $filters = ProductFilterRelations::where('filter_item_id', $filter_items)->select('product_id')->distinct()->get()->toArray();
                $builder->whereIn('products.id', $filters);
            }
        }
        // if(isset($requestData['from'])){
        //     $builder->whereBetween('current_price', [$requestData['from'],$requestData['to']]);
        // }

        // if (isset($requestData['order_by'])) {
        //     if ($requestData['order_by'] == 'sale') {
        //         $builder->where('sale', '>', 0);
        //     }
        // }

        $data['products'] = $builder->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.slug', 'products.current_price', 'products.sale', 'products.new', 'products.new', 'products.best', 'products.size_id', 'products.main_image', 'products.created_at', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title')
            ->orderBy($type, $order_by)
            ->paginate(12)->withQueryString();
        // foreach ($data['products'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }

        foreach ($data['products'] as $item) {
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

            $item['colors'] = Color::join('translates as title', 'title.id', 'colors.title')
                ->join('color_relations', 'colors.id', 'color_relations.color_id')
                ->where('color_relations.product_id', $item->id)
                ->select('colors.id', 'title.' . $lang . ' as title', 'colors.code')->get();


            $item['quantity'] = Quantity::where('product_id', $item->id)->select('id', 'product_id', 'color_id', 'size_id', 'quantity')->get();
        }

        // $data['max'] = Product::where('category_id', $category->id)->max('current_price');
        // $data['min'] = Product::where('category_id', $category->id)->min('current_price');

        $data['recomend_products'] = Product::where('category_id', $category->id)
            //->where('products.id','<>', $data['products']->id)
            ->join('translates as p_title', 'p_title.id', 'products.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.size_id', 'products.main_image', 'products.stock', 'products.created_at')
            ->inRandomOrder()->limit(8)->get();
        foreach ($data['recomend_products'] as $item) {
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

        $data['filters'] = ProductFilterRelations::join('products', 'products.id', 'p_f_relations.product_id')->join('filter_items', 'filter_items.id', 'p_f_relations.filter_item_id')
            ->join('filters', 'filters.id', 'filter_items.filter_id')
            ->join('translates as f_title', 'f_title.id', 'filters.title')
            ->where('products.brand_id', $id)
            //->orderBy('filters.position', 'ASC')
            ->select('filters.id', 'f_title.' . $lang . ' as title')
            ->distinct()
            ->get();

        foreach ($data['filters'] as $item) {
            $item['filter_items'] = FilterItems::where('filter_id', $item->id)
                ->join('translates as f_title', 'f_title.id', 'filter_items.title')
                ->select('filter_items.id', 'f_title.' . $lang . ' as title')
                //->orderBy('position', 'ASC')
                ->get();
        }

        $builder = Product::where('products.brand_id', $id);

        if ($requestData['filter_id'][0] != '[]') {
            $filter_items = explode(",", $requestData['filter_id'][0]);
            if (count($filter_items) > 1) {
                $test = ProductFilterRelations::where('p_f_relations.filter_item_id', trim($filter_items[0], '['))->select('p_f_relations.product_id', 'p_f_relations.filter_item_id')->distinct()->get();
                $arr = array();
                foreach ($test as $item2) {
                    foreach ($filter_items as $item) {
                        $item = trim($item, '[');
                        $item = trim($item, ']');
                        if ($item2->filter_item_id != $item) {
                            if (ProductFilterRelations::where('p_f_relations.filter_item_id', $item)->where('p_f_relations.product_id', $item2->product_id)->select('p_f_relations.product_id')->distinct()->get()->toArray() != null) {
                                array_push($arr, $item2->product_id);
                            }
                        }
                    }
                }
                $builder->whereIn('products.id', $arr);
            } else {
                $filter_items = trim($filter_items[0], '[');
                $filter_items = trim($filter_items[0], ']');
                $filters = ProductFilterRelations::where('filter_item_id', 5)->select('product_id')->distinct()->get()->toArray();
                $builder->whereIn('products.id', $filters);
            }
        }
        $data['products'] = $builder->join('translates as p_title', 'p_title.id', 'products.title')
            //->join('translates as short_description', 'short_description.id', 'products.short_description')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.slug', 'products.price', 'products.current_price', 'products.sale', 'products.created_at', 'products.main_image', 'brands.id as brand_id', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title')
            ->orderBy($type, $order_by)
            ->paginate(12)->withQueryString();

        // foreach ($data['products'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }
        $data['brand'] = Brand::join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('translates as content', 'content.id', 'brands.content')
            ->where('brands.id', $id)
            ->select('brands.id', 'b_title.' . $lang . ' as title', 'content.' . $lang . ' as content', 'brands.image', 'brands.table_size')
            ->first();

        $data['brand']['collections'] = BrandItems::where('brand_id', $data['brand']->id)
            ->join('translates as title', 'title.id', 'brand_items.title')
            ->select('brand_items.id', 'title.' . $lang . ' as title')->get();

        return response()->json($data);
    }

    public function getSale(Request $request)
    {
        $lang = request('lang');
        $data['sale'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->whereNotNull('products.sale')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.size_id', 'products.main_image', 'products.created_at')
            ->get();
        // foreach ($data['sale'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }
        foreach ($data['sale'] as $item) {
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
        return response()->json($data);
    }

    public function getNew(Request $request)
    {
        $lang = request('lang');
        $data['new'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
            ->where('products.new', 1)
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'products.slug', 'products.main_image', 'products.created_at')
            ->get();
        // foreach ($data['new'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }
        foreach ($data['new'] as $item) {
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
        return response()->json($data);
    }

    public function product(Request $request)
    {
        $lang = request('lang');
        $data['product'] = Product::where('products.slug', request('slug'))
            ->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as p_description', 'p_description.id', 'products.description')
            ->join('translates as p_specifications', 'p_specifications.id', 'products.specifications')
            ->join('translates as brand_name', 'brand_name.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->select(
                'products.id',
                'p_title.' . $lang . ' as title',
                'p_description.' . $lang . ' as description',
                'p_specifications.' . $lang . ' as specifications',
                'products.slug as product_slug',
                'products.price',
                'products.current_price',
                'products.sale',
                'products.created_at',
                'products.category_id',
                'products.stock',
                'products.artikul',
                'brand_name.' . $lang . ' as brand_name',
                'brands.slug as brand_slug',
                'brands.table_size as table_size',
                'b_i_title.' . $lang . ' as collection_title',
                'products.size_id',
                'products.main_image',
                'products.meta_title',
                'products.meta_description'
            )->first();

        $data['colors'] = Color::join('translates as title', 'title.id', 'colors.title')
            ->join('color_relations', 'colors.id', 'color_relations.color_id')
            ->where('color_relations.product_id', $data['product']->id)
            ->select('colors.id', 'title.' . $lang . ' as title', 'colors.code')->get();

        $data['size_type'] = Size::join('translates as c_title', 'c_title.id', 'sizes.title')
            ->where('sizes.id', $data['product']->size_id)
            ->select('sizes.id', 'c_title.' . $lang . ' as title', 'sizes.created_at')
            ->orderBy('title', 'ASC')->get();

        $data['quantity'] = Quantity::join('size_items as s', 's.id', 'quantity.size_id')
            ->join('translates as t', 's.title', 't.id')
            ->join('colors as с', 'с.id', 'quantity.color_id')
            ->join('translates as tr', 'с.title', 'tr.id')
            ->where('product_id', $data['product']->id)->select('quantity.id', 'color_id', 'tr.' . $lang . ' as color_title', 'quantity.size_id', 't.' . $lang . ' as size_title', 'quantity')->orderBy('size_title', 'ASC')->get();

        foreach ($data['size_type'] as $items) {
            $items['size_items'] = SizeItems::join('translates as f_title', 'f_title.id', 'size_items.title')
                ->join('p_s_relations', 'size_items.id', 'p_s_relations.size_item_id')
                ->where('p_s_relations.product_id', $data['product']->id)
                ->where('size_items.size_id', $items->id)
                ->select('size_items.id', 'f_title.' . $lang . ' as title')
                ->orderBy('title', 'ASC')
                //->distinct()
                ->get();

            $items['size_items_all'] = SizeItems::join('translates as f_title', 'f_title.id', 'size_items.title')
                ->where('size_items.size_id', $items->id)
                ->select('size_items.id', 'f_title.' . $lang . ' as title')
                //->distinct()
                ->orderBy('title', 'ASC')
                ->get();
        }


        // $data['rating'] = Product::select(DB::raw('avg(reviews.rating) AS average'))
        // ->join('reviews', 'reviews.product_id', 'products.id')
        // ->where('products.id', $data['product']->id)
        // ->first();

        // if ($data['product']->meta_title != NULL) {
        //     $data['page_meta']['title'] = Product::where('products.id', $data['product']->id)
        //     ->join('translates as meta_title', 'meta_title.id', 'products.meta_title')
        //     ->select('meta_title.'.$lang.' as meta_title')
        //     ->first();


        // }else{
        //     $data['page_meta']['title'] = NULL;
        // }
        // if ($data['product']->meta_description != NULL) {
        //     $data['page_meta']['description'] = Product::where('products.id', $data['product'])
        //     ->join('translates as meta_description', 'meta_description.id', 'products.meta_description')
        //     ->select('meta_description.'.$lang.' as meta_description')
        //     ->first();
        // }else{
        //     $data['page_meta']['description'] = NULL;
        // }

        $data['product']['product_images'] = ProductImages::where('product_id', $data['product']->id)->select('image')->get();

        $data['delivery'] = AboutUsBlock::where('slug', 'delivery')->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
            ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
            ->select('about_us_blocks.id', 'c_description.' . $lang . ' as description', 'c_title.' . $lang . ' as title')->first();

        $data['payment'] = AboutUsBlock::where('slug', 'payment')->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
            ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
            ->select('about_us_blocks.id', 'c_description.' . $lang . ' as description', 'c_title.' . $lang . ' as title')->first();

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
        $data['review'] = Review::where('reviews.product_id', $data['product']->id)
            ->select('reviews.id', 'reviews.name', 'reviews.review', 'reviews.rating', 'reviews.created_at')->get();

        $data['recomend_products'] = Product::where('category_id', $data['product']->category_id)
            ->where('products.id', '<>', $data['product']->id)
            ->join('translates as p_title', 'p_title.id', 'products.title')
            ->join('brands', 'brands.id', 'products.brand_id')
            ->join('translates as b_title', 'b_title.id', 'brands.title')
            ->join('brand_items', 'brand_items.id', 'products.brand_items_id')
            ->join('translates as b_i_title', 'b_i_title.id', 'brand_items.title')
            ->select('products.id', 'p_title.' . $lang . ' as title', 'products.current_price', 'products.sale', 'brands.id as brand_id', 'b_title.' . $lang . ' as brand_title', 'b_i_title.' . $lang . ' as collection_title', 'products.slug', 'products.main_image', 'products.created_at')
            ->inRandomOrder()->limit(8)->get();

        // foreach ($data['recomend_products'] as $item) {
        //     $item['images'] = ProductImages::where('product_id', $item->id)->select('image')->first();
        // }
        // $data['reviews'] = Review::where('product_id', $data['product']->id)
        // ->select('reviews.id as review_id','reviews.name','reviews.review','reviews.rating','reviews.created_at')
        // ->limit(10)
        // ->get();

        return response()->json($data);
    }

    // public function review(Request $request)
    // {
    //     $requestData = $request->all();

    //     $review = new Review();
    //     $review->name = $requestData['name'];
    //     $review->review = $requestData['review'];
    //     $review->rating = $requestData['rating'];
    //     $review->product_id = $requestData['product_id'];
    //     $review->user_id = $requestData['user_id'];
    //     if($review->save()){
    //         $data['reviews'] = Review::where('product_id', $requestData['product_id'])
    //         ->select('reviews.id as review_id','reviews.name','reviews.review','reviews.rating','reviews.created_at')
    //         //->limit(10)
    //         ->get();
    //         return response()->json($data);
    //     }else{
    //         return false;
    //     }
    // }

    public function search(Request $request)
    {
        $keyword = request('text');
        $lang = request('lang');
        $keyword2 = request('text2');
        if ($keyword2 == '') {
            $keyword2 = $keyword;
        }
        $keyword3 = request('text3');
        if ($keyword3 == '') {
            $keyword3 = $keyword;
        }
        if ($keyword) {
            $data['products'] = Product::join('translates as p_title', 'p_title.id', 'products.title')
                ->join('translates as p_description', 'p_description.id', 'products.description')
                ->join('brands', 'brands.id', 'products.brand_id')
                ->join('translates as b_title', 'b_title.id', 'brands.title')
                ->where('p_title.' . $lang, 'LIKE', '%' . $keyword . '%')
                ->orWhere('p_description.' . $lang, 'LIKE', '%' . $keyword . '%')
                ->orWhere('p_title.' . $lang, 'LIKE', '%' . $keyword2 . '%')
                ->orWhere('p_description.' . $lang, 'LIKE', '%' . $keyword2 . '%')
                ->orWhere('p_title.' . $lang, 'LIKE', '%' . $keyword3 . '%')
                ->orWhere('p_description.' . $lang, 'LIKE', '%' . $keyword3 . '%')
                ->select('products.*')
                ->orderBy('title', 'ASC')
                ->paginate(12)->withQueryString();
            $data['products'] = ProductResource::collection($data['products']);
//            foreach ($data['products'] as $items) {
//                $items['collections'] = BrandItems::where('brand_id', $items->brand_id)
//                    ->join('translates as title', 'title.id', 'brand_items.title')
//                    ->select('brand_items.id', 'title.' . $lang . ' as title')->get();
//            }

            return response()->json($data);
        }
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

    // public function checkCode(Request $request)
    // {
    //     $requestData = $request->all();
    //     $code = $request->input('code');
    //     //$user = auth()->user();
    //     $user = User::where('id', $requestData['user_id'])->first();
    //     if($user){
    //         $ckech = Promocode::where('code', $code)->where('user_id',$user->id)->whereNull('active')->first();
    //         //$hist_promo = HistPromo::where('code_id',$ckech->id)->where('user_id',$user->id)->first();
    //         $sysdate = Carbon::now();
    //         if($ckech->exp_date<$sysdate){
    //             return response()->json('Время промокода истекло!', 404);
    //         }
    //         else{
    //             return response()->json($ckech, 200);
    //         }
    //     }
    //     else{
    //         $ckech = Promocode::where('code', $code)->whereNull('user_id')->whereNull('active')->first();
    //     }

    //     if($ckech){
    //         return response()->json($ckech, 200);
    //     }else{
    //         return response()->json('Not found', 400);
    //     }
    // }
    public function checkCode(Request $request)
    {
        $requestData = $request->all();
        $code = $request->input('code');
        //$user = User::where('id', $requestData['user_id'])->first();

        $ckech = Promocode::where('code', $code)->whereNull('active')->first();
        $sysdate = Carbon::now();
        if ($ckech->exp_date < $sysdate) {
            return response()->json('Время промокода истекло!', 404);
        } else {
            return response()->json($ckech, 200);
        }

        if ($ckech) {
            return response()->json($ckech, 200);
        } else {
            return response()->json('Not found', 400);
        }
    }
}
