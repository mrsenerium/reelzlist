<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $key;
    protected $model;

    public function __construct()
    {
        $this->key = config('services.openai.key');
        $this->model = config('services.openai.model');
    }

    public function respond(string $input): string
    {
        $key = config('services.openai.key');
        $model = config('services.openai.model');

        $res = Http::withToken($key)
            ->acceptJson()
            ->post('https://api.openai.com/v1/responses', [
                'model' => $model,
                'input' => [
                    [
                        'role' => 'system',
                        'content' => 'You are MovieGuess for Reelzlist. Your job is to guess movie titles from vague descriptions. ' . 
                        'If you are unsure, ask ONE short clarifying question. Do not invent movies. Please provide pithy remarks. Include year with movie title'
                    ],
                    [
                        'role' => 'user',
                        'content' => 'no it has Jonah hill'//$input
                    ]
                ],
            ]);

        if (!$res->successful()) {
            throw new \RuntimeException(
                'OpenAI error: '.$res->status().' '.$res->body()
            );
        }

        // Responses API returns output in a structured array; easiest is to pull the "output_text"
        // field if present, otherwise fall back to parsing.
        $json = $res->json();

        // Many Responses return a convenience field `output_text` (recommended to use when available).
        if (isset($json['output_text']) && is_string($json['output_text'])) {
            return $json['output_text'];
        }

        // Fallback: try to concatenate text segments.
        $text = '';
        foreach (($json['output'] ?? []) as $item) {
            foreach (($item['content'] ?? []) as $content) {
                if (($content['type'] ?? null) === 'output_text') {
                    $text .= ($content['text'] ?? '');
                }
            }
        }

        return trim($text);
    }

    public function listModels(): array
    {
        $response = Http::withToken($this->key)
            ->acceptJson()
            ->get('https://api.openai.com/v1/models');

        if (! $response->successful()) {
            throw new \RuntimeException(
                'OpenAI error: '.$response->status().' '.$response->body()
            );
        }

        return collect($response->json('data'))
            ->pluck('id')
            ->sort()
            ->values()
            ->all();
    }
}