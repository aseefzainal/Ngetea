<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;

class NgeteaSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $milkTea = Category::create([
            'name' => 'Signature Milk Tea',
            'slug' => 'signature-milk-tea',
            'description' => 'Our classic, rich, and creamy milk teas.',
            'image' => 'https://images.unsplash.com/photo-1558857563-b37102e99e01?w=500&q=80',
        ]);

        $fruitTea = Category::create([
            'name' => 'Fresh Fruit Tea',
            'slug' => 'fresh-fruit-tea',
            'description' => 'Refreshing teas infused with real fruits.',
            'image' => 'https://images.unsplash.com/photo-1626082895617-2c6b3017a414?w=500&q=80',
        ]);

        $snacks = Category::create([
            'name' => 'Savory Snacks',
            'slug' => 'savory-snacks',
            'description' => 'Perfect crispy bites to complement your tea.',
            'image' => 'https://images.unsplash.com/photo-1626082896492-766af4eb6501?w=500&q=80',
        ]);

        // Create Products & Variations
        $products = [
            // MILK TEAS
            [
                'category' => $milkTea,
                'name' => 'Classic Brown Sugar Boba',
                'slug' => 'classic-brown-sugar-boba',
                'description' => 'Our best-selling milk tea with warm brown sugar pearls.',
                'price' => 4.50,
                'image' => 'https://images.unsplash.com/photo-1558857563-b37102e99e01?w=500&q=80',
            ],
            [
                'category' => $milkTea,
                'name' => 'Taro Milk Tea',
                'slug' => 'taro-milk-tea',
                'description' => 'Sweet, creamy, and visually stunning purple taro tea.',
                'price' => 4.75,
                'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=500&q=80',
            ],
            [
                'category' => $milkTea,
                'name' => 'Matcha Red Bean',
                'slug' => 'matcha-red-bean',
                'description' => 'Premium Japanese matcha layered with sweet adzuki beans.',
                'price' => 5.25,
                'image' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?w=500&q=80',
            ],
            [
                'category' => $milkTea,
                'name' => 'Thai Iced Tea',
                'slug' => 'thai-iced-tea',
                'description' => 'Authentic Thai tea leaves brewed strong with condensed milk.',
                'price' => 4.50,
                'image' => 'https://images.unsplash.com/photo-1589139544778-9e1afba9ba28?w=500&q=80',
            ],
            [
                'category' => $milkTea,
                'name' => 'Wintermelon Milk Tea',
                'slug' => 'wintermelon-milk-tea',
                'description' => 'A sweet and refreshing roasted wintermelon flavor.',
                'price' => 4.25,
                'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=500&q=80',
            ],

            // FRUIT TEAS
            [
                'category' => $fruitTea,
                'name' => 'Passionfruit Green Tea',
                'slug' => 'passionfruit-green-tea',
                'description' => 'Tangy and refreshing passionfruit, perfect for a hot day.',
                'price' => 5.00,
                'image' => 'https://images.unsplash.com/photo-1626082895617-2c6b3017a414?w=500&q=80',
            ],
            [
                'category' => $fruitTea,
                'name' => 'Mango Pomelo Sago',
                'slug' => 'mango-pomelo-sago',
                'description' => 'A tropical delight filled with fresh mango and chewy sago.',
                'price' => 5.75,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500&q=80',
            ],
            [
                'category' => $fruitTea,
                'name' => 'Lychee Black Tea',
                'slug' => 'lychee-black-tea',
                'description' => 'Premium black tea infused with sweet lychee bits.',
                'price' => 4.80,
                'image' => 'https://images.unsplash.com/photo-1576092762791-dd9e2220abd4?w=500&q=80',
            ],
            [
                'category' => $fruitTea,
                'name' => 'Peach Oolong Tea',
                'slug' => 'peach-oolong-tea',
                'description' => 'Roasted oolong tea beautifully paired with white peach.',
                'price' => 5.25,
                'image' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=500&q=80',
            ],

            // SNACKS
            [
                'category' => $snacks,
                'name' => 'Crispy Popcorn Chicken',
                'slug' => 'crispy-popcorn-chicken',
                'description' => 'Bite-sized chicken fried to golden perfection with basil.',
                'price' => 6.50,
                'image' => 'https://images.unsplash.com/photo-1562967914-608f82629710?w=500&q=80',
            ],
            [
                'category' => $snacks,
                'name' => 'Sweet Potato Fries',
                'slug' => 'sweet-potato-fries',
                'description' => 'Crispy outside, fluffy inside, sprinkled with plum powder.',
                'price' => 4.50,
                'image' => 'https://images.unsplash.com/photo-1623227836109-7a353664d509?w=500&q=80',
            ],
            [
                'category' => $snacks,
                'name' => 'Takoyaki Balls (6pcs)',
                'slug' => 'takoyaki-balls',
                'description' => 'Japanese octopus balls drizzled with mayo and bonito flakes.',
                'price' => 5.50,
                'image' => 'https://images.unsplash.com/photo-1598007634898-d1fc35748804?w=500&q=80',
            ]
        ];

        foreach ($products as $pData) {
            $cat = $pData['category'];
            unset($pData['category']);
            $product = $cat->products()->create($pData);

            // Add standard variations based on category
            if ($cat->name === 'Savory Snacks') {
                $product->variations()->createMany([
                    ['name' => 'Mild Spicy', 'type' => 'spice_level', 'additional_price' => 0],
                    ['name' => 'Extra Spicy', 'type' => 'spice_level', 'additional_price' => 0],
                    ['name' => 'No Spice', 'type' => 'spice_level', 'additional_price' => 0],
                ]);
            } else {
                // Teas get the standard tea variations
                $product->variations()->createMany([
                    ['name' => 'Regular', 'type' => 'size', 'additional_price' => 0],
                    ['name' => 'Large', 'type' => 'size', 'additional_price' => 1.00],
                    ['name' => '100% (Normal)', 'type' => 'sugar_level', 'additional_price' => 0],
                    ['name' => '50% (Half)', 'type' => 'sugar_level', 'additional_price' => 0],
                    ['name' => '0% (No Sugar)', 'type' => 'sugar_level', 'additional_price' => 0],
                    ['name' => 'Normal Ice', 'type' => 'ice_level', 'additional_price' => 0],
                    ['name' => 'Less Ice', 'type' => 'ice_level', 'additional_price' => 0],
                    ['name' => 'Extra Pearl', 'type' => 'topping', 'additional_price' => 0.75],
                    ['name' => 'Grass Jelly', 'type' => 'topping', 'additional_price' => 0.50],
                    ['name' => 'Cheese Foam', 'type' => 'topping', 'additional_price' => 1.25],
                ]);
            }
        }
    }
}
