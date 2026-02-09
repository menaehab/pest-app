<?php

use App\Models\Category;

beforeEach(function () {
    actUser($this);
    $this->category = Category::factory()->create();
});

test('check deletion category', function () {
    $response = $this->delete(route('categories.destroy', $this->category->id));
    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseMissing('categories', ['id' => $this->category->id]);
});
