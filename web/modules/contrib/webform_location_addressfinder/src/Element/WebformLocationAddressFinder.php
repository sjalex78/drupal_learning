<?php

namespace Drupal\webform_location_addressfinder\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Element\WebformLocationBase;

/**
 * Provides a webform element for a location addressfinder element.
 *
 * @FormElement("webform_location_addressfinder")
 */
class WebformLocationAddressFinder extends WebformLocationBase {

  /**
   * {@inheritdoc}
   */
  protected static $name = 'addressfinder';

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    return parent::getInfo() + [
      '#api_key' => '',
      '#no_postal' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getLocationAttributes() {
    return [
      "id" => t('ID'),
      "full_address" => t('Full address'),
      "street_number_1" => t('Street number 1'),
      "street_number_2" => t('Street number 2'),
      "lot_identifier" => t('Lot identifier'),
      "site_name" => t('Name'),
      "unit_identifier" => t('Unit identifier'),
      "unit_type" => t('Unit type'),
      "level_number" => t('Level number'),
      "level_type" => t('Level type'),
      "street_name" => t('Street name'),
      "street_type" => t('Street type'),
      "street_suffix" => t('Street suffix'),
      "street" => t('Street'),
      "locality_name" => t('Suburb'),
      "state_territory" => t('State/Province'),
      "canonical_address" => t('Canonical Address'),
      "canonical_address_id" => t('Canonical Address ID'),
      "postcode" => t('Postal Code'),
      "address_line_1" => t('Address line 1'),
      "address_line_2" => t('Address line 2'),
      "latitude" => t('Latitude'),
      "longitude" => t('Longitude'),
      "meshblock" => t('Meshblock'),
      "meshblock_2016" => t('Meshblock 2016'),
      "gnaf_id" => t('GNAF ID'),
      "dpid" => t('DPID'),
      "box_identifier" => t('Box identifier'),
      "box_type" => t('Box type'),
      "legal_parcel_id" => t('Legal parcel ID'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getCompositeElements(array $element) {
    $elements = parent::getCompositeElements($element);

    $elements['value']['#required'] = TRUE;

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function processWebformComposite(&$element, FormStateInterface $form_state, &$complete_form) {
    $element = parent::processWebformComposite($element, $form_state, $complete_form);

    $api_key = (!empty($element['#api_key'])) ? $element['#api_key'] : \Drupal::config('webform.settings')->get('element.default_addressfinder_api_key');
    $element['#attached']['drupalSettings']['webform']['location']['addressfinder'] = [
      'api_key' => $api_key,
    ];

    $no_postal = (!empty($element['#no_postal'])) ? $element['#no_postal'] : \Drupal::config('webform.settings')->get('element.no_postal');
    $element['#attached']['drupalSettings']['webform']['location']['addressfinder']['no_postal'] = $no_postal;

    $is_nz = (!empty($element['#is_nz'])) ? $element['#is_nz'] : \Drupal::config('webform.settings')->get('element.is_nz');
    $element['#attached']['drupalSettings']['webform']['location']['addressfinder']['is_nz'] = $is_nz;

    // Override the Webform library attachment from line 132 of
    // WebformLocationBase.
    // @TODO Create a patch against Webforms.
    $element['#attached']['library'][0] = 'webform_location_addressfinder/webform.element.location.addressfinder';

    return $element;
  }

}
