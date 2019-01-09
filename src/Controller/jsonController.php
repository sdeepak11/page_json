<?php

namespace Drupal\page_json\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;

/**
 * Defines jsonController class.
 */
class JsonController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function jsonNode($apikey, $id) {
    $siteapikey = \Drupal::state()->get('siteapikey');

    // Loading all nids of type 'page'.
    $nids = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page', 'status' => '1']);

    if (($siteapikey) != NULL && $siteapikey == $apikey && array_key_exists($id, $nids)) {
      $node = Node::load($id);
      return new JsonResponse((array) $node, 200, ['Content-Type' => 'application/json']);
    }
    else {
      return new JsonResponse(["Access Denied"], 401, ['Content-Type' => 'application/json']);
    }
  }
}
