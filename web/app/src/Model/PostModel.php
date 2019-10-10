<?php namespace Dopmn\Model;

use Exception;

class PostModel
{
  private $posts = [];

  public function getPage(int $num)
  {
    if ($num > 0 || $num < 11)
    {
      $this->posts = json_decode(
        \file_get_contents( APP.'src/View/posts/p'.$num.'.json')
      );

      return $this->posts->data;
    }

    // TODO: Flash the message: 'Only between 1 and 10'
  }

  public function getAllFromUser(string $id)
  {
    $posts = json_decode(
      \file_get_contents( APP.'src/View/posts/p'.$num.'.json')
    );


    foreach ($posts->data->posts as $post) {
      if ($post->from_id == $id)
      {
        $this->posts[] = $post;
      }
    }

    return $this->posts;
  }

}