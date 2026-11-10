<?php

use App\Ai\Agents\PersonalAssistant;
use App\Ai\Tools\KnowledgeBase;
use Laravel\Ai\Tools\Request;

test('the assistant answers a question through the api', function () {
    PersonalAssistant::fake(['Branell is a full-stack developer.']);

    $this->postJson('/api/assistant', ['question' => 'Who is Branell?'])
        ->assertOk()
        ->assertExactJson(['answer' => 'Branell is a full-stack developer.']);

    PersonalAssistant::assertPrompted('Who is Branell?');
});

test('the assistant api requires a question', function () {
    $this->postJson('/api/assistant', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['question']);
});

test('the assistant api rejects questions that are too long', function () {
    $this->postJson('/api/assistant', ['question' => str_repeat('a', 501)])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['question']);
});

test('the assistant api is rate limited per ip', function () {
    PersonalAssistant::fake(['Answer.']);

    for ($attempt = 0; $attempt < 5; $attempt++) {
        $this->postJson('/api/assistant', ['question' => 'Hello?'])->assertOk();
    }

    $this->postJson('/api/assistant', ['question' => 'Hello?'])->assertTooManyRequests();
});

test('the knowledge base reads every topic file', function () {
    foreach (['about', 'contact', 'experience', 'project', 'technologies'] as $topic) {
        $content = (new KnowledgeBase)->handle(new Request(['topic' => $topic]));

        expect((string) $content)->not->toBeEmpty()->not->toContain('No knowledge file found');
    }
});

test('the knowledge base describes every topic it can read', function () {
    $description = (new KnowledgeBase)->description();

    foreach (['about', 'contact', 'experience', 'project', 'technologies'] as $topic) {
        expect($description)->toContain("\"{$topic}\"");
    }
});
