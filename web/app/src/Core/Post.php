<?php namespace Dopmn\Core;

class Post
{
  private $id;
  private $created_time;
  private $from_id;
  private $from_name;
  private $message;
  private $type;

  public function __construct(
      string $id,
      string $created_time,
      string $from_id,
      string $from_name,
      string $message,
      string $type)
  {
    $this->id = $id;
    $this->created_time = $created_time;
    $this->from_id = $from_id;
    $this->from_name = $from_name;
    $this->message = $message;
    $this->type = $type;
  }

  public function getLength(): int
  {
    return \mb_strlen($this->message, 'UTF8');
  }

}