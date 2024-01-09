<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Eliminar directorios para que no se repitan los seeders
        Storage::deleteDirectory('articles');
        Storage::deleteDirectory('categories');

        //Crear carpetas para los seeders
        Storage::makeDirectory('articles');
        Storage::makeDirectory('categories');

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        Category::factory(8)->create();
        Article::factory(20)->create();
        Comment::factory(20)->create();

        
    }
}
