<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class PostsTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Article::create([
            'title' => 'Article seeding',
            'body' => 'This article has been generated by the seeding system',
            'tags' => ['tag1', 'tag2'],
            'created_by' => User::ADMIN_NAME,
        ]);
    }
}
