<?php

use App\Models\Category;

beforeEach(function () {
    actUser($this);
});

test('categories index page opens successfully', function () {
    $response = $this->get(route('categories.index'));

    $response
        ->assertOk()
        ->assertSee('Categories');
});

test('category details page opens successfully', function () {
    $category = Category::factory()->create();

    $response = $this->get(route('categories.show', $category));

    $response->assertOk();
});

test('all categories are retrieved and passed to the view', function () {
    $categories = Category::factory()->count(5)->create();

    $response = $this->get(route('categories.index'));

    $response
        ->assertOk()
        ->assertViewHas('categories', function ($viewCategories) use ($categories) {
            return $viewCategories->count() === $categories->count();
        });
});

test("category pagination works correctly", function () {
    Category::factory()->count(15)->create();

    $response = $this->get(route('categories.index'));

    $response
        ->assertOk()
        ->assertViewHas('categories', function ($viewCategories) {
            return $viewCategories->count() === 10; // Assuming pagination is set to 10 per page
        });
});
