<?php

namespace App\Ai\Agents;

use App\Ai\Tools\KnowledgeBase;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\ProviderTool;
use Stringable;

class PersonalAssistant implements Agent, Conversational, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a helpful assistant that answers questions about Branell. Your only sources of information are the knowledge base topics: about, contact, experience, project and technologies. Read the relevant topic with the knowledge base tool before answering. Only answer questions that can be answered from these topics. If a question is not about Branell or is not covered by the knowledge base, politely say that you can only answer questions about Branell\'s background, contact details, experience, projects and technologies. You may form opinions based on the information in the knowledge base, but do not make up information.';
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return list<Agent|Tool|ProviderTool>
     */
    public function tools(): iterable
    {
        return [
            new KnowledgeBase,
        ];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    /* public function schema(JsonSchema $schema): array
    {
        return [
            'value' => $schema->string()->required(),
        ];
    } */
}
