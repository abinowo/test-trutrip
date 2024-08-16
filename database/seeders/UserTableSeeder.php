<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect([
            [
                'name' => 'test',
                'email' => 'test@test.com',
            ]
        ]);

        foreach ($data as $d) {
            $this->create((object) $d);
        }
    }

    protected function create($data): void
    {
        User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt('pass'),
        ]);
    }
}
