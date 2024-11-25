<?php

namespace Framework;

class Response
{
    private $statusCode = 200;
    private $headers = [];
    private $body;

    public function setStatusCode(int $code): void
    {
        $this->statusCode = $code;
        http_response_code($code);
    }

    public function addHeader(string $name, string $value): void
    {
        $this->headers[] = [$name => $value];
    }

    public function setBody($content): void
    {
        $this->body = $content;
    }

    public function send(): void
    {
        foreach ($this->headers as $header) {
            foreach ($header as $name => $value) {
                header("$name: $value");
            }
        }

        if (is_array($this->body) || is_object($this->body)) {
            header('Content-Type: application/json');
            echo json_encode($this->body);
        } else {
            echo $this->body;
        }
    }
}
