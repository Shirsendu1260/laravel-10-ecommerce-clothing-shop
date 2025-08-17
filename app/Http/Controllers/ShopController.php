<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $category_slug = null) {
        $category_selected = null;
        $sort_by_selected = null;
        // $selected_sizes = [];
        $brands_array = [];
        $min_price = !empty($request->query("min")) ? $request->query("min") : 0;
        $max_price = !empty($request->query("max")) ? $request->query("max") : 20000;

        // Show highest rated products by default
        $products = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('product_ratings', 'product_ratings.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                'products.slug',
                'products.price',
                'products.actual_price',
                'categories.name as category',
                'categories.slug as category_slug',
                'brands.name as brand',
                'brands.slug as brand_slug',
                'products.is_featured',
                'products.is_in_stock',
                'products.qty',
                'products.status',
                'products.created_at',
                'products.updated_at',
                DB::raw('COALESCE(AVG(product_ratings.rating), 0) AS avg_rating') // 0 instead of null for products with no ratings
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.sku',
                'products.slug',
                'products.price',
                'products.actual_price',
                'categories.name',
                'categories.slug',
                'brands.name',
                'brands.slug',
                'products.is_featured',
                'products.is_in_stock',
                'products.qty',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->where('products.status', 1)
            ->orderBy('avg_rating', 'DESC');

        // Filter products based on category
        if(!empty($category_slug)) {
            $products = $products->where('categories.slug', $category_slug);
            $category_selected = $category_slug;
        }

        // Filter products based on brands
        if(!empty($request->query('brands')) && ($request->query('brands') != '')) {
            $brands_array = explode('--', $request->query('brands'));
            $products = $products->whereIn('brands.slug', $brands_array);
        }

        // Filter products based on available sizes
        if (!empty($request->query('sizes')) && ($request->query('sizes') != '')) {
            $selected_sizes = explode('--', $request->query('sizes'));
            $products = $products->where(function ($query) use ($selected_sizes) {
                foreach ($selected_sizes as $size) {
                    $query->orWhere('available_sizes', 'like', '%' . $size . '%');
                }
            });
        }

        // Filter products based on minimum and maximum price
        $products = $products->whereBetween('products.price', [$min_price, $max_price]);

        // Apply sorting
        if(!empty($request->query('sort_by')) && ($request->query('sort_by') != '')) {
            switch ($request->query('sort_by')) {
                case 'featured':
                    $products = $products->where('products.is_featured', 1);
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'best_selling':
                    $products = $products->orderBy('avg_rating', 'DESC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'a_to_z':
                    $products = $products->orderBy('products.name', 'ASC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'z_to_a':
                    $products = $products->orderBy('products.name', 'DESC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'low_to_high':
                    $products = $products->orderBy('products.price', 'ASC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'high_to_low':
                    $products = $products->orderBy('products.price', 'DESC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'old_to_new':
                    $products = $products->orderBy('products.updated_at', 'ASC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                case 'new_to_old':
                    $products = $products->orderBy('products.updated_at', 'DESC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
                default:
                    $products = $products->orderBy('avg_rating', 'DESC');
                    $sort_by_selected = $request->query('sort_by');
                    break;
            }
        }

        $products = $products->paginate(perPage: 6);
        $products_has_more_pages = $products->hasMorePages();
        // dd($products);

        // Handling AJAX request for filtration/search/load more pagination
        if($request->ajax()) {
            $products_html = view('user.main.products-con', compact('products'))->render();

            return response()->json([
                'status' => true,
                'products_html' => $products_html,
                'products_has_more_pages' => $products_has_more_pages,
            ]);
        }

        $categories = DB::table('categories')
                            ->where('status', 1)
                            ->orderBy('name', 'ASC')
                            ->get();
        $brands = DB::table('brands')
                        ->join('products', 'brands.id', '=', 'products.brand_id')
                        ->where('brands.status', 1)
                        ->where('products.status', 1)
                        ->orderBy('brands.name', 'ASC')
                        ->select('brands.id', 'brands.name', 'brands.slug', 'brands.image', 'brands.status', DB::raw('COUNT(products.id) AS products_count'))
                        ->groupBy('brands.id', 'brands.name', 'brands.slug', 'brands.image', 'brands.status')
                        ->get();

        // dd($brands);
        // dd($brands_array);

        return view('user.main.shop', compact('products', 'categories', 'brands', 'category_selected', 'sort_by_selected', 'brands_array', 'min_price', 'max_price', 'products_has_more_pages'));
    }
}
