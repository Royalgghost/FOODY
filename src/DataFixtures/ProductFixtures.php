<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Pizza',
                'description' => 'Delicious pizza prepared with fresh ingredients',
                'price' => 10.99,
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591',
                'stock' => 10
            ],
            [
                'name' => 'Burger',
                'description' => 'Delicious burger prepared with fresh ingredients',
                'price' => 12.99,
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd',
                'stock' => 15
            ],
            [
                'name' => 'Pasta',
                'description' => 'Delicious pasta prepared with fresh ingredients',
                'price' => 15.99,
                'image' => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8',
                'stock' => 20
            ],
            [
                'name' => 'Salad',
                'description' => 'Fresh and healthy salad',
                'price' => 8.99,
                'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd',
                'stock' => 25
            ],
            [
                'name' => 'Sushi',
                'description' => 'Delicious sushi prepared with fresh ingredients',
                'price' => 18.99,
                'image' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c',
                'stock' => 30
            ],
            [
                'name' => 'Greek Salad',
                'description' => 'Traditional Greek salad with feta cheese and olives',
                'price' => 9.99,
                'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999',
                'stock' => 20
            ],
            [
                'name' => 'Margherita Pizza',
                'description' => 'Classic Italian pizza with tomatoes and mozzarella',
                'price' => 11.99,
                'image' => 'https://images.unsplash.com/photo-1604068549290-dea0e4a305ca',
                'stock' => 15
            ],
            [
                'name' => 'Chicken Curry',
                'description' => 'Spicy chicken curry with basmati rice',
                'price' => 14.99,
                'image' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641',
                'stock' => 18
            ],
            [
                'name' => 'Chocolate Cake',
                'description' => 'Rich and moist chocolate cake',
                'price' => 6.99,
                'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587',
                'stock' => 12
            ],
            [
                'name' => 'Ramen',
                'description' => 'Japanese ramen with pork and egg',
                'price' => 13.99,
                'image' => 'https://images.unsplash.com/photo-1557872943-16a5ac26437e',
                'stock' => 22
            ],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setDescription($productData['description']);
            $product->setPrice($productData['price']);
            $product->setImage($productData['image']);
            $product->setStock($productData['stock']);
            
            $manager->persist($product);
        }

        $manager->flush();
    }
} 