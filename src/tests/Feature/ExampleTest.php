<?php
declare(strict_types=1);
# declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     * @return void
     */
    public function test_example(): void
    {
        $response = $this->postJson(route('api.sample'), [
            'user_name' => 'test',
            'user_age' => 16,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'content' => [
                    'message' => 'Successfully created user!',
                    'userProfile' => [
                        'name' => 'test',
                        'age' => 16,
                    ],
                ],
            ]);
    }

    public function hoge(): void
    {
        echo 40;
    }
}
