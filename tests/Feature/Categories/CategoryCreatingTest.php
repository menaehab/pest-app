<?php

beforeEach(function () {
    actUser($this);
});


test('check category creation page open successfully', function () {
    $response = $this->get(route('categories.create'));
    $response->assertStatus(200);
});


test('check category store behavior', function (array $data, string $assertion) {

    $response = $this->post(route('categories.store'), $data);

    match ($assertion) {
        'success' => $response
            ->assertRedirect(route('categories.index'))
        && $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
        ]),

        'name_required' => $response
            ->assertSessionHasErrors('name'),

        'name_too_long' => $response
            ->assertSessionHasErrors('name'),

        'description_too_long' => $response
            ->assertSessionHasErrors('description'),

        'description_optional' => $response
            ->assertRedirect(route('categories.index'))
        && $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
            'description' => null,
        ]),
    };

})->with('category_store_cases');


dataset('category_store_cases', [

    'correct data' => [
        [
            'name' => 'Test Category',
            'description' => 'This is a test category.',
        ],
        'success',
    ],

    'missing name' => [
        [
            'name' => '',
            'description' => 'This is a test category.',
        ],
        'name_required',
    ],

    'description optional' => [
        [
            'name' => 'Test Category',
            'description' => '',
        ],
        'description_optional',
    ],

    'name too long' => [
        [
            'name' => str_repeat('a', 256),
            'description' => 'This is a test category.',
        ],
        'name_too_long',
    ],

    'description too long' => [
        [
            'name' => 'Test Category',
            'description' => str_repeat('a', 1001),
        ],
        'description_too_long',
    ],

]);
