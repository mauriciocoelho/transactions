<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Repositories\TransactionRepository;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function returns_a_successful_response()
    {
        $response = $this->get('/api/transactions');

        $response->assertStatus(200);
    }

}
