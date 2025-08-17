<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'A' && Auth::user()->status == '1') {
            return redirect()->route('admin_dashboard');
        }
        else if (Auth::check() && Auth::user()->role == 'U' && Auth::user()->status == '1') {
            if (session()->has('url.intended')) {
                session()->flash('success', "Welcome back! You're now logged in.");
                return redirect(session()->get('url.intended'));
            }
        }
        else if(Auth::check() && Auth::user()->status == '0') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'You are blocked from logging in to this website.');
        }

        $categories = DB::table('categories')->orderby('name', 'ASC')->where('status', 1)->get();

        $featured_products = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.sku',
                'products.slug',
                'products.price',
                'products.actual_price',
                'categories.name as category',
                'categories.slug as category_slug',
                'brands.name as brand',
                'products.is_featured',
                'products.is_in_stock',
                'products.qty',
                'products.updated_at',
                'products.status',
                'products.created_at',
                'products.updated_at',
            )
            ->where('products.status', 1)
            ->where('products.is_featured', 1)
            ->where('products.is_in_stock', 1)
            ->where('products.qty', '<>', 0);

        $summer_sale_products = DB::table('products')
                                ->select('id', 'name', 'image', 'qty', 'slug', 'price', 'actual_price', 'updated_at')
                                ->selectRaw('CAST(((actual_price - price) / actual_price) * 100 AS INT) AS discount')
                                ->where('actual_price', '<>', null)
                                ->whereRaw('CAST(((actual_price - price) / actual_price) * 100 AS INT) BETWEEN ? AND ?', [40, 55])
                                ->where('status', 1)
                                ->where('is_in_stock', 1)
                                ->where('qty', '<>', 0)
                                ->take(6)
                                ->orderByDesc('discount')
                                ->get();

        $slides = DB::table('slides')->where('status', '1')->take(3)->orderByDesc('id')->get();

        $featured_products = $featured_products->paginate(perPage: 4);

        // For AJAX request of loading more products
        if($request->ajax()) {
            $featured_products_html = view('user.main.products-home-con', compact('featured_products'))->render();

            return response()->json([
                'status' => true,
                'featured_products_html' => $featured_products_html,
                'featured_products_has_more_pages' => $featured_products->hasMorePages(),
            ]);
        }

        return view('user.index', compact('categories', 'featured_products', 'summer_sale_products', 'slides'));
    }

    public function search(Request $request) {
        $search_term = '%' . $request->search . '%';
        $searched_products = DB::table('products')
                                    ->join('categories', 'categories.id', '=', 'products.category_id')
                                    ->join('brands', 'brands.id', '=', 'products.brand_id')
                                    ->where(function ($query) use ($search_term) {
                                        $query->where('products.name', 'like', $search_term)
                                                ->orWhere('categories.name', 'like', $search_term)
                                                ->orWhere('brands.name', 'like', $search_term);
                                    })
                                    ->take(6)
                                    ->select('products.id', 'products.name', 'products.image', 'products.slug')
                                    ->get();

        return response()->json(['searched_products' => $searched_products]);
    }
}
