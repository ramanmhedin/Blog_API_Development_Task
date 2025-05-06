<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\PostService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

beforeEach(function () {
    Artisan::call('migrate');
});
afterEach(function () {
    Artisan::call('migrate:reset');
});

uses(TestCase::class);


test('can store post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $data = [
        'title' => 'Test Post',
        'content' => 'This is test content',
        'category_id' => $category->id,
    ];

    $post = postService()->store($data);

    expect($post)->title->toBe('Test Post')
        ->and($post->author_id)->toBe($user->id);
});

test('can show post', function () {
    $post = Post::factory()->create();

    $foundPost = postService()->show($post->id);

    expect($foundPost->id)->toBe($post->id);
});



test('can update post', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $data = [
        'title' => 'Test Post',
        'content' => 'This is test content',
        'category_id' => $category->id,
    ];
    $post = Post::factory()->create($data);

    $updated = postService()->update(['title' => 'Updated','content'=>'Updated'], $post->id);

    expect($updated->title)->toBe('Updated');
    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

test('can delete own post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['author_id' => $user->id]);
    $this->actingAs($user);

    $deleted = postService()->destroy($post->id);

    expect($deleted->id)->toBe($post->id);

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('can filter posts using search', function () {
    Post::factory()->create(['title' => 'Vue']);
    Post::factory()->create(['title' => 'Laravel']);

    $results = postService()->index(['search' => 'Vue']);

    expect($results->count())->toBe(1)
        ->and($results->items()[0]->title)->toBe('Vue');
});

test('can Log Activity while posts create', function () {
    $post=Post::factory()->create();

    $activityLog = activityLogService()->index([
        "type_of_action" => 'CREATE',
        "entity_type" => 'Post',
        "entity_id" => $post->id,
    ]);

    expect($activityLog[0]->entity_id)->toBe($post->id);
    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

test('can Log Activity while posts read', function () {
    $postsCreate = Post::factory()->create();
    $post = postService()->show($postsCreate->id);
    $activityLog=activityLogService()->index([
        "sort" => "desc",
        "sort_by" =>"id",
        "per_page" => 1
    ]);

    expect($activityLog[0]->entity_id)->toBe($post->id)
        ->and($activityLog->count())->toBe(1)
        ->and($activityLog[0]->type_of_action)->toBe('READ');
});

test('can Log Activity while posts update', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $post = Post::factory()->create();

    postService()->update(['title' => 'Update '.rand(0,100)], $post->id);

    $activityLog=activityLogService()->index([
        "sort" => "desc",
        "sort_by" =>"id",
        "per_page" => 1
    ]);

    expect($activityLog[0]->entity_id)->toBe($post->id)
        ->and($activityLog->count())->toBe(1)
        ->and($activityLog[0]->type_of_action)->toBe('UPDATE');

    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

test('can Log Activity while posts delete', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $post = Post::factory()->create();
    postService()->destroy($post->id);
    $activityLog=activityLogService()->index([
        "sort" => "desc",
        "sort_by" =>"id",
        "per_page" => 1
    ]);
    expect($activityLog[0]->entity_id)->toBe($post->id)
        ->and($activityLog->count())->toBe(1)
        ->and($activityLog[0]->type_of_action)->toBe('DELETE');
});

