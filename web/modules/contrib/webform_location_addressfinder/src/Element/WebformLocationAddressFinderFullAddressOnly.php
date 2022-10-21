<?php

namespace Drupal\webform_location_addressfinder\Element;

use Drupal\Core\Render\Element\Textfield;

/**
 * Provides a webform element for a location addressfinder element.
 *
 * This version only provides a single field, so you can use it in composites.
 *
 * @FormElement("webform_location_addressfinder_fulladdressonly")
 */
class WebformLocationAddressFinderFullAddressOnly extends Textfield {

  /**
   * {@inheritdoc}
   */
  protected static $name = 'addressfinderfulladdressonly';

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return parent::getInfo() + [
      '#api_key' => '',
      '#no_postal' => FALSE,
    ];
  }

}
