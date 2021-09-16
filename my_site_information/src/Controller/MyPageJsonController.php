<?php

namespace Drupal\my_site_information\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\my_site_information\Controller\MyPageJsonController;

/**
 * Class MyPageJsonController.
 *
 * @package Drupal\my_site_information\Controller
 */
class MyPageJsonController extends ControllerBase
{
    /**
     * MyPageJson.
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
      return json_encode($node);
    }
  }

}
