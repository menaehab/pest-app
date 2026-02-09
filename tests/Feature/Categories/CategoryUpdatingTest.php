<?php

use App\Models\Category;

beforeEach(function () {
    actUser($this);
    $this->category = Category::factory()->create();
});

test('check category updating page open successfully', function () {
    $response = $this->get(route('categories.edit', $this->category));
    $response->assertStatus(200);
});

test('check category update behavior', function (array $data, string $assertion) {
    $response = $this->put(route('categories.update', $this->category), $data);

    switch ($assertion) {
        case 'success':
            $response->assertRedirect(route('categories.index'));
            $this->assertDatabaseHas('categories', [
                'id' => $this->category->id,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);
            break;

        case 'name_required':
            $response->assertSessionHasErrors('name');
            break;

        case 'name_too_long':
            $response->assertSessionHasErrors('name');
            break;

        case 'description_too_long':
            $response->assertSessionHasErrors('description');
            break;

        case 'description_optional':
            $response->assertRedirect(route('categories.index'));
            $this->assertDatabaseHas('categories', [
                'id' => $this->category->id,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);
            break;
    }
})->with('category_update_cases');

dataset('category_update_cases', [
    'correct data' => [
        [
            'name' => 'Updated Category',
            'description' => 'This is an updated test category.',
        ],
        'success',
    ],

    'missing name' => [
        [
            'name' => '',
            'description' => 'This is an updated test category.',
        ],
        'name_required',
    ],

    'name too long' => [
        [
            'name' => str_repeat('a', 256),
            'description' => 'This is an updated test category.',
        ],
        'name_too_long',
    ],

    'description too long' => [
        [
            'name' => 'Updated Category',
            'description' => str_repeat('a', 1001),
        ],
        'description_too_long',
    ],

    'description optional' => [
        [
            'name' => 'Updated Category',
            'description' => null,
        ],
        'description_optional',
    ],
]);
