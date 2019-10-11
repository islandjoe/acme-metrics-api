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

    $page = function() {
      foreach (range(1, 2) as $num)
      {

        $_page = json_decode(
        \file_get_contents( APP.'src/View/posts/p'.$num.'.json')
        );
        yield $_page->data->posts;
      }
    };

    $usersPosts = [];
    foreach ($page() as $_posts)
    { /// $_post: ->posts, ->page ///

        foreach ($_posts as $_post) {
          // \var_export($_post);
          // var_dump( $_post[0]->from_id);
          if ($_post->from_id === $id)
          {
            $usersPosts[] = $_post;
          }
        }
    }

    return $usersPosts;
  }

}