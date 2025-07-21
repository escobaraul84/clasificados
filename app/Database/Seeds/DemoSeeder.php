<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $db = $this->db;

        // 1. USUARIOS
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'uuid'          => Uuid::uuid4()->getBytes(),
                'email'         => $faker->unique()->email,
                'password_hash' => password_hash('123456', PASSWORD_BCRYPT),
                'full_name'     => $faker->name,
                'phone'         => $faker->phoneNumber,
                'lat'           => $faker->latitude,
                'lng'           => $faker->longitude,
                'address'       => json_encode(['country' => 'AR']),
                'created_at'    => Time::now()->toDateTimeString(),
                'updated_at'    => Time::now()->toDateTimeString(),
            ];
        }
        $db->table('users')->insertBatch($users);

        // 2. ANUNCIOS
        $ads = [];
        for ($i = 1; $i <= 30; $i++) {
            $ads[] = [
                'uuid'          => Uuid::uuid4()->getBytes(),
                'user_id'       => random_int(1, 10),
                'category_id'   => random_int(1, 4),
                'title'         => $faker->sentence(3),
                'slug'          => url_title($faker->slug(3), '-', true),
                'description_md'=> $faker->paragraph(3),
                'price'         => $faker->randomFloat(2, 1, 5000),
                'currency'      => 'USD',
                'status'        => 'active',
                'created_at'    => Time::now()->toDateTimeString(),
                'updated_at'    => Time::now()->toDateTimeString(),
            ];
        }
        $db->table('ads')->insertBatch($ads);

        // 3. IMÁGENES (ahora los ad_id ya existen)
        $images = [];
        for ($adId = 1; $adId <= 30; $adId++) {
            for ($j = 0; $j < 2; $j++) {
                $images[] = [
                    'ad_id'      => $adId,
                    'url'        => 'https://picsum.photos/600/400?random=' . random_int(1, 2000),
                    'sort_order' => $j,
                    'is_primary' => $j === 0 ? 1 : 0,
                    'created_at' => Time::now()->toDateTimeString(),
                ];
            }
        }
        $db->table('ad_images')->insertBatch($images);

        // 4. WALLETS
        $wallets = [];
        for ($i = 1; $i <= 10; $i++) {
            $wallets[] = [
                'user_id'      => $i,
                'balance_clas' => 0,
                'created_at'   => Time::now()->toDateTimeString(),
            ];
        }
        $db->table('wallets')->insertBatch($wallets);
    }
}