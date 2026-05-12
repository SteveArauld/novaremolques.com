<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = storage_path('app/products.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error("Fichier non trouvé: $jsonPath");
            return;
        }

        $products = json_decode(File::get($jsonPath), true);
        $total = count($products);
        $slugsUtilises = [];

        foreach ($products as $index => $productData) {
            $nomFr = $productData['nom']['fr'];
            $this->command->info("📦 [" . ($index + 1) . "/$total] Import: " . $nomFr);
            
            // Générer un slug unique
            $slug = Str::slug($nomFr);
            $slugOriginal = $slug;
            $suffixe = 2;
            while (in_array($slug, $slugsUtilises)) {
                $slug = $slugOriginal . '-' . $suffixe;
                $suffixe++;
            }
            $slugsUtilises[] = $slug;
            
            // Créer le produit avec Spatie (les traductions sont automatiques)
            $product = Product::create([
                'url' => '/product/' . $slug,
                'slug' => $slug,
                'sku' => $productData['sku'] ?? null,
                'name' => [
                    'es' => $productData['nom']['es'],
                    'fr' => $productData['nom']['fr'],
                    'it' => $productData['nom']['it'],
                    'pt' => $productData['nom']['pt'],
                ],
                'description' => [
                    'es' => $productData['description']['es'],
                    'fr' => $productData['description']['fr'],
                    'it' => $productData['description']['it'],
                    'pt' => $productData['description']['pt'],
                ],
                'prix_original' => $productData['prix_original'] ?? null,
                'prix_actuel' => $productData['prix_actuel'] ?? null,
            ]);
            
            // Ajouter les images
            foreach ($productData['images'] as $imageIndex => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $image['url'],
                    
                    'fichier' => $image['fichier'],
                    'order' => $imageIndex,
                ]);
            }
            
            // Ajouter les catégories
            foreach ($productData['categories'] as $categoryData) {
                $categorySlug = Str::slug($categoryData['fr']);
                
                $category = Category::firstOrCreate(
                    ['slug' => $categorySlug],
                    [
                        'name' => [
                            'es' => $categoryData['es'],
                            'fr' => $categoryData['fr'],
                            'it' => $categoryData['it'],
                            'pt' => $categoryData['pt'],
                        ]
                    ]
                );
                
                $product->categories()->attach($category->id);
            }
        }
        
        $this->command->info("\n✅ Import terminé !");
        $this->command->info("📦 Produits: " . Product::count());
        $this->command->info("🏷️ Catégories: " . Category::count());
        $this->command->info("🖼️ Images: " . ProductImage::count());
    }
}