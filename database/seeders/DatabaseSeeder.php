<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tags = Tag::factory(15)->create();

        Article::factory(60)
            ->recycle($users)
            ->create()
            ->each(function (Article $article) use ($tags, $users) {
                $article->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')
                );

                Comment::factory(rand(8, 12))
                    ->recycle($users)
                    ->for($article)
                    ->create();
            });
    }
}
