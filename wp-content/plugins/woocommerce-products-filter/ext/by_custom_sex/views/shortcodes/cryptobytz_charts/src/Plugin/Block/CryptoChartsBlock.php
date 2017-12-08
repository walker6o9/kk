<?php
/**
 * @file
 * Contains \Drupal\cryptobytz_api_access\Plugin\Block\CryptobitzBlock.
 */

namespace Drupal\cryptobytz_charts\Plugin\Block;

use Drupal\cryptobytz_api_access\Controller\GetbitfinController;
use Drupal\block\Controller\BlockController;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Url;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\field\Entity\FieldConfig;

/**
 * Provides a 'cryptobytz_charts' block.
 *
 * @Block(
 *   id = "cryptocharts_block",
 *   admin_label = @Translation("Crypto Charts"),
 *   category = @Translation("Custom crypto currency block data")
 * )
 */
class CryptoChartsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */

    public function build() {
    //  $get_block_data =

    }
}
