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

  public function getAllFromUser(string $id): array
  {

    $page = function() {
      foreach (range(1, 2) as $num)
      {

        $_page = json_decode(
        \file_get_contents( APP.'src/View/posts/p'.$num.'.json')
        );
        yield $_page->data->posts;
      }
    };

    // TODO: 👀
    foreach ($page() as $_posts)
    {
      foreach ($_posts as $_post)
      {
        if ($_post->from_id === $id)
        {
          $this->posts[] = $_post;
        }
      }
    }

    return $this->posts;
  }

}