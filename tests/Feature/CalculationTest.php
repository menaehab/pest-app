<?php

use App\Models\User;

BeforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    $this->actingAs($user);
});

describe('sum group', function () {
    test('calculate two numbers', function () {
        $a = 2;
        $b = 3;
        $sum = $a + $b;

        expect($sum)->toBe(5);
    });


    it('calculate two numbers', function () {
        $a = 2;
        $b = 3;
        $sum = $a + $b;

        expect($sum)->toBe(5);
    });

});


test('check home page works fine', function () {
    $response = $this->get('/');

    // $response->assertStatus(200);

    expect($response->status())->toBe(200)->toBeInt()->not->toBeString()->and(200)->toBeGreaterThan(199)->toBeLessThan(300);
    expect("Mena")->toBeMena();
});

dataset('users', [
    [
        ['name' => 'Mena', 'email' => 'test@test.com'],
        ['name' => 'Mena', 'email' => 'test1@test.com'],
        ['name' => 'Mena', 'email' => 'user@example.com'],
    ]
]);

test('check if email contains @ symbol', function ($user) {
    expect($user['email'])->toContain('@')->toBeString()->not->toBeInt();
    expect($user['name'])->toBe('Mena');
})->with('users')->skip(2 == 1, 'Skipping this test for demonstration purposes.')->group('email tests');


test('check if email contains @ symbol todo', function ($user) {
    expect($user['email'])->toContain('@')->toBeString()->not->toBeInt();
    expect($user['name'])->toBe('Mena');
})->with('users')->skip(2 == 1, 'Skipping this test for demonstration purposes.')->todo()->group('email tests');
