<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        User::updateOrCreate(
            ['email' => 'admin@matcha.com'],
            [
                'name' => 'Admin Matcha',
                'mobile' => '081234567890',
                'utype' => 'ADM',
                'password' => bcrypt('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@matcha.com'],
            [
                'name' => 'User Matcha',
                'mobile' => '081234567891',
                'utype' => 'USR',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Brands
        $b1 = Brand::updateOrCreate(['slug' => 'uji-kyoto-matcha'], ['name' => 'Uji Kyoto Matcha', 'image' => 'brand-1.png', 'status' => 1]);
        $b2 = Brand::updateOrCreate(['slug' => 'shizuoka-organics'], ['name' => 'Shizuoka Organics', 'image' => 'brand-2.png', 'status' => 1]);
        $b3 = Brand::updateOrCreate(['slug' => 'matcha-botanica'], ['name' => 'Matcha Botanica', 'image' => 'brand-3.png', 'status' => 1]);
        $b4 = Brand::updateOrCreate(['slug' => 'haru-zen-green'], ['name' => 'Haru Zen Green', 'image' => 'brand-4.png', 'status' => 1]);
        $b5 = Brand::updateOrCreate(['slug' => 'sayama-heritage'], ['name' => 'Sayama Heritage', 'image' => 'brand-5.png', 'status' => 1]);

        // 3. Categories & Subcategories
        $c1 = Category::updateOrCreate(['slug' => 'matcha-powder'], ['name' => 'Matcha Powder', 'image' => 'category_1.png', 'parent_id' => null, 'status' => 1]);
        $c1_sub1 = Category::updateOrCreate(['slug' => 'ceremonial-grade'], ['name' => 'Ceremonial Grade', 'image' => 'category_2.png', 'parent_id' => $c1->id, 'status' => 1]);
        $c1_sub2 = Category::updateOrCreate(['slug' => 'culinary-latte-grade'], ['name' => 'Culinary & Latte Grade', 'image' => 'category_3.png', 'parent_id' => $c1->id, 'status' => 1]);

        $c2 = Category::updateOrCreate(['slug' => 'tea-sets-aksesoris'], ['name' => 'Tea Sets & Aksesoris', 'image' => 'category_4.png', 'parent_id' => null, 'status' => 1]);
        $c2_sub1 = Category::updateOrCreate(['slug' => 'chasen-bambu-whisk'], ['name' => 'Chasen Bambu Whisk', 'image' => 'category_5.png', 'parent_id' => $c2->id, 'status' => 1]);
        $c2_sub2 = Category::updateOrCreate(['slug' => 'chawan-matcha-bowl'], ['name' => 'Chawan Ceramic Bowl', 'image' => 'category_6.png', 'parent_id' => $c2->id, 'status' => 1]);

        $c3 = Category::updateOrCreate(['slug' => 'saringan-peralatan-seduh'], ['name' => 'Saringan & Peralatan Seduh', 'image' => 'category_9.jpg', 'parent_id' => null, 'status' => 1]);
        $c3_sub1 = Category::updateOrCreate(['slug' => 'matcha-sifter-furui'], ['name' => 'Matcha Sifter Furui', 'image' => 'category_9.jpg', 'parent_id' => $c3->id, 'status' => 1]);
        $c3_sub2 = Category::updateOrCreate(['slug' => 'chashaku-bamboo-scoop'], ['name' => 'Chashaku Bamboo Scoop', 'image' => 'category_10.jpg', 'parent_id' => $c3->id, 'status' => 1]);

        // 4. Products
        $products = [
            [
                'name' => 'Uji Ceremonial Matcha 50g Premium First Harvest',
                'slug' => 'uji-ceremonial-matcha-50g-premium',
                'short_description' => 'Matcha kualitas upacara tertinggi dari perkebunan Uji, Kyoto. Rasa umami pekat tanpa pahit.',
                'description' => "Matcha murni 100% dipetik dari pucuk daun teh pertama (first harvest) di pegunungan Uji, Kyoto, Jepang.\nDiproses menggunakan batu penggiling tradisional (stone milled) untuk menjaga profil rasa manis alami, aroma segar dedaunan muda, dan warna hijau emerald yang cerah.\nCocok untuk seduhan usucha maupun koicha formal.",
                'regular_price' => 195000,
                'sale_price' => 165000,
                'SKU' => 'MTC-UJI-01',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 45,
                'image' => 'product-ceremonial.jpg',
                'images' => 'product-ceremonial.jpg,product-latte.jpg',
                'category_id' => $c1_sub1->id,
                'brand_id' => $b1->id,
                'status' => 1,
            ],
            [
                'name' => 'Shizuoka Organic Culinary Matcha 100g',
                'slug' => 'shizuoka-organic-culinary-matcha-100g',
                'short_description' => 'Bubuk matcha organik bersertifikat untuk kreasi baking, pastry, ice cream, dan latte.',
                'description' => "Bubuk matcha organik kualitas culinary grade dengan karakter rasa bold dan warna hijau alami yang stabil saat dipanggang.\nBerasal dari perkebunan organik Shizuoka dengan sertifikasi JAS Organic. Sangat pas untuk café, bakery, maupun resep rumahan.",
                'regular_price' => 140000,
                'sale_price' => 120000,
                'SKU' => 'MTC-SHZ-02',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 60,
                'image' => 'product-culinary.jpg',
                'images' => 'product-culinary.jpg,product-ceremonial.jpg',
                'category_id' => $c1_sub2->id,
                'brand_id' => $b2->id,
                'status' => 1,
            ],
            [
                'name' => 'Botanica Creamy Matcha Latte Powder 250g',
                'slug' => 'botanica-creamy-matcha-latte-powder-250g',
                'short_description' => 'Racikan bubuk matcha latte siap seduh dengan susu nabati oat dan gula tebu kelapa lembut.',
                'description' => "Paduan serasi antara matcha murni Jepang, non-dairy creamer kelapa, dan gula aren organik.\nCukup diseduh dengan 150ml air hangat atau susu segar untuk menikmati segelas matcha latte otentik setara café bintang lima.",
                'regular_price' => 85000,
                'sale_price' => 75000,
                'SKU' => 'MTC-BOT-03',
                'stock_status' => 'instock',
                'featured' => 0,
                'quantity' => 80,
                'image' => 'product-latte.jpg',
                'images' => 'product-latte.jpg,product-culinary.jpg',
                'category_id' => $c1_sub2->id,
                'brand_id' => $b3->id,
                'status' => 1,
            ],
            [
                'name' => 'Traditional Bamboo Whisk Chasen 100 Prongs',
                'slug' => 'traditional-bamboo-whisk-chasen-100-prongs',
                'short_description' => 'Kocokan bambu alami 100 cabang untuk menghasilkan busa matcha (crema) yang halus dan lembut.',
                'description' => "Dibuat tangan oleh pengrajin dari satu bilah bambu putih utuh tanpa bahan kimia.\nMemiliki 100 cabang lentur yang dirancang khusus untuk melarutkan bubuk matcha secara sempurna hingga menghasilkan microfoam busa hijau yang creamy.",
                'regular_price' => 115000,
                'sale_price' => 99000,
                'SKU' => 'ACC-CHASEN-04',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 30,
                'image' => 'product-chasen.jpg',
                'images' => 'product-chasen.jpg,product-chawan.jpg',
                'category_id' => $c2_sub1->id,
                'brand_id' => $b4->id,
                'status' => 1,
            ],
            [
                'name' => 'Handcrafted Matcha Chawan Ceramic Bowl Green Glaze',
                'slug' => 'handcrafted-matcha-chawan-ceramic-bowl',
                'short_description' => 'Mangkok keramik matcha estetik dengan glasir hijau sage lembut bertekstur alami.',
                'description' => "Mangkok seduh chawan keramik berdiameter 11.5cm yang ideal untuk ruang gerak chasen saat mengocok matcha.\nBahan stoneware tahan panas dengan finishing glasir doff yang nyaman digenggam kedua tangan.",
                'regular_price' => 165000,
                'sale_price' => 145000,
                'SKU' => 'ACC-CHAWAN-05',
                'stock_status' => 'instock',
                'featured' => 0,
                'quantity' => 20,
                'image' => 'product-chawan.jpg',
                'images' => 'product-chawan.jpg,product-chasen.jpg',
                'category_id' => $c2_sub2->id,
                'brand_id' => $b4->id,
                'status' => 1,
            ],
            [
                'name' => 'Stainless Steel Fine Mesh Matcha Sifter (Furui)',
                'slug' => 'stainless-steel-fine-mesh-matcha-sifter-furui',
                'short_description' => 'Saringan bubuk matcha stainless steel 304 lubang mikro ultra-halus untuk hasil seduhan bebas gumpalan.',
                'description' => "Saringan teh tradisional Furui berbahan food-grade stainless steel 304 dengan anyaman mesh ekstra halus.\nDirancang khusus untuk memecah partikel bubuk matcha yang menggumpal sebelum dikocok, menghasilkan seduhan busa yang lembut merata dan sensasi rasa umami yang maksimal.",
                'regular_price' => 75000,
                'sale_price' => 59000,
                'SKU' => 'ACC-SIFT-06',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 45,
                'image' => 'product-sifter.jpg',
                'images' => 'product-sifter.jpg,product-chashaku.jpg',
                'category_id' => $c3_sub1->id,
                'brand_id' => $b4->id,
                'status' => 1,
            ],
            [
                'name' => 'Artisan Mino Ceramic Matcha Cup & Bamboo Rest',
                'slug' => 'artisan-mino-ceramic-matcha-cup-bamboo-rest',
                'short_description' => 'Cangkir keramik artisanal Mino-yaki bertekstur alami dipadu tatakan bambu estetik untuk menikmati seduhan matcha hangat.',
                'description' => "Cangkir seduh teh keramik handmade buatan pengrajin Mino, Jepang dengan glasir earthy doff yang nyaman digenggam.\nSangat ideal untuk ritual minum usucha sehari-hari maupun dinikmati bersama camilan wagashi tradisional.",
                'regular_price' => 85000,
                'sale_price' => 69000,
                'SKU' => 'ACC-CUP-07',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 40,
                'image' => 'product-chashaku.jpg',
                'images' => 'product-chashaku.jpg,product-sifter.jpg',
                'category_id' => $c2_sub2->id,
                'brand_id' => $b4->id,
                'status' => 1,
            ],
            [
                'name' => 'Uji Single Origin Imperial Matcha Powder 80g',
                'slug' => 'uji-single-origin-imperial-matcha-powder-80g',
                'short_description' => 'Bubuk matcha single-origin dari perkebunan teh kuno Uji, diproses tradisional batu granit dengan profil umami pekat.',
                'description' => "Matcha murni berkualitas upacara kaisar (Imperial Ceremonial) yang dipanen dari varietas Samidori terpilih di perbukitan Uji, Kyoto.\nWarna hijau jade cerah dengan aftertaste creamy manis tanpa rasa pahit (bitterness).",
                'regular_price' => 175000,
                'sale_price' => 149000,
                'SKU' => 'MTC-IMP-08',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 35,
                'image' => 'product-ceremonial.jpg',
                'images' => 'product-ceremonial.jpg,product-latte.jpg',
                'category_id' => $c1_sub1->id,
                'brand_id' => $b1->id,
                'status' => 1,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 5. Coupons
        Coupon::updateOrCreate(
            ['code' => 'MATCHA10'],
            [
                'type' => 'percent',
                'value' => 10,
                'cart_value' => 100000,
                'expiry_date' => Carbon::now()->addMonths(6)->toDateString(),
                'status' => 1,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'MATCHA20'],
            [
                'type' => 'percent',
                'value' => 20,
                'cart_value' => 250000,
                'expiry_date' => Carbon::now()->addMonths(6)->toDateString(),
                'status' => 1,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'POTONGAN50K'],
            [
                'type' => 'fixed',
                'value' => 50000,
                'cart_value' => 300000,
                'expiry_date' => Carbon::now()->addMonths(6)->toDateString(),
                'status' => 1,
            ]
        );
    }
}
