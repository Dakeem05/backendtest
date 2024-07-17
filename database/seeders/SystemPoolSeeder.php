<?php

namespace Database\Seeders;

use App\Models\SystemPool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemPoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pool = [
            [
                'balance' => config('data.system_pool')
            ],
        ];
        SystemPool::insert($pool);
    }
}
