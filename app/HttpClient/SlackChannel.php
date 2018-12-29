<?php

namespace App\HttpClient;

class SlackChannel implements PayloadInterface, HasFormParameter
{
    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getUrl()
    {
        return getenv('SLACK_CHANNEL');
    }

    public function getMethod()
    {
        return 'post';
    }

    public function getFormParameter()
    {
        return [
            'payload' => json_encode([
                'text' => $this->text,
                'username' => 'Gitlab-Watcher',
            ], JSON_UNESCAPED_UNICODE),
        ];
    }
}
