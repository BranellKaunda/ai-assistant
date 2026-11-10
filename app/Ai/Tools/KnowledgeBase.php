<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\File;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class KnowledgeBase implements Tool
{
    /**
     * The knowledge files the assistant is allowed to read.
     *
     * @var list<string>
     */
    protected array $topics = ['about', 'contact', 'experience', 'project', 'technologies'];

    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Read the personal knowledge base about Branell. Available topics: '
            .'"about" for background, story and personal goals; '
            .'"contact" for links and ways to get in touch; '
            .'"experience" for work experience; '
            .'"project" for projects; '
            .'"technologies" for technologies and tools used.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $topic = $request->string('topic')->toString();

        if (! in_array($topic, $this->topics, true)) {
            return 'Unknown topic. Available topics: '.implode(', ', $this->topics).'.';
        } // the topic is the argument passed to the tool, it must match one of the topics in the $topics array

        $path = resource_path("ai-context/{$topic}.md");
        // the path to the context file is constructed using the topic argument, it is stored in the resources/ai-context directory

        if (! File::exists($path)) {
            return "No knowledge file found for \"{$topic}\".";
        }

        return File::get($path);
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'topic' => $schema->string()->enum($this->topics)->description('The knowledge topic to read.')->required(),
        ];
    }
}
