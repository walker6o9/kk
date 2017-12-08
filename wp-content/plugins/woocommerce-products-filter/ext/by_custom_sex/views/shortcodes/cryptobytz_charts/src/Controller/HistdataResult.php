<?php
/**
 * @file
 * Contains \Drupal\cryptobytz_charts\Controller\HistdataResult.
 */

namespace Drupal\cryptobytz_charts\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Utility\UrlHelper;
use Symfony\Component\HttpFoundation\Request;

class HistdataResult extends ControllerBase {
  public function getData() {

	//$content = getBitfinexCurrencies();

    return array(
        '#type' => 'markup',
        //'#markup' => drupal_render($content),
		'#markup' => '<div id="container" style="width:100%; height:400px;"></div>',
		//'#children' => $html
    );
  }
}
