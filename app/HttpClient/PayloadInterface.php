<?php

namespace App\HttpClient;

interface PayloadInterface
{
    public function getMethod();

    public function getUrl();
}
