<?php 
namespace App\Services;

class HalloServiceImpl implements HalloService{

  public function sayHello(string $name): string
  {
    return "Hallo $name";
  }
}
?>