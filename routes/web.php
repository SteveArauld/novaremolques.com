<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\ReviewController;
/*
|--------------------------------------------------------------------------
| Front Website Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/lang/{locale}', [HomeController::class, 'switchLAngue'])->name('lang.switch')->where('locale', 'en|fr|it|pt|es');


// Products
Route::get('/product/{slug}', [HomeController::class, 'showProduct'])->name('product.show');
Route::post('/product/{id}/richiedi', [HomeController::class, 'sendInquiry'])->name('product.inquiry');
Route::get('/product-category/{category}', [HomeController::class, 'showShop'])->name('category.show');

// Pages
Route::get('/chi-siamo', [HomeController::class, 'about'])->name('about');
Route::get('/negozio', [HomeController::class, 'showShop'])->name('shop');
Route::get('/domande-frequenti-faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contatto', [HomeController::class, 'contact'])->name('contact');

// Legal Pages
Route::get('/menzioni-legali', [HomeController::class, 'legalNotice'])->name('legal.notice');
Route::get('/informativa-sulla-privacy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/informativa-sulla-cookie', [HomeController::class, 'privacycookie'])->name('privacy.cookie');
Route::get('/condizioni-generali-di-vendita-cgv', [HomeController::class, 'termsConditions'])->name('terms.conditions');
Route::get('/politica-di-consegna', [HomeController::class, 'deliveryPolicy'])->name('delivery.policy');
Route::get('/politica-di-reso-e-rimborso', [HomeController::class, 'refundPolicy'])->name('refund.policy');
Route::get('/politica-di-pagamento', [HomeController::class, 'paymentPolicy'])->name('payment.policy');



Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');


Route::get('/api/quickview/{id}', [App\Http\Controllers\HomeController::class, 'quickview'])
    ->name('api.quickview');

Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');


Route::get('/feed.xml',[HomeController::class, 'xml']);

Route::get('/resize-images', function () {
    $controller = new HomeController;
    $stats = $controller->resizeAllProductImages();
    return response()->json($stats);
});




// Route pour soumettre un avis
Route::post('/product/{product}/review', [HomeController::class, 'submitReview'])->name('product.review.submit');

// Routes API pour les avis (optionnel, si vous voulez du AJAX)
Route::get('/api/product/{product}/reviews', [ReviewController::class, 'getProductReviews']);
Route::post('/api/product/{product}/review', [ReviewController::class, 'storeReview']);