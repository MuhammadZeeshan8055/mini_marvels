<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminCatalogSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@minimarvels.test'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $categoryData = [
            ['name' => 'Stuffed Dolls', 'emoji' => '🧸'],
            ['name' => 'Wood Toys', 'emoji' => '🪵'],
            ['name' => 'Learning Toys', 'emoji' => '🧠'],
            ['name' => 'Ride On Toys', 'emoji' => '🚗'],
            ['name' => 'Pretend Play', 'emoji' => '🎭'],
            ['name' => 'Games & Puzzles', 'emoji' => '🧩'],
            ['name' => 'Arts & Crafts', 'emoji' => '🎨'],
        ];

        $categories = [];

        foreach ($categoryData as $item) {
            $categories[$item['name']] = Category::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'emoji' => $item['emoji'],
                ]
            );
        }

        $products = [
            ['name' => 'Stuffed Deer Toy', 'category' => 'Stuffed Dolls', 'age' => '3-4 Years', 'price' => 21.55, 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1559454403-b8fb88521f11?w=700&h=700&fit=crop'],
            ['name' => 'Wooden Rocking Horse', 'category' => 'Wood Toys', 'age' => '3-4 Years', 'price' => 15.60, 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=700&h=700&fit=crop'],
            ['name' => 'Funny Teddy', 'category' => 'Learning Toys', 'age' => '0-2 Years', 'price' => 20.50, 'featured' => false, 'image' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?w=700&h=700&fit=crop'],
            ['name' => 'Woolen Baby Girl', 'category' => 'Stuffed Dolls', 'age' => '3-4 Years', 'price' => 21.70, 'featured' => false, 'image' => 'https://images.unsplash.com/photo-1618842676088-c4d48a6a7c9d?w=700&h=700&fit=crop'],
            ['name' => 'Fancy Teddy Bear', 'category' => 'Stuffed Dolls', 'age' => '0-2 Years', 'price' => 20.85, 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1545558014-8692077e9b5c?w=700&h=700&fit=crop'],
            ['name' => 'Push Ride On Car', 'category' => 'Ride On Toys', 'age' => '5-7 Years', 'price' => 25.25, 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=700&h=700&fit=crop'],
            ['name' => 'Baby Stroller Toy', 'category' => 'Pretend Play', 'age' => '0-2 Years', 'price' => 24.85, 'featured' => false, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=700&h=700&fit=crop'],
            ['name' => 'Handmade Teddy Bear', 'category' => 'Stuffed Dolls', 'age' => '0-2 Years', 'price' => 23.60, 'featured' => false, 'image' => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?w=700&h=700&fit=crop'],
            ['name' => 'Rainbow Building Blocks', 'category' => 'Learning Toys', 'age' => '3-4 Years', 'price' => 18.40, 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=700&h=700&fit=crop'],
            ['name' => 'Classic Board Game', 'category' => 'Games & Puzzles', 'age' => '5-7 Years', 'price' => 28.90, 'featured' => false, 'image' => 'https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?w=700&h=700&fit=crop'],
            ['name' => 'Creative Art Kit', 'category' => 'Arts & Crafts', 'age' => '8-10 Years', 'price' => 32.00, 'featured' => false, 'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=700&h=700&fit=crop'],
            ['name' => 'Junior Science Set', 'category' => 'Learning Toys', 'age' => '10+ Years', 'price' => 44.50, 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=700&h=700&fit=crop'],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $categories[$item['category']]->id,
                    'name' => $item['name'],
                    'description' => $item['name'].' is a fun Mini Marvels pick for playful kids.',
                    'price' => $item['price'],
                    'image' => $item['image'],
                    'age' => $item['age'],
                    'stock' => 25,
                    'is_featured' => $item['featured'],
                    'is_active' => true,
                ]
            );
        }

        $this->call(CmsContentSeeder::class);
    }
}
