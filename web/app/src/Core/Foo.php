<?php namespace Dopmn\Core;

class Foo
{
  private $name = 'Dopmn';

  public function getName(): string
  {
    return $this->name;
  }
}