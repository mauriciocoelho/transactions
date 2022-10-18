<?php

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

//Cria usuario com parametros
test('pode criar um usuario com parametros', function () {
    $attributes = Transaction::factory()->raw();
    $response = $this->postJson('/api/transactions', $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'transaction created successfully']);
});
//erro quando o título não é fornecido
test('erro quando o título não é fornecido', function () {
    $response = $this->postJson('/api/transactions', ['title' => 'Updated tite']);
    $response->assertStatus(422);
});
//erro quando o value não é fornecido
test('erro quando o value não é fornecido', function () {
    $response = $this->postJson('/api/transactions', ['value' => 'Updated tite']);
    $response->assertStatus(422);
});
//erro quando o type não é fornecido
test('erro quando o type não é fornecido', function () {
    $response = $this->postJson('/api/transactions', ['type' => 'Updated tite']);
    $response->assertStatus(422);
});
//erro quando nenhum parametro é fornecido
test('erro quando nenhum é fornecido', function () {
    $response = $this->postJson('/api/transactions', []);
    $response->assertStatus(422);
});
//Recuperar a transação
test('pode recuperar uma transacao', function () {
    $transaction = Transaction::factory()->create();
    $response = $this->getJson("/api/transactions/{$transaction->id}");

    $data = [
        'message' => 'transaction fetched successfully',
        'data' => [
            'id' => $transaction->id,
            'title' => $transaction->title,
            'value' => $transaction->value,
            'type' => $transaction->type,
        ]
    ];

    $response->assertStatus(200)->assertJson($data);
});
//não pode buscar a transacao com id incorreto
test('não busca a transacao com id incorreto', function () {
    $transaction = Transaction::factory()->create();
    $wrongId = $transaction->id;
    $response = $this->getJson("/api/transactions/{$wrongId}");
    $response->assertStatus(200);
});
//pode atualizar a transacao
test('pode atualizar um transacao', function () {
    $transaction = Transaction::factory()->create();

    $transactionUpdate = [
        'id' => $transaction->id,
        'title' => $transaction->title,
        'value' => $transaction->value,
        'type' => $transaction->type,
    ];

    $response = $this->putJson("/api/transactions/{$transaction->id}", $transactionUpdate);
    $response->assertStatus(201)->assertJson(['message' => 'transaction updated successfully']);
    $this->assertDatabaseHas('transactions', $transactionUpdate);
});
//Apagar Usuário
test('pode apagar uma transacao', function () {
    $transaction = Transaction::factory()->create();
    $response = $this->deleteJson("/api/transactions/{$transaction->id}");
    $response->assertStatus(200)->assertJson(['message' => 'transaction deleted successfully']);
    $this->assertCount(0, Transaction::all());
});
