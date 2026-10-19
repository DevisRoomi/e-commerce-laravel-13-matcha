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

        $c3 = Category::updateOrCreate(['slug' => 'busana-muslimah-matcha'], ['name' => 'Busana Muslimah Matcha', 'image' => 'category_9.jpg', 'parent_id' => null, 'status' => 1]);
        $c3_sub1 = Category::updateOrCreate(['slug' => 'hijab-pashmina-silk'], ['name' => 'Hijab Pashmina Silk', 'image' => 'category_7.png', 'parent_id' => $c3->id, 'status' => 1]);
        $c3_sub2 = Category::updateOrCreate(['slug' => 'gamis-modest-series'], ['name' => 'Gamis Modest Series', 'image' => 'category_10.jpg', 'parent_id' => $c3->id, 'status' => 1]);

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
                'name' => 'Pashmina Silk Muslimah Matcha Green Series',
                'slug' => 'pashmina-silk-muslimah-matcha-green',
                'short_description' => 'Hijab pashmina sutra premium warna hijau matcha lembut, adem, tegak di dahi dan tidak menerawang.',
                'description' => "Hijab muslimah berbahan silk flowy yang anggun dengan aksen kilau doff elegan.\nWarna hijau matcha pastel yang manis dan cocok dipadukan dengan berbagai busana gamis atau busana formal sehari-hari.",
                'regular_price' => 95000,
                'sale_price' => 79000,
                'SKU' => 'FSH-PASH-06',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 50,
                'image' => 'product-pashmina.jpg',
                'images' => 'product-pashmina.jpg,product-abaya.jpg',
                'category_id' => $c3_sub1->id,
                'brand_id' => $b5->id,
                'status' => 1,
            ],
            [
                'name' => 'Gamis Abaya Modest Matcha Olive Linen Premium',
                'slug' => 'gamis-abaya-modest-matcha-olive-linen',
                'short_description' => 'Gamis muslimah potongan longgar syari berbahan katun linen dingin dengan detail kancing matcha.',
                'description' => "Busana gamis syari elegan yang dirancang khusus untuk kenyamanan wanita muslimah modern.\nPotongan longgar (loose-fit) tanpa lekuk tubuh, wudhu friendly dengan karet lembut di pergelangan tangan, dan saku samping tersembunyi.",
                'regular_price' => 285000,
                'sale_price' => 249000,
                'SKU' => 'FSH-ABAYA-07',
                'stock_status' => 'instock',
                'featured' => 1,
                'quantity' => 25,
                'image' => 'product-abaya.jpg',
                'images' => 'product-abaya.jpg,product-pashmina.jpg',
                'category_id' => $c3_sub2->id,
                'brand_id' => $b5->id,
                'status' => 1,
            ],
            [
                'name' => 'Sayama Heritage Roasted Hojicha Powder 80g',
                'slug' => 'sayama-heritage-roasted-hojicha-powder-80g',
                'short_description' => 'Bubuk teh hijau panggang hojicha beraroma nutty karamel dengan kadar kafein sangat rendah.',
                'description' => "Teh hijau Sayama yang dipanggang dengan suhu tinggi hingga berubah warna menjadi kecokelatan dan menghasilkan aroma smoky karamel yang harum memikat.\nSangat nikmat dinikmati malam hari sebagai hojicha latte hangat ramah lambung.",
                'regular_price' => 135000,
                'sale_price' => null,
                'SKU' => 'MTC-HOJ-08',
                'stock_status' => 'instock',
                'featured' => 0,
                'quantity' => 35,
                'image' => 'product-hojicha.jpg',
                'images' => 'product-hojicha.jpg,product-ceremonial.jpg',
                'category_id' => $c1_sub2->id,
                'brand_id' => $b5->id,
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
