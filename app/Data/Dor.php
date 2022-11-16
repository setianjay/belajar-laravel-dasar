<?php 
namespace App\Data;

class Dor{
  private Dar $dar;
  public function __construct(Dar $dar)
  {
    $this->dar = $dar;
  }

  public function saySomething(): string{
    return $this->dar->getMessage();
  }
}
?>