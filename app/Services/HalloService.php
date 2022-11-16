<?php
namespace App\Services;

interface HalloService{
  public function sayHello(string $name): string;
}
?>