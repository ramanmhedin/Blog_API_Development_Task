<?php

use App\Models\Category;
use App\Services\ActivityLogService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
beforeEach(function () {
    Artisan::call('migrate');
});
afterEach(function () {
    Artisan::call('migrate:reset');
});

uses(TestCase::class);




test('can store category', function () {
    $data = ['name' => 'New Category'];

    $category = categoryService()->store($data);

    expect($category)->name->toBe('New Category')
        ->and($category)->slug->toBe('new-category');
    $this->assertDatabaseHas('categories', $data);
});

test('can show category', function () {
    $category = Category::factory()->create();

    $fetched = categoryService()->show($category->id);

    expect($fetched->id)->toBe($category->id);
    $this->assertDatabaseHas('categories', ['id'=>$category->id]);

});

test('can update category', function () {
    $category = Category::factory()->create(['name' => 'Old']);

    $updated = categoryService()->update(['name' => 'Updated'], $category->id);

    expect($updated->name)->toBe('Updated');
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

test('can destroy category', function () {
    $category = Category::factory()->create();

    $deleted = categoryService()->destroy($category->id);
    expect($deleted)->name->toBe($category->name);
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

test('can filter categories using search', function () {
    Category::factory()->create(['name' => 'Vue']);
    Category::factory()->create(['name' => 'Laravel']);

    $results = categoryService()->index(['search' => 'Vue']);

    expect($results->count())->toBe(1)
        ->and($results->items()[0]->name)->toBe('Vue');
});

test('can Log Activity while categories create', function () {
    $category=Category::factory()->create();

    $activityLog=activityLogService()->index([
        "type_of_action" => 'CREATE',
        "entity_type" => 'Category',
        "entity_id" => $category->id,
    ]);

    expect($activityLog[0]->entity_id)->toBe($category->id);
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

test('can Log Activity while categories read', function () {
    $categoryCreate = Category::factory()->create();
    $category = categoryService()->show($categoryCreate->id);
    $activityLog=activityLogService()->index([
        "type_of_action" => 'READ',
        "entity_type" => 'Category',
        "entity_id" => $category->id,
    ]);

    expect($activityLog[0]->entity_id)->toBe($category->id);
});

test('can Log Activity while categories update', function () {
    $category = Category::factory()->create(['name' => 'Old']);

    categoryService()->update(['name' => 'test '.rand(0,100)], $category->id);
    $activityLog=activityLogService()->index([
        "type_of_action" => 'UPDATE',
        "entity_type" => 'Category',
        "entity_id" => $category->id,
    ]);

    expect($activityLog[0]->entity_id)->toBe($category->id);
    $this->assertDatabaseHas('categories', ['id' => $category->id]);
});

test('can Log Activity while categories delete', function () {
    $category = Category::factory()->create();
    categoryService()->destroy($category->id);
    $activityLog=activityLogService()->index([
        "type_of_action" => 'DELETE',
        "entity_type" => 'Category',
        "entity_id" => $category->id,
    ]);

    expect($activityLog[0]->entity_id)->toBe($category->id);
});

