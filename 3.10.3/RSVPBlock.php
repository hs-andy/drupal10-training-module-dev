<?php
/**
 * @file
 * Contains \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */
 namespace Drupal\rsvplist\Plugin\Block;
 
 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Session\AccountInterface;
 use Drupal\Core\Access\AccessResult;


 /**
 * Provides a 'RSVP' List Block
 *
 * @Block(
 *   id = "rsvp_block",
 *   admin_label = @Translation("RSVP Block"),
 *   category = @Translation("Blocks")
 * )
 */
class RSVPBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm');
    }

  /**
   * {@inheritdoc}
   */
  public function blockAccess(AccountInterface $account) {
    /** @var \Drupal\node\Entity\Node $node */
    $node = \Drupal::routeMatch()->getParameter('node');
    /** @var \Drupal\rsvplist\EnablerService $enabler */
    $enabler = \Drupal::service('rsvplist.enabler');
    if($node) {
      if($enabler->isEnabled($node)) {
        return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
      }
    }
    return AccessResult::forbidden();
  }
  
}

