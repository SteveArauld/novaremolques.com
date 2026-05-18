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
use Illuminate\Support\Str;


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
                $query->where('name', 'LIKE', '%remorque%')
                    ->orWhere('name', 'LIKE', '%remolque%')
                    ->orWhere('name', 'LIKE', '%rimorchio%');
            })
            ->orderBy('created_at', 'asc')
            ->get();

        //dd($dernieresTondeuses);

        return view('front.home', compact('dernieresTondeuses', 'dernieresRemorques'));
    }
public function xml()
{
    // Récupérer les produits avec leurs relations, triés par date de création
    $products = Product::with(['categories', 'images'])
        ->orderBy('created_at', 'asc')
        ->get();

    // Statistiques pour le débogage
    $stats = [
        'total_products' => 0,
        'images_rejected' => 0,
        'images_accepted' => 0,
        'products_without_images' => 0,
    ];

    // Créer le flux Google Merchant avec déclaration XML propre
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
    $xml .= '  <channel>' . "\n";
    $xml .= '    <title>' . htmlspecialchars(config('app.name'), ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</title>' . "\n";
    $xml .= '    <link>' . config('app.url') . '</link>' . "\n"; // ✅ URL de production
    $xml .= '    <description>Flux de produtos Google Merchant</description>' . "\n";
    $xml .= '    <language>pt</language>' . "\n"; // ✅ Langue principale : portugais

    foreach ($products as $product) {
        $stats['total_products']++;
        
        // Récupérer les noms et descriptions en PORTUGAIS d'abord, puis espagnol
        $name = is_array($product->name) 
            ? ($product->name['pt'] ?? $product->name['es'] ?? '') 
            : $product->name;
        $description = is_array($product->description) 
            ? ($product->description['pt'] ?? $product->description['es'] ?? '') 
            : $product->description;

        // ✅ CORRECTION 1 : Formater le titre selon les règles Google
        $name = $this->formatTitleForGoogle($name);

        $price = floatval($product->prix_actuel ?? $product->prix_original ?? 0);
        $originalPrice = floatval($product->prix_original ?? 0);

        // Catégories en PORTUGAIS d'abord, puis espagnol
        $categories = $product->categories->map(function ($cat) {
            return is_array($cat->name) 
                ? ($cat->name['pt'] ?? $cat->name['es'] ?? '') 
                : $cat->name;
        })->filter()->implode(' > ');

        // ✅ Vérifier si le produit a au moins une image valide
        $hasValidImage = false;
        $mainImageUrl = '';
        
        if ($product->images->isNotEmpty()) {
            foreach ($product->images as $image) {
                $validationResult = $this->validateGoogleImage($image->fichier);
                if ($validationResult['valid']) {
                    if (!$hasValidImage) {
                        $mainImageUrl = url($image->fichier);
                        $hasValidImage = true;
                        $stats['images_accepted']++;
                    }
                } else {
                    $stats['images_rejected']++;
                    \Log::warning("Image rejetée: {$image->fichier} - Raison: {$validationResult['reason']} - Dimensions: {$validationResult['width']}x{$validationResult['height']}");
                }
            }
        }

        // ✅ Ne pas inclure les produits sans image valide
        if (!$hasValidImage) {
            $stats['products_without_images']++;
            \Log::warning("Produit {$product->id} exclu du flux: aucune image valide (min 500x500)");
            continue; // Passer au produit suivant
        }

        $xml .= '    <item>' . "\n";
        $xml .= '      <g:id>' . $product->id . '</g:id>' . "\n";
        $xml .= '      <g:title>' . htmlspecialchars($name, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</g:title>' . "\n";
        $xml .= '      <g:description>' . htmlspecialchars(Str::limit(strip_tags($description), 5000), ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</g:description>' . "\n";
        $xml .= '      <g:link>' . route('product.show', $product->slug) . '</g:link>' . "\n";

        // Image principale (déjà validée)
        $xml .= '      <g:image_link>' . $mainImageUrl . '</g:image_link>' . "\n";

        // Images supplémentaires (max 10 au total, donc 9 supplémentaires)
        $additionalCount = 0;
        foreach ($product->images as $image) {
            if ($additionalCount >= 9) break; // Maximum 10 images au total
            
            $imageUrl = url($image->fichier);
            
            // Ne pas répéter l'image principale
            if ($imageUrl === $mainImageUrl) continue;
            
            // Valider l'image supplémentaire
            $validationResult = $this->validateGoogleImage($image->fichier);
            if ($validationResult['valid']) {
                $xml .= '      <g:additional_image_link>' . $imageUrl . '</g:additional_image_link>' . "\n";
                $additionalCount++;
            }
        }

        // Prix avec vérification de type
        if ($originalPrice > 0 && $originalPrice > $price && $price > 0) {
            $xml .= '      <g:price>' . number_format($originalPrice, 2, '.', '') . 'EUR</g:price>' . "\n";
            $xml .= '      <g:sale_price>' . number_format($price, 2, '.', '') . 'EUR</g:sale_price>' . "\n";
        } elseif ($price > 0) {
            $xml .= '      <g:price>' . number_format($price, 2, '.', '') . 'EUR</g:price>' . "\n";
        }

        // Disponibilité
        $xml .= '      <g:availability>in stock</g:availability>' . "\n";

        // Livraison Espagne (ES)
        $xml .= '      <g:shipping>' . "\n";
        $xml .= '        <g:country>ES</g:country>' . "\n";
        $xml .= '        <g:service>Estándar</g:service>' . "\n";
        $xml .= '        <g:price>0.00EUR</g:price>' . "\n";
        $xml .= '      </g:shipping>' . "\n";

        // Livraison Portugal (PT)
        $xml .= '      <g:shipping>' . "\n";
        $xml .= '        <g:country>PT</g:country>' . "\n";
        $xml .= '        <g:service>Padrão</g:service>' . "\n";
        $xml .= '        <g:price>0.00EUR</g:price>' . "\n";
        $xml .= '      </g:shipping>' . "\n";

        // Condition
        $xml .= '      <g:condition>new</g:condition>' . "\n";

        // Catégorie Google
        if ($categories) {
            $xml .= '      <g:product_type>' . htmlspecialchars($categories, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</g:product_type>' . "\n";
        }

        $xml .= '    </item>' . "\n";
    }

    $xml .= '  </channel>' . "\n";
    $xml .= '</rss>';

    // Log des statistiques finales
    \Log::info("Flux Google Merchant généré", $stats);

    return response($xml, 200)
        ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
}

/**
 * ✅ Valide une image selon les critères Google Merchant
 * Retourne un tableau avec le statut et les détails
 */
private function validateGoogleImage($imagePath)
{
    $fullPath = public_path($imagePath);
    
    // Vérifier si le fichier existe
    if (!file_exists($fullPath)) {
        return [
            'valid' => false,
            'reason' => 'Fichier manquant',
            'width' => 0,
            'height' => 0
        ];
    }
    
    // Vérifier le poids du fichier (max 16 Mo pour Google, mais recommandé < 10 Mo)
    $fileSize = filesize($fullPath);
    if ($fileSize > 16 * 1024 * 1024) {
        return [
            'valid' => false,
            'reason' => 'Fichier trop lourd (> 16 Mo)',
            'width' => 0,
            'height' => 0
        ];
    }
    
    // Obtenir les dimensions de l'image
    $imageInfo = @getimagesize($fullPath);
    if ($imageInfo === false) {
        return [
            'valid' => false,
            'reason' => 'Impossible de lire les dimensions',
            'width' => 0,
            'height' => 0
        ];
    }
    
    $width = $imageInfo[0];
    $height = $imageInfo[1];
    
    // Vérifier que l'image fait au moins 500x500 pixels
    if ($width < 500 || $height < 500) {
        return [
            'valid' => false,
            'reason' => "Dimensions insuffisantes: {$width}x{$height} (minimum 500x500 requis)",
            'width' => $width,
            'height' => $height
        ];
    }
    
    // Vérifier le format (Google accepte JPEG, PNG, GIF, BMP, TIFF, WebP)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/webp'];
    if (!in_array($imageInfo['mime'], $allowedTypes)) {
        return [
            'valid' => false,
            'reason' => "Format non supporté: {$imageInfo['mime']}",
            'width' => $width,
            'height' => $height
        ];
    }
    
    return [
        'valid' => true,
        'reason' => 'OK',
        'width' => $width,
        'height' => $height
    ];
}

/**
 * ✅ Formate le titre selon les règles Google Merchant
 * - Pas de mots entiers en majuscules (sauf acronymes de 2-3 lettres)
 * - Maximum 150 caractères
 * - Pas plus de 50% de majuscules
 */
private function formatTitleForGoogle($title)
{
    // Liste des acronymes/mots qui doivent rester en majuscules
    $keepUppercase = ['AWD', 'RTK', 'GNSS', 'VSLAM', 'AI', 'LED', 'USB', 'GPS', '4G', '5G', 'IPX', 'IP', 'ABS', 'PVC'];
    
    $words = explode(' ', $title);
    $formattedWords = [];
    
    foreach ($words as $word) {
        // Si c'est un acronyme connu, le garder tel quel
        if (in_array(strtoupper($word), $keepUppercase)) {
            $formattedWords[] = strtoupper($word);
        }
        // Si le mot fait plus de 3 caractères et est EN MAJUSCULES
        elseif (mb_strlen($word) > 3 && mb_strtoupper($word) === $word) {
            // Convertir en minuscules avec première lettre en majuscule
            $formattedWords[] = mb_convert_case(mb_strtolower($word), MB_CASE_TITLE, 'UTF-8');
        } else {
            $formattedWords[] = $word;
        }
    }
    
    $formattedTitle = implode(' ', $formattedWords);
    
    // Limiter à 150 caractères maximum (règle Google)
    if (mb_strlen($formattedTitle) > 150) {
        $formattedTitle = mb_substr($formattedTitle, 0, 147) . '...';
    }
    
    // Vérifier le ratio de majuscules (max 50%)
    $uppercaseCount = preg_match_all('/[A-Z]/u', $formattedTitle);
    $totalLetters = preg_match_all('/[A-Za-z]/u', $formattedTitle);
    
    if ($totalLetters > 0 && ($uppercaseCount / $totalLetters) > 0.5) {
        // Trop de majuscules, convertir en format titre
        $formattedTitle = mb_convert_case(mb_strtolower($formattedTitle), MB_CASE_TITLE, 'UTF-8');
        
        // Restaurer les acronymes
        foreach ($keepUppercase as $acronym) {
            $formattedTitle = str_ireplace(mb_convert_case($acronym, MB_CASE_TITLE, 'UTF-8'), $acronym, $formattedTitle);
        }
    }
    
    return $formattedTitle;
}

/**
 * ✅ Script optionnel pour redimensionner les images existantes
 * À exécuter une seule fois en ligne de commande ou via une route temporaire
 */
public function resizeAllProductImages()
{
    $products = Product::with('images')->get();
    $stats = ['resized' => 0, 'skipped' => 0, 'errors' => 0];
    
    foreach ($products as $product) {
        foreach ($product->images as $image) {
            $fullPath = public_path($image->fichier);
            
            if (!file_exists($fullPath)) {
                continue;
            }
            
            $imageInfo = @getimagesize($fullPath);
            if ($imageInfo === false) {
                $stats['errors']++;
                continue;
            }
            
            $width = $imageInfo[0];
            $height = $imageInfo[1];
            
            // Si l'image est déjà assez grande, on la garde
            if ($width >= 500 && $height >= 500) {
                $stats['skipped']++;
                continue;
            }
            
            // Redimensionner l'image
            try {
                $this->resizeImageToMinimum($fullPath, 500, 500);
                $stats['resized']++;
                \Log::info("Image redimensionnée: {$image->fichier} ({$width}x{$height} -> 500x500)");
            } catch (\Exception $e) {
                $stats['errors']++;
                \Log::error("Erreur redimensionnement: {$image->fichier} - {$e->getMessage()}");
            }
        }
    }
    
    \Log::info("Redimensionnement terminé", $stats);
    return $stats;
}

/**
 * Redimensionne une image pour qu'elle atteigne au minimum les dimensions spécifiées
 * en conservant le ratio d'aspect
 */
private function resizeImageToMinimum($filePath, $minWidth, $minHeight, $quality = 90)
{
    // Obtenir les dimensions actuelles
    list($originalWidth, $originalHeight, $type) = getimagesize($filePath);
    
    // Calculer le ratio pour atteindre au moins 500px dans les deux dimensions
    $widthRatio = $minWidth / $originalWidth;
    $heightRatio = $minHeight / $originalHeight;
    
    // Prendre le plus grand ratio pour que les deux dimensions soient ≥ minimum
    $ratio = max($widthRatio, $heightRatio);
    
    // Si l'image est déjà assez grande, ne rien faire
    if ($ratio <= 1) {
        return false;
    }
    
    // Nouvelles dimensions
    $newWidth = round($originalWidth * $ratio);
    $newHeight = round($originalHeight * $ratio);
    
    // Créer une nouvelle image
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // Charger l'image selon son type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($filePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($filePath);
            // Préserver la transparence
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($filePath);
            break;
        case IMAGETYPE_WEBP:
            if (function_exists('imagecreatefromwebp')) {
                $sourceImage = imagecreatefromwebp($filePath);
            } else {
                throw new \Exception("WebP non supporté par cette version de PHP");
            }
            break;
        default:
            throw new \Exception("Format d'image non supporté");
    }
    
    if (!$sourceImage) {
        throw new \Exception("Impossible de charger l'image source");
    }
    
    // Redimensionner
    imagecopyresampled(
        $newImage, $sourceImage,
        0, 0, 0, 0,
        $newWidth, $newHeight,
        $originalWidth, $originalHeight
    );
    
    // Sauvegarder par-dessus le fichier original
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $filePath, $quality);
            break;
        case IMAGETYPE_PNG:
            $pngQuality = round(($quality / 100) * 9);
            imagepng($newImage, $filePath, $pngQuality);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $filePath);
            break;
        case IMAGETYPE_WEBP:
            if (function_exists('imagewebp')) {
                imagewebp($newImage, $filePath, $quality);
            }
            break;
    }
    
    // Libérer la mémoire
    imagedestroy($sourceImage);
    imagedestroy($newImage);
    
    return true;
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

            Mail::send('emails.product-inquiry', $details, function ($message) use ($details) {
                $message->to(config('mail.admin_address', 'contacto@novaremolques.com'))
                    ->subject(__('email.inquiry_admin_subject', ['product' => $details['product_name']]))
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($details['email'], $details['name']);
            });

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
        $countries = $this->getCountriesList();

        return view('front.pages.checkout', compact('countries'));
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
            ['code' => 'AF', 'name' => 'Afghanistan'],
            ['code' => 'ZA', 'name' => 'Afrique du Sud'],
            ['code' => 'AL', 'name' => 'Albanie'],
            ['code' => 'DZ', 'name' => 'Algérie'],
            ['code' => 'DE', 'name' => 'Allemagne'],
            ['code' => 'AD', 'name' => 'Andorre'],
            ['code' => 'AO', 'name' => 'Angola'],
            ['code' => 'AI', 'name' => 'Anguilla'],
            ['code' => 'AQ', 'name' => 'Antarctique'],
            ['code' => 'AG', 'name' => 'Antigua-et-Barbuda'],
            ['code' => 'SA', 'name' => 'Arabie saoudite'],
            ['code' => 'AR', 'name' => 'Argentine'],
            ['code' => 'AM', 'name' => 'Arménie'],
            ['code' => 'AW', 'name' => 'Aruba'],
            ['code' => 'AU', 'name' => 'Australie'],
            ['code' => 'AT', 'name' => 'Autriche'],
            ['code' => 'AZ', 'name' => 'Azerbaïdjan'],
            ['code' => 'BS', 'name' => 'Bahamas'],
            ['code' => 'BH', 'name' => 'Bahreïn'],
            ['code' => 'BD', 'name' => 'Bangladesh'],
            ['code' => 'BB', 'name' => 'Barbade'],
            ['code' => 'BE', 'name' => 'Belgique'],
            ['code' => 'BZ', 'name' => 'Belize'],
            ['code' => 'BJ', 'name' => 'Bénin'],
            ['code' => 'BM', 'name' => 'Bermudes'],
            ['code' => 'BT', 'name' => 'Bhoutan'],
            ['code' => 'BY', 'name' => 'Biélorussie'],
            ['code' => 'MM', 'name' => 'Birmanie'],
            ['code' => 'BO', 'name' => 'Bolivie'],
            ['code' => 'BA', 'name' => 'Bosnie-Herzégovine'],
            ['code' => 'BW', 'name' => 'Botswana'],
            ['code' => 'BR', 'name' => 'Brésil'],
            ['code' => 'BN', 'name' => 'Brunéi Darussalam'],
            ['code' => 'BG', 'name' => 'Bulgarie'],
            ['code' => 'BF', 'name' => 'Burkina Faso'],
            ['code' => 'BI', 'name' => 'Burundi'],
            ['code' => 'KH', 'name' => 'Cambodge'],
            ['code' => 'CM', 'name' => 'Cameroun'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'CV', 'name' => 'Cap-Vert'],
            ['code' => 'CL', 'name' => 'Chili'],
            ['code' => 'CN', 'name' => 'Chine'],
            ['code' => 'CY', 'name' => 'Chypre'],
            ['code' => 'CO', 'name' => 'Colombie'],
            ['code' => 'KM', 'name' => 'Comores'],
            ['code' => 'CG', 'name' => 'Congo-Brazzaville'],
            ['code' => 'CD', 'name' => 'Congo-Kinshasa'],
            ['code' => 'KP', 'name' => 'Corée du Nord'],
            ['code' => 'KR', 'name' => 'Corée du Sud'],
            ['code' => 'CR', 'name' => 'Costa Rica'],
            ['code' => 'CI', 'name' => 'Côte d’Ivoire'],
            ['code' => 'HR', 'name' => 'Croatie'],
            ['code' => 'CU', 'name' => 'Cuba'],
            ['code' => 'CW', 'name' => 'Curaçao'],
            ['code' => 'DK', 'name' => 'Danemark'],
            ['code' => 'DJ', 'name' => 'Djibouti'],
            ['code' => 'DM', 'name' => 'Dominique'],
            ['code' => 'EG', 'name' => 'Égypte'],
            ['code' => 'AE', 'name' => 'Émirats arabes unis'],
            ['code' => 'EC', 'name' => 'Équateur'],
            ['code' => 'ER', 'name' => 'Érythrée'],
            ['code' => 'ES', 'name' => 'Espagne'],
            ['code' => 'EE', 'name' => 'Estonie'],
            ['code' => 'SZ', 'name' => 'Eswatini'],
            ['code' => 'US', 'name' => 'États-Unis'],
            ['code' => 'ET', 'name' => 'Éthiopie'],
            ['code' => 'FJ', 'name' => 'Fidji'],
            ['code' => 'FI', 'name' => 'Finlande'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'GA', 'name' => 'Gabon'],
            ['code' => 'GM', 'name' => 'Gambie'],
            ['code' => 'GE', 'name' => 'Géorgie'],
            ['code' => 'GS', 'name' => 'Géorgie du Sud'],
            ['code' => 'GH', 'name' => 'Ghana'],
            ['code' => 'GI', 'name' => 'Gibraltar'],
            ['code' => 'GR', 'name' => 'Grèce'],
            ['code' => 'GD', 'name' => 'Grenade'],
            ['code' => 'GL', 'name' => 'Groenland'],
            ['code' => 'GP', 'name' => 'Guadeloupe'],
            ['code' => 'GU', 'name' => 'Guam'],
            ['code' => 'GT', 'name' => 'Guatemala'],
            ['code' => 'GG', 'name' => 'Guernesey'],
            ['code' => 'GN', 'name' => 'Guinée'],
            ['code' => 'GQ', 'name' => 'Guinée équatoriale'],
            ['code' => 'GW', 'name' => 'Guinée-Bissau'],
            ['code' => 'GY', 'name' => 'Guyana'],
            ['code' => 'GF', 'name' => 'Guyane française'],
            ['code' => 'HT', 'name' => 'Haïti'],
            ['code' => 'HN', 'name' => 'Honduras'],
            ['code' => 'HU', 'name' => 'Hongrie'],
            ['code' => 'BV', 'name' => 'Île Bouvet'],
            ['code' => 'CX', 'name' => 'Île Christmas'],
            ['code' => 'IM', 'name' => 'Île de Man'],
            ['code' => 'NF', 'name' => 'Île Norfolk'],
            ['code' => 'AX', 'name' => 'Îles Åland'],
            ['code' => 'KY', 'name' => 'Îles Caïmans'],
            ['code' => 'CC', 'name' => 'Îles Cocos'],
            ['code' => 'CK', 'name' => 'Îles Cook'],
            ['code' => 'FO', 'name' => 'Îles Féroé'],
            ['code' => 'FK', 'name' => 'Îles Malouines'],
            ['code' => 'MP', 'name' => 'Îles Mariannes du Nord'],
            ['code' => 'MH', 'name' => 'Îles Marshall'],
            ['code' => 'UM', 'name' => 'Îles mineures éloignées'],
            ['code' => 'PN', 'name' => 'Îles Pitcairn'],
            ['code' => 'SB', 'name' => 'Îles Salomon'],
            ['code' => 'TC', 'name' => 'Îles Turques-et-Caïques'],
            ['code' => 'VG', 'name' => 'Îles Vierges britanniques'],
            ['code' => 'VI', 'name' => 'Îles Vierges des États-Unis'],
            ['code' => 'IN', 'name' => 'Inde'],
            ['code' => 'ID', 'name' => 'Indonésie'],
            ['code' => 'IR', 'name' => 'Iran'],
            ['code' => 'IQ', 'name' => 'Irak'],
            ['code' => 'IE', 'name' => 'Irlande'],
            ['code' => 'IS', 'name' => 'Islande'],
            ['code' => 'IL', 'name' => 'Israël'],
            ['code' => 'IT', 'name' => 'Italie'],
            ['code' => 'JM', 'name' => 'Jamaïque'],
            ['code' => 'JP', 'name' => 'Japon'],
            ['code' => 'JE', 'name' => 'Jersey'],
            ['code' => 'JO', 'name' => 'Jordanie'],
            ['code' => 'KZ', 'name' => 'Kazakhstan'],
            ['code' => 'KE', 'name' => 'Kenya'],
            ['code' => 'KG', 'name' => 'Kirghizistan'],
            ['code' => 'KI', 'name' => 'Kiribati'],
            ['code' => 'KW', 'name' => 'Koweït'],
            ['code' => 'RE', 'name' => 'La Réunion'],
            ['code' => 'LA', 'name' => 'Laos'],
            ['code' => 'LS', 'name' => 'Lesotho'],
            ['code' => 'LV', 'name' => 'Lettonie'],
            ['code' => 'LB', 'name' => 'Liban'],
            ['code' => 'LR', 'name' => 'Libéria'],
            ['code' => 'LY', 'name' => 'Libye'],
            ['code' => 'LI', 'name' => 'Liechtenstein'],
            ['code' => 'LT', 'name' => 'Lituanie'],
            ['code' => 'LU', 'name' => 'Luxembourg'],
            ['code' => 'MK', 'name' => 'Macédoine du Nord'],
            ['code' => 'MG', 'name' => 'Madagascar'],
            ['code' => 'MY', 'name' => 'Malaisie'],
            ['code' => 'MW', 'name' => 'Malawi'],
            ['code' => 'MV', 'name' => 'Maldives'],
            ['code' => 'ML', 'name' => 'Mali'],
            ['code' => 'MT', 'name' => 'Malte'],
            ['code' => 'MA', 'name' => 'Maroc'],
            ['code' => 'MQ', 'name' => 'Martinique'],
            ['code' => 'MU', 'name' => 'Maurice'],
            ['code' => 'MR', 'name' => 'Mauritanie'],
            ['code' => 'YT', 'name' => 'Mayotte'],
            ['code' => 'MX', 'name' => 'Mexique'],
            ['code' => 'FM', 'name' => 'Micronésie'],
            ['code' => 'MD', 'name' => 'Moldavie'],
            ['code' => 'MC', 'name' => 'Monaco'],
            ['code' => 'MN', 'name' => 'Mongolie'],
            ['code' => 'ME', 'name' => 'Monténégro'],
            ['code' => 'MS', 'name' => 'Montserrat'],
            ['code' => 'MZ', 'name' => 'Mozambique'],
            ['code' => 'NA', 'name' => 'Namibie'],
            ['code' => 'NR', 'name' => 'Nauru'],
            ['code' => 'NP', 'name' => 'Népal'],
            ['code' => 'NI', 'name' => 'Nicaragua'],
            ['code' => 'NE', 'name' => 'Niger'],
            ['code' => 'NG', 'name' => 'Nigéria'],
            ['code' => 'NU', 'name' => 'Niue'],
            ['code' => 'NO', 'name' => 'Norvège'],
            ['code' => 'NC', 'name' => 'Nouvelle-Calédonie'],
            ['code' => 'NZ', 'name' => 'Nouvelle-Zélande'],
            ['code' => 'OM', 'name' => 'Oman'],
            ['code' => 'UG', 'name' => 'Ouganda'],
            ['code' => 'UZ', 'name' => 'Ouzbékistan'],
            ['code' => 'PK', 'name' => 'Pakistan'],
            ['code' => 'PW', 'name' => 'Palaos'],
            ['code' => 'PA', 'name' => 'Panama'],
            ['code' => 'PG', 'name' => 'Papouasie-Nouvelle-Guinée'],
            ['code' => 'PY', 'name' => 'Paraguay'],
            ['code' => 'NL', 'name' => 'Pays-Bas'],
            ['code' => 'BQ', 'name' => 'Pays-Bas caribéens'],
            ['code' => 'PE', 'name' => 'Pérou'],
            ['code' => 'PH', 'name' => 'Philippines'],
            ['code' => 'PL', 'name' => 'Pologne'],
            ['code' => 'PF', 'name' => 'Polynésie française'],
            ['code' => 'PR', 'name' => 'Porto Rico'],
            ['code' => 'PT', 'name' => 'Portugal'],
            ['code' => 'QA', 'name' => 'Qatar'],
            ['code' => 'HK', 'name' => 'R.A.S. chinoise de Hong Kong'],
            ['code' => 'MO', 'name' => 'R.A.S. chinoise de Macao'],
            ['code' => 'CF', 'name' => 'République centrafricaine'],
            ['code' => 'DO', 'name' => 'République dominicaine'],
            ['code' => 'RO', 'name' => 'Roumanie'],
            ['code' => 'GB', 'name' => 'Royaume-Uni'],
            ['code' => 'RU', 'name' => 'Russie'],
            ['code' => 'RW', 'name' => 'Rwanda'],
            ['code' => 'EH', 'name' => 'Sahara occidental'],
            ['code' => 'BL', 'name' => 'Saint-Barthélemy'],
            ['code' => 'KN', 'name' => 'Saint-Christophe-et-Niévès'],
            ['code' => 'SM', 'name' => 'Saint-Marin'],
            ['code' => 'MF', 'name' => 'Saint-Martin'],
            ['code' => 'SX', 'name' => 'Saint-Martin (partie néerlandaise)'],
            ['code' => 'PM', 'name' => 'Saint-Pierre-et-Miquelon'],
            ['code' => 'VA', 'name' => 'Saint-Siège'],
            ['code' => 'VC', 'name' => 'Saint-Vincent-et-les-Grenadines'],
            ['code' => 'SH', 'name' => 'Sainte-Hélène'],
            ['code' => 'LC', 'name' => 'Sainte-Lucie'],
            ['code' => 'SV', 'name' => 'Salvador'],
            ['code' => 'WS', 'name' => 'Samoa'],
            ['code' => 'AS', 'name' => 'Samoa américaines'],
            ['code' => 'ST', 'name' => 'Sao Tomé-et-Principe'],
            ['code' => 'SN', 'name' => 'Sénégal'],
            ['code' => 'RS', 'name' => 'Serbie'],
            ['code' => 'SC', 'name' => 'Seychelles'],
            ['code' => 'SL', 'name' => 'Sierra Leone'],
            ['code' => 'SG', 'name' => 'Singapour'],
            ['code' => 'SK', 'name' => 'Slovaquie'],
            ['code' => 'SI', 'name' => 'Slovénie'],
            ['code' => 'SO', 'name' => 'Somalie'],
            ['code' => 'SD', 'name' => 'Soudan'],
            ['code' => 'SS', 'name' => 'Soudan du Sud'],
            ['code' => 'LK', 'name' => 'Sri Lanka'],
            ['code' => 'SE', 'name' => 'Suède'],
            ['code' => 'CH', 'name' => 'Suisse'],
            ['code' => 'SR', 'name' => 'Suriname'],
            ['code' => 'SJ', 'name' => 'Svalbard et Jan Mayen'],
            ['code' => 'SY', 'name' => 'Syrie'],
            ['code' => 'TJ', 'name' => 'Tadjikistan'],
            ['code' => 'TW', 'name' => 'Taïwan'],
            ['code' => 'TZ', 'name' => 'Tanzanie'],
            ['code' => 'TD', 'name' => 'Tchad'],
            ['code' => 'CZ', 'name' => 'Tchéquie'],
            ['code' => 'TF', 'name' => 'Terres australes françaises'],
            ['code' => 'IO', 'name' => 'Territoire britannique de l\'océan Indien'],
            ['code' => 'PS', 'name' => 'Territoires palestiniens'],
            ['code' => 'TH', 'name' => 'Thaïlande'],
            ['code' => 'TL', 'name' => 'Timor oriental'],
            ['code' => 'TG', 'name' => 'Togo'],
            ['code' => 'TK', 'name' => 'Tokelau'],
            ['code' => 'TO', 'name' => 'Tonga'],
            ['code' => 'TT', 'name' => 'Trinité-et-Tobago'],
            ['code' => 'TN', 'name' => 'Tunisie'],
            ['code' => 'TM', 'name' => 'Turkménistan'],
            ['code' => 'TR', 'name' => 'Turquie'],
            ['code' => 'TV', 'name' => 'Tuvalu'],
            ['code' => 'UA', 'name' => 'Ukraine'],
            ['code' => 'UY', 'name' => 'Uruguay'],
            ['code' => 'VU', 'name' => 'Vanuatu'],
            ['code' => 'VE', 'name' => 'Venezuela'],
            ['code' => 'VN', 'name' => 'Vietnam'],
            ['code' => 'WF', 'name' => 'Wallis-et-Futuna'],
            ['code' => 'YE', 'name' => 'Yémen'],
            ['code' => 'ZM', 'name' => 'Zambie'],
            ['code' => 'ZW', 'name' => 'Zimbabwe']
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
