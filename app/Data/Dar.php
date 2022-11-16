<?php 
namespace App\Data;

class Dar{
  private string $message;

  public function __construct(string $whatYouWantToSay)
  {
    $this->message = $whatYouWantToSay;
  }

  public function getMessage(): string{
    return $this->message;
  }
}
?>