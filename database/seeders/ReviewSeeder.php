<?php
// database/seeders/ReviewSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    private $usedNames = [];
    
    public function run()
    {
        // Vider d'abord tous les avis existants
        Review::truncate();
        
        // Pour chaque produit de 1 à 140
        for ($productId = 1; $productId <= 140; $productId++) {
            $product = Product::find($productId);
            
            if ($product) {
                // Générer entre 10 et 15 avis par produit
                $reviewCount = rand(10, 15);
                $reviews = $this->generateProductReviews($product, $reviewCount);
                $this->createReviewsForProduct($product, $reviews);
            }
        }
        
        echo "Total avis créés : " . Review::count() . "\n";
    }

    private function createReviewsForProduct($product, $reviewsData)
    {
        foreach ($reviewsData as $reviewData) {
            Review::create([
                'product_id' => $product->id,
                'author_name' => $reviewData['author_name'],
                'author_email' => $reviewData['author_email'],
                'rating' => $reviewData['rating'],
                'comment' => $reviewData['comment'],
                'author_country' => $reviewData['author_country'] ?? 'PT',
                'author_photo' => $reviewData['author_photo'] ?? null,
                'is_verified' => $reviewData['is_verified'] ?? true,
                'is_approved' => true,
                'created_at' => $this->randomDate(),
                'updated_at' => now()
            ]);
        }
    }

    private function generateProductReviews($product, $count)
    {
        $reviews = [];
        $categories = $this->getProductCategories($product);
        $productName = $product->name ?? 'Produit';
        
        for ($i = 0; $i < $count; $i++) {
            $country = $this->getRandomCountry();
            $rating = $this->getWeightedRating();
            $authorData = $this->getRandomAuthor($country);
            
            $reviews[] = [
                'author_name' => $authorData['name'],
                'author_email' => $authorData['email'],
                'rating' => $rating,
                'comment' => $this->generateRealisticComment($categories, $rating, $country, $productName),
                'author_country' => $country,
                'is_verified' => rand(1, 10) > 2, // 80% de chances d'être vérifié
            ];
        }
        
        return $reviews;
    }

    private function getProductCategories($product)
    {
        $categories = [];
        if ($product->categories) {
            foreach ($product->categories as $category) {
                $catName = is_array($category->name) ? ($category->name['fr'] ?? '') : $category->name;
                $categories[] = strtolower($catName);
            }
        }
        return $categories;
    }

    private function getWeightedRating()
    {
        // Distribution réaliste des notes (plus de 4-5 que de 2-3)
        $weights = [
            2 => 10,  // 10% de notes de 2
            3 => 20,  // 20% de notes de 3
            4 => 35,  // 35% de notes de 4
            5 => 35,  // 35% de notes de 5
        ];
        
        $rand = rand(1, 100);
        $cumulative = 0;
        
        foreach ($weights as $rating => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $rating;
            }
        }
        
        return 4;
    }

    private function getRandomCountry()
    {
        $countries = ['PT', 'FR', 'IT', 'ES'];
        return $countries[array_rand($countries)];
    }

    private function getRandomAuthor($country)
    {
        $names = [
            'PT' => [
                ['João', 'Silva'], ['Maria', 'Santos'], ['Pedro', 'Oliveira'], 
                ['Ana', 'Costa'], ['Rui', 'Pereira'], ['Carla', 'Rodrigues'],
                ['Miguel', 'Fernandes'], ['Sofia', 'Martins'], ['Hugo', 'Almeida'],
                ['Teresa', 'Carvalho'], ['Bruno', 'Lima'], ['Filipa', 'Gonçalves'],
                ['Nuno', 'Marques'], ['Inês', 'Ribeiro'], ['André', 'Soares'],
                ['Catarina', 'Lopes'], ['Diogo', 'Sousa'], ['Marta', 'Pires'],
                ['Ricardo', 'Cunha'], ['Sara', 'Azevedo'], ['Fábio', 'Neves'],
                ['Bianca', 'Machado'], ['Gustavo', 'Borges'], ['Raquel', 'Coelho']
            ],
            'FR' => [
                ['Pierre', 'Martin'], ['Sophie', 'Dubois'], ['Laurent', 'Bernard'],
                ['Marie', 'Petit'], ['Thomas', 'Durand'], ['Céline', 'Moreau'],
                ['Nicolas', 'Leroy'], ['Julie', 'Fournier'], ['David', 'Girard'],
                ['Aurélie', 'Bonnet'], ['Sébastien', 'Roux'], ['Émilie', 'Vincent'],
                ['Guillaume', 'Lefebvre'], ['Camille', 'Fontaine'], ['Alexandre', 'Gauthier'],
                ['Lucie', 'Robin'], ['Maxime', 'Faure'], ['Charlotte', 'Blanc'],
                ['Antoine', 'Marchand'], ['Pauline', 'Renard'], ['Julien', 'Masson'],
                ['Amélie', 'Noël'], ['Romain', 'Perrin'], ['Léa', 'Brunet']
            ],
            'IT' => [
                ['Marco', 'Ferrari'], ['Laura', 'Esposito'], ['Alessandro', 'Bianchi'],
                ['Giulia', 'Romano'], ['Francesco', 'Ricci'], ['Valentina', 'Marino'],
                ['Andrea', 'Colombo'], ['Francesca', 'Greco'], ['Matteo', 'Bruno'],
                ['Elena', 'Gallo'], ['Luca', 'Conti'], ['Chiara', 'De Luca'],
                ['Giovanni', 'Costa'], ['Martina', 'Mancini'], ['Simone', 'Fontana'],
                ['Federica', 'Barbieri'], ['Davide', 'Rinaldi'], ['Alessia', 'Caruso'],
                ['Paolo', 'Vitale'], ['Beatrice', 'Pellegrini'], ['Stefano', 'Moretti'],
                ['Silvia', 'Palumbo'], ['Antonio', 'Gentile'], ['Anna', 'Testa']
            ],
            'ES' => [
                ['Carlos', 'Rodriguez'], ['Ana', 'Martinez'], ['Javier', 'Lopez'],
                ['Maria', 'Gonzalez'], ['David', 'Sanchez'], ['Laura', 'Perez'],
                ['Daniel', 'Fernandez'], ['Carmen', 'Torres'], ['Alejandro', 'Ruiz'],
                ['Isabel', 'Diaz'], ['Miguel', 'Garcia'], ['Elena', 'Moreno'],
                ['Pablo', 'Jimenez'], ['Marta', 'Romero'], ['Sergio', 'Navarro'],
                ['Cristina', 'Muñoz'], ['Raul', 'Ortega'], ['Patricia', 'Herrera'],
                ['Alberto', 'Castro'], ['Silvia', 'Ramos'], ['Victor', 'Morales'],
                ['Angela', 'Molina'], ['Francisco', 'Garrido'], ['Rosa', 'Santana']
            ]
        ];

        $name = $names[$country][array_rand($names[$country])];
        $fullName = $name[0] . ' ' . $name[1];
        $email = strtolower($this->removeAccents($name[0] . '.' . $name[1])) . rand(1, 999) . $this->getDomain($country);
        
        return ['name' => $fullName, 'email' => $email];
    }

    private function generateRealisticComment($categories, $rating, $country, $productName)
    {
        $categoryPhrases = [];
        
        // Détecter le type de produit
        if ($this->hasCategory($categories, ['remorque', 'remolque', 'rimorchio', 'trailer'])) {
            $categoryPhrases = $this->getTrailerComments($rating, $country);
        } elseif ($this->hasCategory($categories, ['robot', 'cortacésped', 'tondeuse', 'rasaerba'])) {
            $categoryPhrases = $this->getRobotMowerComments($rating, $country);
        } elseif ($this->hasCategory($categories, ['trituradora', 'broyeur', 'trituratore', 'triturador'])) {
            $categoryPhrases = $this->getCrusherComments($rating, $country);
        } elseif ($this->hasCategory($categories, ['desbrozadora', 'débroussailleuse', 'decespugliatore', 'corta-matas'])) {
            $categoryPhrases = $this->getBrushCutterComments($rating, $country);
        } elseif ($this->hasCategory($categories, ['autopropulsado', 'autopropulsé', 'autopropulso'])) {
            $categoryPhrases = $this->getSelfPropelledComments($rating, $country);
        } else {
            $categoryPhrases = $this->getGeneralComments($rating, $country);
        }
        
        return $categoryPhrases[array_rand($categoryPhrases)];
    }

    private function getTrailerComments($rating, $country)
    {
        $comments = [
            'PT' => [
                5 => [
                    'Excelente reboque! Construção muito sólida e durável.',
                    'Reboque fantástico, superou todas as minhas expectativas.',
                    'Muito satisfeito com a qualidade deste reboque.',
                    'Melhor reboque que já comprei. Vale cada euro.',
                    'Robusto e bem acabado. Recomendo vivamente!',
                    'Uso profissional e está impecável após 6 meses.',
                    'Entrega rápida e reboque em perfeitas condições.',
                    'Excelente relação qualidade-preço.'
                ],
                4 => [
                    'Bom reboque, estrutura resistente e bem construída.',
                    'Satisfeito com a compra. Apenas a pintura poderia ser melhor.',
                    'Reboque funcional e prático para o dia a dia.',
                    'Boa qualidade geral. Pequenos detalhes a melhorar.',
                    'Corresponde ao esperado. Bom produto.',
                    'Reboque robusto, fácil de manobrar.',
                    'Bom acabamento, entrega dentro do prazo.'
                ],
                3 => [
                    'Reboque aceitável para o preço.',
                    'Funciona bem mas esperava materiais de melhor qualidade.',
                    'Razoável. A suspensão podia ser mais suave.',
                    'Cumpre a função mas com algumas limitações.',
                    'Para uso ocasional está bom.',
                    'Mediano. Existem opções melhores no mercado.'
                ],
                2 => [
                    'Decepcionado com a qualidade da pintura.',
                    'Apresentou ferrugem após 2 meses de uso.',
                    'Não recomendo, materiais fracos.',
                    'Pelo preço esperava muito mais qualidade.',
                    'Problemas com a documentação de homologação.'
                ]
            ],
            'FR' => [
                5 => [
                    'Remorque d\'excellente qualité, très robuste.',
                    'Parfait pour mon usage professionnel, je recommande.',
                    'Très satisfait de cette remorque, finition impeccable.',
                    'La meilleure remorque que j\'ai achetée.',
                    'Construction solide et durable, excellent investissement.',
                    'Livraison rapide, remorque bien emballée et protégée.',
                    'Excellent rapport qualité-prix pour du matériel pro.'
                ],
                4 => [
                    'Bonne remorque, structure résistante.',
                    'Satisfait dans l\'ensemble. La peinture pourrait être améliorée.',
                    'Remorque fonctionnelle, facile à atteler.',
                    'Bon produit, correspond à la description.',
                    'Qualité correcte pour le prix.',
                    'Remorque pratique, bonne capacité de charge.'
                ],
                3 => [
                    'Remorque correcte sans plus.',
                    'Acceptable pour un usage occasionnel.',
                    'Qualité moyenne, j\'espérais mieux.',
                    'Fait le travail mais manque de finitions.',
                    'Des améliorations nécessaires sur la suspension.'
                ],
                2 => [
                    'Déçu par la qualité des matériaux.',
                    'Problèmes de rouille après quelques semaines.',
                    'Ne vaut pas son prix.',
                    'J\'ai eu des soucis avec les freins.'
                ]
            ],
            'IT' => [
                5 => [
                    'Rimorchio eccellente! Costruzione molto robusta.',
                    'Perfetto per uso professionale, lo consiglio vivamente.',
                    'Molto soddisfatto della qualità di questo rimorchio.',
                    'Miglior rimorchio che abbia mai comprato.',
                    'Ottimo rapporto qualità-prezzo.',
                    'Consegna veloce e rimorchio in perfette condizioni.'
                ],
                4 => [
                    'Buon rimorchio, struttura resistente.',
                    'Soddisfatto dell\'acquisto, qualche piccolo difetto estetico.',
                    'Rimorchio funzionale, facile da trainare.',
                    'Buona qualità generale, consigliato.',
                    'Corrisponde alle aspettative.'
                ],
                3 => [
                    'Rimorchio accettabile per il prezzo.',
                    'Qualità nella media, niente di eccezionale.',
                    'Funziona ma con qualche limitazione.',
                    'Per uso saltuario può andare bene.'
                ],
                2 => [
                    'Deluso dalla qualità dei materiali.',
                    'Problemi di ruggine dopo pochi mesi.',
                    'Non lo ricomprerei.'
                ]
            ],
            'ES' => [
                5 => [
                    '¡Remolque excelente! Construcción muy sólida.',
                    'Perfecto para uso profesional, lo recomiendo.',
                    'Muy satisfecho con la calidad de este remolque.',
                    'El mejor remolque que he comprado.',
                    'Excelente relación calidad-precio.',
                    'Entrega rápida y en perfectas condiciones.'
                ],
                4 => [
                    'Buen remolque, estructura resistente.',
                    'Satisfecho con la compra en general.',
                    'Remolque funcional y práctico.',
                    'Buena calidad, pequeños detalles a mejorar.',
                    'Corresponde a lo esperado.'
                ],
                3 => [
                    'Remolque aceptable para el precio.',
                    'Calidad media, esperaba más.',
                    'Funciona pero con limitaciones.',
                    'Para uso ocasional está bien.'
                ],
                2 => [
                    'Decepcionado con la calidad.',
                    'Problemas de óxido después de poco tiempo.',
                    'No lo recomiendo.'
                ]
            ]
        ];
        
        return $comments[$country][$rating] ?? $comments['FR'][$rating];
    }

    private function getRobotMowerComments($rating, $country)
    {
        $comments = [
            'PT' => [
                5 => [
                    'Robot excecional! O jardim nunca esteve tão bem cuidado.',
                    'Tecnologia de ponta, funciona perfeitamente em terrenos inclinados.',
                    'Melhor investimento para o jardim. Voltava a comprar sem hesitar.',
                    'O sistema de navegação é impressionante, nunca se perde.',
                    'Silencioso e eficiente. A relva está sempre perfeita.',
                    'Fácil de programar através da app. Muito intuitivo.',
                    'Passados 3 meses, zero problemas. Excelente produto.',
                    'A qualidade do corte é profissional. Recomendo!'
                ],
                4 => [
                    'Muito bom robot, só precisa de melhorar a autonomia.',
                    'Funciona bem na maioria dos terrenos.',
                    'Bom desempenho geral. App podia ser mais intuitiva.',
                    'Satisfeito, mas o preço é um pouco elevado.',
                    'Boa máquina, fácil de instalar e configurar.',
                    'Corte regular e consistente. Bom produto.'
                ],
                3 => [
                    'Robot razoável, tem dificuldades em zonas muito inclinadas.',
                    'Funciona mas precisa de supervisão frequente.',
                    'Pelo preço esperava mais funcionalidades.',
                    'Aceitável, mas existem melhores opções.'
                ],
                2 => [
                    'Dececionante, não sobe inclinações como anunciado.',
                    'Problemas constantes com o sinal GPS.',
                    'Pelo preço que custa, esperava muito mais.',
                    'Demasiado complexo de configurar.'
                ]
            ],
            'FR' => [
                5 => [
                    'Robot tondeuse exceptionnel ! Mon jardin est impeccable.',
                    'Technologie de pointe, fonctionne parfaitement.',
                    'Meilleur investissement pour le jardin.',
                    'Système de navigation impressionnant, jamais perdu.',
                    'Silencieux et efficace. La pelouse est toujours parfaite.',
                    'Application très intuitive et facile à programmer.',
                    'Après 3 mois, aucun problème. Excellent produit.',
                    'Qualité de coupe professionnelle. Je recommande!'
                ],
                4 => [
                    'Très bon robot, l\'autonomie pourrait être meilleure.',
                    'Fonctionne bien sur la plupart des terrains.',
                    'Bonnes performances générales.',
                    'Satisfait mais le prix est un peu élevé.',
                    'Bonne machine, facile à installer.',
                    'Coupe régulière et consistante.'
                ],
                3 => [
                    'Robot correct, difficultés en terrain très pentu.',
                    'Fonctionne mais nécessite une supervision.',
                    'Pour le prix, j\'espérais plus de fonctionnalités.',
                    'Acceptable mais il existe mieux.'
                ],
                2 => [
                    'Décevant, ne monte pas les pentes annoncées.',
                    'Problèmes constants de signal GPS.',
                    'Pour ce prix, on attend beaucoup mieux.',
                    'Trop complexe à configurer.'
                ]
            ],
            'IT' => [
                5 => [
                    'Robot eccezionale! Il giardino non è mai stato così bello.',
                    'Tecnologia all\'avanguardia, funziona perfettamente.',
                    'Miglior investimento per il giardino.',
                    'Sistema di navigazione impressionante.',
                    'Silenzioso ed efficiente.',
                    'App molto intuitiva e facile da programmare.',
                    'Dopo 3 mesi, zero problemi.',
                    'Qualità di taglio professionale. Consigliato!'
                ],
                4 => [
                    'Ottimo robot, autonomia migliorabile.',
                    'Funziona bene sulla maggior parte dei terreni.',
                    'Buone prestazioni generali.',
                    'Soddisfatto ma prezzo un po\' alto.',
                    'Buona macchina, facile da installare.'
                ],
                3 => [
                    'Robot discreto, difficoltà su pendenze.',
                    'Funziona ma richiede supervisione.',
                    'Per il prezzo mi aspettavo di più.',
                    'Accettabile ma ci sono opzioni migliori.'
                ],
                2 => [
                    'Deludente, non sale le pendenze come dichiarato.',
                    'Problemi costanti con il GPS.',
                    'Per quello che costa, mi aspettavo molto di più.'
                ]
            ],
            'ES' => [
                5 => [
                    '¡Robot excepcional! El jardín nunca ha estado tan bien.',
                    'Tecnología punta, funciona perfectamente.',
                    'Mejor inversión para el jardín.',
                    'Sistema de navegación impresionante.',
                    'Silencioso y eficiente.',
                    'App muy intuitiva y fácil de programar.',
                    'Después de 3 meses, cero problemas.',
                    'Calidad de corte profesional. ¡Recomiendo!'
                ],
                4 => [
                    'Muy buen robot, autonomía mejorable.',
                    'Funciona bien en la mayoría de terrenos.',
                    'Buen rendimiento general.',
                    'Satisfecho pero el precio es algo elevado.',
                    'Buena máquina, fácil de instalar.'
                ],
                3 => [
                    'Robot regular, dificultades en pendientes.',
                    'Funciona pero necesita supervisión.',
                    'Por el precio esperaba más funcionalidades.',
                    'Aceptable pero hay mejores opciones.'
                ],
                2 => [
                    'Decepcionante, no sube pendientes como anuncian.',
                    'Problemas constantes con el GPS.',
                    'Por lo que cuesta, esperaba mucho más.'
                ]
            ]
        ];
        
        return $comments[$country][$rating] ?? $comments['FR'][$rating];
    }

    private function getCrusherComments($rating, $country)
    {
        $comments = [
            'PT' => [
                5 => [
                    'Triturador potente, tritura ramos grossos sem esforço.',
                    'Excelente máquina para compostagem.',
                    'Muito robusto, construído para durar.',
                    'O melhor triturador que já tive.',
                    'Tritura tudo, muito eficiente.',
                    'Motor potente e silencioso.',
                    'Fácil de usar e limpar.',
                    'Produto profissional com qualidade superior.'
                ],
                4 => [
                    'Bom triturador para uso doméstico.',
                    'Funciona bem com a maioria dos resíduos.',
                    'Satisfeito, mas é um pouco pesado.',
                    'Boa potência, podia ser mais silencioso.',
                    'Qualidade aceitável para o preço.',
                    'Tritura bem ramos até 40mm.'
                ],
                3 => [
                    'Triturador básico, cumpre a função.',
                    'Para ramos finos funciona bem.',
                    'Razoável, mas encrava com ramos grossos.',
                    'Barulhento para uso residencial.'
                ],
                2 => [
                    'Pouco potente para ramos mais grossos.',
                    'Encrava frequentemente.',
                    'Não corresponde às especificações.',
                    'Dececionante, esperava mais potência.'
                ]
            ],
            'FR' => [
                5 => [
                    'Broyeur puissant, broie les grosses branches sans effort.',
                    'Excellent pour le compostage.',
                    'Très robuste, construit pour durer.',
                    'Le meilleur broyeur que j\'ai eu.',
                    'Broye tout, très efficace.',
                    'Moteur puissant et silencieux.',
                    'Facile à utiliser et à nettoyer.',
                    'Produit professionnel de qualité supérieure.'
                ],
                4 => [
                    'Bon broyeur pour usage domestique.',
                    'Fonctionne bien avec la plupart des déchets.',
                    'Satisfait, mais un peu lourd.',
                    'Bonne puissance, pourrait être plus silencieux.',
                    'Qualité acceptable pour le prix.',
                    'Broye bien les branches jusqu\'à 40mm.'
                ],
                3 => [
                    'Broyeur basique, fait le travail.',
                    'Pour les branches fines, ça va.',
                    'Correct, mais se bloque avec les grosses branches.',
                    'Bruyant pour un usage résidentiel.'
                ],
                2 => [
                    'Peu puissant pour les grosses branches.',
                    'Se bloque fréquemment.',
                    'Ne correspond pas aux spécifications.',
                    'Décevant, j\'espérais plus de puissance.'
                ]
            ],
            'IT' => [
                5 => [
                    'Trituratore potente, tritura rami grossi senza sforzo.',
                    'Eccellente per il compostaggio.',
                    'Molto robusto, costruito per durare.',
                    'Il miglior trituratore che abbia mai avuto.',
                    'Tritura tutto, molto efficiente.',
                    'Motore potente e silenzioso.',
                    'Facile da usare e pulire.',
                    'Prodotto professionale di qualità superiore.'
                ],
                4 => [
                    'Buon trituratore per uso domestico.',
                    'Funziona bene con la maggior parte dei rifiuti.',
                    'Soddisfatto, ma è un po\' pesante.',
                    'Buona potenza, potrebbe essere più silenzioso.',
                    'Qualità accettabile per il prezzo.'
                ],
                3 => [
                    'Trituratore base, fa il suo lavoro.',
                    'Per rami sottili funziona bene.',
                    'Discreto, ma si blocca con rami grossi.',
                    'Rumoroso per uso residenziale.'
                ],
                2 => [
                    'Poco potente per rami più grossi.',
                    'Si blocca frequentemente.',
                    'Non corrisponde alle specifiche.'
                ]
            ],
            'ES' => [
                5 => [
                    'Trituradora potente, tritura ramas gruesas sin esfuerzo.',
                    'Excelente para compostaje.',
                    'Muy robusta, construida para durar.',
                    'La mejor trituradora que he tenido.',
                    'Tritura todo, muy eficiente.',
                    'Motor potente y silencioso.',
                    'Fácil de usar y limpiar.',
                    'Producto profesional de calidad superior.'
                ],
                4 => [
                    'Buena trituradora para uso doméstico.',
                    'Funciona bien con la mayoría de residuos.',
                    'Satisfecho, pero es un poco pesada.',
                    'Buena potencia, podría ser más silenciosa.',
                    'Calidad aceptable para el precio.'
                ],
                3 => [
                    'Trituradora básica, cumple su función.',
                    'Para ramas finas funciona bien.',
                    'Regular, se atasca con ramas gruesas.',
                    'Ruidoso para uso residencial.'
                ],
                2 => [
                    'Poco potente para ramas gruesas.',
                    'Se atasca frecuentemente.',
                    'No corresponde a las especificaciones.'
                ]
            ]
        ];
        
        return $comments[$country][$rating] ?? $comments['FR'][$rating];
    }

    private function getBrushCutterComments($rating, $country)
    {
        $comments = [
            'PT' => [
                5 => [
                    'Máquina excelente! Potência surpreendente para uma bateria.',
                    'Corta tudo, até vegetação densa sem problemas.',
                    'Muito leve e fácil de manobrar.',
                    'A bateria dura muito mais do que esperava.',
                    'Silencioso e potente, combinação perfeita.',
                    'Uso profissional diário e nunca me deixou ficar mal.',
                    'Melhor compra para manutenção de terrenos.',
                    'Acabamento premium e muito ergonómico.'
                ],
                4 => [
                    'Boa máquina, corte eficiente.',
                    'Satisfeito, só precisa de bateria extra.',
                    'Leve e potente, boa combinação.',
                    'Funciona bem para vegetação média.',
                    'Boa autonomia para uso doméstico.',
                    'Recomendo, boa relação qualidade-preço.'
                ],
                3 => [
                    'Razoável para uso ocasional.',
                    'Para ervas finas funciona bem.',
                    'Bateria podia durar mais.',
                    'Ruidoso para uso residencial.'
                ],
                2 => [
                    'Pouco potente para vegetação densa.',
                    'Bateria descarrega muito rápido.',
                    'Não recomendado para uso profissional.',
                    'Dececionante, esperava mais da marca.'
                ]
            ],
            'FR' => [
                5 => [
                    'Machine excellente! Puissance surprenante pour une batterie.',
                    'Coupe tout, même la végétation dense.',
                    'Très léger et facile à manœuvrer.',
                    'La batterie dure bien plus que prévu.',
                    'Silencieux et puissant, combinaison parfaite.',
                    'Usage professionnel quotidien sans problème.',
                    'Meilleur achat pour l\'entretien des terrains.',
                    'Finition premium et très ergonomique.'
                ],
                4 => [
                    'Bonne machine, coupe efficace.',
                    'Satisfait, juste besoin d\'une batterie supplémentaire.',
                    'Léger et puissant, bon équilibre.',
                    'Fonctionne bien pour la végétation moyenne.',
                    'Bonne autonomie pour usage domestique.',
                    'Je recommande, bon rapport qualité-prix.'
                ],
                3 => [
                    'Correct pour un usage occasionnel.',
                    'Pour les herbes fines, ça va.',
                    'La batterie pourrait durer plus longtemps.',
                    'Bruyant pour un usage résidentiel.'
                ],
                2 => [
                    'Pas assez puissant pour la végétation dense.',
                    'La batterie se décharge trop vite.',
                    'Pas recommandé pour un usage professionnel.',
                    'Décevant, j\'en attendais plus de cette marque.'
                ]
            ],
            'IT' => [
                5 => [
                    'Macchina eccellente! Potenza sorprendente a batteria.',
                    'Taglia tutto, anche vegetazione fitta.',
                    'Molto leggero e facile da manovrare.',
                    'La batteria dura molto più del previsto.',
                    'Silenzioso e potente, combinazione perfetta.',
                    'Uso professionale quotidiano senza problemi.',
                    'Miglior acquisto per manutenzione terreni.',
                    'Finitura premium e molto ergonomico.'
                ],
                4 => [
                    'Buona macchina, taglio efficiente.',
                    'Soddisfatto, serve batteria supplementare.',
                    'Leggero e potente, buona combinazione.',
                    'Funziona bene per vegetazione media.',
                    'Buona autonomia per uso domestico.'
                ],
                3 => [
                    'Discreto per uso occasionale.',
                    'Per erbe fini funziona bene.',
                    'Batteria potrebbe durare di più.',
                    'Rumoroso per uso residenziale.'
                ],
                2 => [
                    'Poco potente per vegetazione fitta.',
                    'Batteria si scarica troppo velocemente.',
                    'Non raccomandato per uso professionale.'
                ]
            ],
            'ES' => [
                5 => [
                    '¡Máquina excelente! Potencia sorprendente a batería.',
                    'Corta todo, incluso vegetación densa.',
                    'Muy ligera y fácil de maniobrar.',
                    'La batería dura mucho más de lo esperado.',
                    'Silencioso y potente, combinación perfecta.',
                    'Uso profesional diario sin problemas.',
                    'Mejor compra para mantenimiento de terrenos.',
                    'Acabado premium y muy ergonómico.'
                ],
                4 => [
                    'Buena máquina, corte eficiente.',
                    'Satisfecho, necesita batería extra.',
                    'Ligero y potente, buena combinación.',
                    'Funciona bien para vegetación media.',
                    'Buena autonomía para uso doméstico.'
                ],
                3 => [
                    'Regular para uso ocasional.',
                    'Para hierbas finas funciona.',
                    'Batería podría durar más.',
                    'Ruidoso para uso residencial.'
                ],
                2 => [
                    'Poco potente para vegetación densa.',
                    'Batería se descarga muy rápido.',
                    'No recomendado para uso profesional.'
                ]
            ]
        ];
        
        return $comments[$country][$rating] ?? $comments['FR'][$rating];
    }

    private function getSelfPropelledComments($rating, $country)
    {
        $comments = [
            'PT' => [
                5 => [
                    'Excelente corta-relva! Potente e muito manobrável.',
                    'Corte perfeito, mesmo em terrenos irregulares.',
                    'Máquina profissional, construída para durar.',
                    'O melhor corta-relva autopropulsado que já usei.',
                    'Arranque fácil e funcionamento suave.',
                    'Muito confortável de conduzir, mesmo por horas.',
                    'Manutenção simples e económica.',
                    'Investimento que vale cada cêntimo.'
                ],
                4 => [
                    'Bom corta-relva, funciona bem.',
                    'Satisfeito, mas o consumo podia ser menor.',
                    'Boa máquina para grandes áreas.',
                    'Corte uniforme e eficiente.',
                    'Confortável, boa autonomia.',
                    'Recomendo para quem tem jardins grandes.'
                ],
                3 => [
                    'Aceitável para o preço.',
                    'Funciona mas é um pouco ruidoso.',
                    'Para uso doméstico está bom.',
                    'Manutenção mais frequente do que esperava.'
                ],
                2 => [
                    'Pouco potente para relva alta.',
                    'Problemas com o sistema de tração.',
                    'Dececionante para uso intensivo.',
                    'Não recomendo, problemas de fiabilidade.'
                ]
            ],
            'FR' => [
                5 => [
                    'Excellente tondeuse! Puissante et très maniable.',
                    'Coupe parfaite, même sur terrain irrégulier.',
                    'Machine professionnelle, construite pour durer.',
                    'La meilleure tondeuse autoportée que j\'ai utilisée.',
                    'Démarrage facile et fonctionnement souple.',
                    'Très confortable à conduire, même pendant des heures.',
                    'Entretien simple et économique.',
                    'Investissement qui vaut chaque centime.'
                ],
                4 => [
                    'Bonne tondeuse, fonctionne bien.',
                    'Satisfait, mais la consommation pourrait être meilleure.',
                    'Bonne machine pour grandes surfaces.',
                    'Coupe uniforme et efficace.',
                    'Confortable, bonne autonomie.',
                    'Je recommande pour les grands jardins.'
                ],
                3 => [
                    'Acceptable pour le prix.',
                    'Fonctionne mais un peu bruyant.',
                    'Pour usage domestique, c\'est correct.',
                    'Entretien plus fréquent que prévu.'
                ],
                2 => [
                    'Pas assez puissant pour l\'herbe haute.',
                    'Problèmes avec le système de traction.',
                    'Décevant pour un usage intensif.',
                    'Je ne recommande pas, problèmes de fiabilité.'
                ]
            ],
            'IT' => [
                5 => [
                    'Eccellente rasaerba! Potente e molto maneggevole.',
                    'Taglio perfetto, anche su terreni irregolari.',
                    'Macchina professionale, costruita per durare.',
                    'Il miglior rasaerba semovente che abbia mai usato.',
                    'Avviamento facile e funzionamento fluido.',
                    'Molto confortevole da guidare, anche per ore.',
                    'Manutenzione semplice ed economica.',
                    'Investimento che vale ogni centesimo.'
                ],
                4 => [
                    'Buon rasaerba, funziona bene.',
                    'Soddisfatto, ma i consumi potrebbero essere minori.',
                    'Buona macchina per grandi aree.',
                    'Taglio uniforme ed efficiente.',
                    'Confortevole, buona autonomia.',
                    'Consigliato per giardini grandi.'
                ],
                3 => [
                    'Accettabile per il prezzo.',
                    'Funziona ma è un po\' rumoroso.',
                    'Per uso domestico va bene.',
                    'Manutenzione più frequente del previsto.'
                ],
                2 => [
                    'Poco potente per erba alta.',
                    'Problemi con il sistema di trazione.',
                    'Deludente per uso intensivo.',
                    'Non lo consiglio, problemi di affidabilità.'
                ]
            ],
            'ES' => [
                5 => [
                    '¡Excelente cortacésped! Potente y muy maniobrable.',
                    'Corte perfecto, incluso en terrenos irregulares.',
                    'Máquina profesional, construida para durar.',
                    'El mejor cortacésped autopropulsado que he usado.',
                    'Arranque fácil y funcionamiento suave.',
                    'Muy cómodo de conducir, incluso por horas.',
                    'Mantenimiento simple y económico.',
                    'Inversión que vale cada céntimo.'
                ],
                4 => [
                    'Buen cortacésped, funciona bien.',
                    'Satisfecho, pero el consumo podría ser menor.',
                    'Buena máquina para grandes áreas.',
                    'Corte uniforme y eficiente.',
                    'Cómodo, buena autonomía.',
                    'Recomendado para jardines grandes.'
                ],
                3 => [
                    'Aceptable por el precio.',
                    'Funciona pero es un poco ruidoso.',
                    'Para uso doméstico está bien.',
                    'Mantenimiento más frecuente de lo esperado.'
                ],
                2 => [
                    'Poco potente para hierba alta.',
                    'Problemas con el sistema de tracción.',
                    'Decepcionante para uso intensivo.',
                    'No lo recomiendo, problemas de fiabilidad.'
                ]
            ]
        ];
        
        return $comments[$country][$rating] ?? $comments['FR'][$rating];
    }

    private function getGeneralComments($rating, $country)
    {
        $comments = [
            'PT' => [
                5 => [
                    'Excelente produto! Superou todas as expectativas.',
                    'Qualidade excecional. Recomendo vivamente!',
                    'Melhor compra do ano. Produto impecável.',
                    'Muito satisfeito, funciona perfeitamente.',
                    'Produto fantástico, já recomendei a amigos.',
                    'Entrega rápida e produto em perfeitas condições.',
                    'Acabamento premium, nota-se qualidade.',
                    'Vale cada cêntimo. Comprarei mais produtos.'
                ],
                4 => [
                    'Bom produto, corresponde ao esperado.',
                    'Satisfeito com a compra. Boa qualidade.',
                    'Funciona bem. Entrega eficiente.',
                    'Produto de qualidade. Pequenos detalhes apenas.',
                    'Boa compra no geral. Recomendo.',
                    'Preço justo para a qualidade oferecida.',
                    'Robusto e bem construído.'
                ],
                3 => [
                    'Produto razoável. Cumpre a função.',
                    'Aceitável para o preço.',
                    'Funciona mas com limitações.',
                    'Mediano. Nem bom nem mau.',
                    'Produto OK. Podia ser melhor.',
                    'Qualidade média para o preço.'
                ],
                2 => [
                    'Dececionado com a qualidade.',
                    'Esperava mais pelo preço.',
                    'Não corresponde às expectativas.',
                    'Qualidade abaixo da média.',
                    'Problemas após pouco tempo de uso.'
                ]
            ],
            'FR' => [
                5 => [
                    'Excellent produit! Dépasse toutes les attentes.',
                    'Qualité exceptionnelle. Je recommande vivement!',
                    'Meilleur achat de l\'année. Produit impeccable.',
                    'Très satisfait, fonctionne parfaitement.',
                    'Produit fantastique, déjà recommandé à des amis.',
                    'Livraison rapide, produit en parfait état.',
                    'Finition premium, la qualité se voit.',
                    'Vaut chaque centime. J\'achèterai d\'autres produits.'
                ],
                4 => [
                    'Bon produit, correspond aux attentes.',
                    'Satisfait de l\'achat. Bonne qualité.',
                    'Fonctionne bien. Livraison efficace.',
                    'Produit de qualité. Juste quelques petits détails.',
                    'Bon achat dans l\'ensemble. Je recommande.',
                    'Prix juste pour la qualité offerte.',
                    'Robuste et bien construit.'
                ],
                3 => [
                    'Produit correct. Remplit sa fonction.',
                    'Acceptable pour le prix.',
                    'Fonctionne avec quelques limitations.',
                    'Moyen. Ni bon ni mauvais.',
                    'Produit OK. Pourrait être mieux.',
                    'Qualité moyenne pour le prix.'
                ],
                2 => [
                    'Déçu de la qualité.',
                    'J\'en attendais plus pour le prix.',
                    'Ne correspond pas aux attentes.',
                    'Qualité en dessous de la moyenne.',
                    'Problèmes après peu de temps d\'utilisation.'
                ]
            ],
            'IT' => [
                5 => [
                    'Prodotto eccellente! Supera tutte le aspettative.',
                    'Qualità eccezionale. Lo consiglio vivamente!',
                    'Miglior acquisto dell\'anno. Prodotto impeccabile.',
                    'Molto soddisfatto, funziona perfettamente.',
                    'Prodotto fantastico, già consigliato ad amici.',
                    'Consegna rapida, prodotto in perfette condizioni.',
                    'Finitura premium, la qualità si vede.',
                    'Vale ogni centesimo. Comprerò altri prodotti.'
                ],
                4 => [
                    'Buon prodotto, corrisponde alle aspettative.',
                    'Soddisfatto dell\'acquisto. Buona qualità.',
                    'Funziona bene. Consegna efficiente.',
                    'Prodotto di qualità. Solo piccoli dettagli.',
                    'Buon acquisto nel complesso. Consiglio.',
                    'Prezzo giusto per la qualità offerta.',
                    'Robusto e ben costruito.'
                ],
                3 => [
                    'Prodotto discreto. Svolge la sua funzione.',
                    'Accettabile per il prezzo.',
                    'Funziona con alcune limitazioni.',
                    'Nella media. Né buono né cattivo.',
                    'Prodotto OK. Potrebbe essere migliore.',
                    'Qualità media per il prezzo.'
                ],
                2 => [
                    'Deluso dalla qualità.',
                    'Mi aspettavo di più per il prezzo.',
                    'Non corrisponde alle aspettative.',
                    'Qualità sotto la media.',
                    'Problemi dopo poco tempo di utilizzo.'
                ]
            ],
            'ES' => [
                5 => [
                    '¡Excelente producto! Supera todas las expectativas.',
                    'Calidad excepcional. ¡Lo recomiendo encarecidamente!',
                    'Mejor compra del año. Producto impecable.',
                    'Muy satisfecho, funciona perfectamente.',
                    'Producto fantástico, ya lo he recomendado.',
                    'Entrega rápida, producto en perfecto estado.',
                    'Acabado premium, se nota la calidad.',
                    'Vale cada céntimo. Compraré más productos.'
                ],
                4 => [
                    'Buen producto, corresponde a lo esperado.',
                    'Satisfecho con la compra. Buena calidad.',
                    'Funciona bien. Entrega eficiente.',
                    'Producto de calidad. Solo pequeños detalles.',
                    'Buena compra en general. Lo recomiendo.',
                    'Precio justo para la calidad ofrecida.',
                    'Robusto y bien construido.'
                ],
                3 => [
                    'Producto regular. Cumple su función.',
                    'Aceptable por el precio.',
                    'Funciona con algunas limitaciones.',
                    'Mediocre. Ni bueno ni malo.',
                    'Producto OK. Podría ser mejor.',
                    'Calidad media para el precio.'
                ],
                2 => [
                    'Decepcionado con la calidad.',
                    'Esperaba más por el precio.',
                    'No corresponde a las expectativas.',
                    'Calidad por debajo de la media.',
                    'Problemas después de poco tiempo de uso.'
                ]
            ]
        ];
        
        return $comments[$country][$rating] ?? $comments['FR'][$rating];
    }

    private function hasCategory($categories, $keywords)
    {
        foreach ($categories as $category) {
            foreach ($keywords as $keyword) {
                if (stripos($category, $keyword) !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    private function getDomain($country)
    {
        $domains = [
            'PT' => '@email.pt',
            'FR' => '@email.fr', 
            'IT' => '@email.it',
            'ES' => '@email.es'
        ];
        return $domains[$country] ?? '@email.pt';
    }

    private function randomDate()
    {
        $start = strtotime('-12 months');
        $end = strtotime('-1 day');
        $timestamp = rand($start, $end);
        return date('Y-m-d H:i:s', $timestamp);
    }

    private function removeAccents($string)
    {
        $unwanted_array = [
            'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
        ];
        return strtr($string, $unwanted_array);
    }
}