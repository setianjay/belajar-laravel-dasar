<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function test_get_contoh_config(){
        $firstName = config('contoh.author.first_name');
        $lastName = config('contoh.author.last_name');
        $email = config('contoh.author.email');

        self::assertEquals("Hari", $firstName);
        self::assertEquals("Setiaji", $lastName);
        self::assertEquals("hari.setiaji2000@gmail.com", $email);
    }
}
