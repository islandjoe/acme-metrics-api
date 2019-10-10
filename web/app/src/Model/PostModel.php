<?php namespace Dopmn\Model;

use Exception;

class PostModel
{
  public function getPage(int $num)
  {
    if ($num > 0 || $num < 11)
    {
      $posts = json_decode(
        \file_get_contents( APP.'src/View/api/p'.$num.'.json')
      );

      return $posts->data;
    }

    // TODO: Flash the message: 'Only between 1 and 10'
  }

}