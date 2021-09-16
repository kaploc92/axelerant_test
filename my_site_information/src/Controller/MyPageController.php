<?php

namespace Drupal\my_site_information\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MyPageController.
 *
 * @package Drupal\my_site_information\Controller
 */
class MyPageController extends ControllerBase
{
  /**
   * Return json representation of a given node.
   *
   * @param string $siteapikey
   *   The site's api key.
   * @param string $nid
   *   The id of a given node
   *
   * @return string
   *   Return json represantation of a given node.
   */
  public function myPageJson($siteapikey, $nid)
  {
    $site_config = $this->config('system.site');
    $currentApiKey = $site_config->get('siteapikey');
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    if ($currentApiKey === "No API Key yet" || $siteapikey !==  $currentApiKey) {
      throw new AccessDeniedHttpException();
    } elseif (empty($node) || (!empty($node) && $node->getType() !== "page") ) {
      throw new AccessDeniedHttpException();
    }
    else {
      $serializer = \Drupal::service('serializer');
      $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);      
      return JsonResponse::fromJsonString($data);
    }
  }

}
