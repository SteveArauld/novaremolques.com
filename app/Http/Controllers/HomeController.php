<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{

    public function index()
    {
        $dernieresTondeuses = Product::with(['categories', 'images'])
            ->whereHas('categories', function ($query) {
                $query->whereIn('categories.id', [1, 2]);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $dernieresRemorques = Product::with(['categories', 'images'])
            ->whereHas('categories', function ($query) {
                $query->where('name->fr', 'LIKE', '%remorque%')
                    ->orWhere('name->es', 'LIKE', '%remolque%')
                    ->orWhere('name->it', 'LIKE', '%rimorchio%');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('front.home', compact('dernieresTondeuses', 'dernieresRemorques'));
    }

    public function showProduct($slug, Request $request)
    {
        $locale = app()->getLocale();

        $article = Product::with(['categories', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $imagesCount = $article->images->count();

        $relatedArticles = Product::with(['images'])
            ->whereHas('categories', function ($query) use ($article) {
                $categoryIds = $article->categories->pluck('id')->toArray();
                $query->whereIn('categories.id', $categoryIds);
            })
            ->where('products.id', '!=', $article->id)
            ->limit(8)
            ->get();

        // Liste complète des pays
        $countries = $this->getCountriesList();

        return view('front.product.show', compact('article', 'relatedArticles', 'imagesCount', 'countries'));
    }

    public function sendInquiry(Request $request, $id)
    {
        $article = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'country' => 'required|string|max:10',
            'region' => 'required|string|max:100',
            'message' => 'required|string',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $request->quantity ?? 1;

        try {
            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'region' => $request->region,
                'product_name' => $article->name,
                'product_id' => $article->id,
                'quantity' => $quantity,
                'inquiry_message' => $request->message,
                'product_url' => route('product.show', [$article->slug]),
                'order_number' => 'INQ-' . date('Ymd') . '-' . rand(1000, 9999)
            ];

            // Email pour l'admin
            Mail::send('emails.product-inquiry', $details, function ($message) use ($details) {
                $message->to(config('mail.admin_address', 'contact@portaboxsolutions.com'))
                    ->subject(__('email.inquiry_admin_subject', ['product' => $details['product_name']]))
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($details['email'], $details['name']);
            });

            // Email de confirmation pour le client
            Mail::send('emails.inquiry-confirmation', $details, function ($message) use ($details) {
                $message->to($details['email'], $details['name'])
                    ->subject(__('email.inquiry_confirmation_subject', ['product' => $details['product_name']]))
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return response()->json([
                'success' => true,
                'message' => __('product.inquiry.success')
            ]);
        } catch (Exception $e) {
            Log::error('Erreur demande: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('product.inquiry.error')
            ], 500);
        }
    }

    public function showShop(Request $request, $category = null)
    {
        $locale = app()->getLocale();
        $sort = $request->get('sort', 'default');
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search_Prin');

        $categories = Category::all();

        $query = Product::with(['categories', 'images']);

        if ($category) {
            $query->whereHas('categories', function ($q) use ($category, $locale) {
                $q->where('slug', $category)
                    ->orWhere('name->fr', 'LIKE', "%{$category}%")
                    ->orWhere('name->es', 'LIKE', "%{$category}%")
                    ->orWhere('name->it', 'LIKE', "%{$category}%");
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%")
                    ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        switch ($sort) {
            case 'price-asc':
                $query->orderBy('prix_actuel', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('prix_actuel', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'asc');
                break;
        }

        $articles = $query->paginate($perPage)->withQueryString();

        $categoryName = null;
        if ($category) {
            $cat = $categories->firstWhere('slug', $category);
            if ($cat) {
                $catName = $cat->name;
                if (is_array($catName)) {
                    $categoryName = $catName[$locale] ?? $catName['fr'] ?? '';
                } else {
                    $categoryName = $catName;
                }
            }
            if (!$categoryName) {
                $categoryName = urldecode($category);
            }
        }

        $search2 = $search;

        return view('front.pages.shop', compact(
            'articles',
            'categories',
            'category',
            'categoryName',
            'sort',
            'search2'
        ));
    }

    public function showCategory($slug)
    {
        $locale = app()->getLocale();

        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::with(['images'])
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->paginate(20);

        return view('front.pages.category', compact('category', 'products'));
    }

    public function about()
    {
        return view('front.pages.about');
    }

    public function filterByPrice(Request $request)
    {
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        $query = Product::query();

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('prix_actuel', '>=', floatval($minPrice));
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('prix_actuel', '<=', floatval($maxPrice));
        }

        $count = $query->count();

        return response()->json(['count' => $count]);
    }

    public function faq()
    {
        return view('front.pages.faq');
    }

    public function contact()
    {
        return view('front.pages.contact');
    }

    public function legalNotice()
    {
        return view('front.legal.legal-notice');
    }

    public function privacyPolicy()
    {
        return view('front.legal.privacy-policy');
    }

    public function privacycookie()
    {
        return view('front.legal.privacy-cookie');
    }


    public function termsConditions()
    {
        return view('front.legal.terms-conditions');
    }

    public function deliveryPolicy()
    {
        return view('front.legal.delivery-policy');
    }

    public function refundPolicy()
    {
        return view('front.legal.refund-policy');
    }

    public function cart()
    {
        return view('front.pages.cart');
    }

    public function checkout()
    {
        return view('front.pages.checkout');
    }

    public function paymentPolicy()
    {
        return view('front.legal.payment-policy');
    }

    public function switchLangue(Request $request, $locale)
    {
        $allowedLocales = ['fr', 'pt', 'es'];

        if (!in_array($locale, $allowedLocales)) {
            abort(400);
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        $cookie = Cookie::make('locale', $locale, 60 * 24 * 365 * 5);

        return redirect()->back()->withCookie($cookie);
    }

    private function getCountriesList()
    {
        return [
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'ES', 'name' => 'Espagne'],
            ['code' => 'PT', 'name' => 'Portugais'],
        ];
    }

    public function quickview($id)
    {
        $product = Product::with(['images', 'categories'])->findOrFail($id);

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description ?? $product->short_description ?? '',
            'prix_original' => $product->prix_original,
            'prix_actuel' => $product->prix_actuel,
            'sku' => $product->sku ?? '',
            'categories' => $product->categories->pluck('name')->implode(', '),
            'images' => $product->images->map(function ($image) {
                $path = $image->fichier;

                $path = preg_replace('#^(product-category/|category/|shop/)#', '', $path);

                return [
                    'url' => asset($path),
                    'thumb' => asset($path), 
                    'alt' => $image->alt ?? ''
                ];
            }),
            'discount' => $product->prix_original && $product->prix_original > $product->prix_actuel
                ? round((($product->prix_original - $product->prix_actuel) / $product->prix_original) * 100)
                : null,
            'rating' => $product->rating ?? 0,
            'sold_count' => $product->sold_count ?? rand(10, 50),
        ];

        return response()->json($data);
    }
}
