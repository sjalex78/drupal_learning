<?php

namespace Drupal\webform_location_addressfinder\Plugin\WebformElement;

use Drupal\webform\Plugin\WebformElement\TextField;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides an 'location' element using AddressFinder.com.au.
 *
 * @WebformElement(
 *   id = "webform_location_addressfinder_fulladdressonly",
 *   label = @Translation("Location (AddressFinder) - Full Address Only"),
 *   description = @Translation("Provides a form element to collect a valid address using addressfinder.com.au."),
 *   category = @Translation("Advanced elements"),
 * )
 */
class WebformLocationAddressFinderFullAddressOnly extends TextField {

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return [
      'api_key' => '',
      'no_postal' => FALSE,
      'is_nz' => FALSE,
      'placeholder' => '',
    ] + parent::getDefaultProperties();
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginLabel() {
    return $this->elementManager->isExcluded('webform_location_addressfinder_fulladdressonly') ? $this->t('Location') : parent::getPluginLabel();
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AddressFinder API key'),
    ];
    $default_api_key = \Drupal::config('webform.settings')->get('element.default_addressfinder_api_key');
    if ($default_api_key) {
      $form['api_key']['#description'] = $this->t('Defaults to: %value', ['%value' => $default_api_key]);
    }

    $form['is_nz'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Get addresses for New Zealand instead of Australia'),
    ];

    $form['no_postal'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable use of postal addresses'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function prepare(array &$element, WebformSubmissionInterface $webform_submission = NULL)
  {
    parent::prepare($element, $webform_submission);

    $api_key = (!empty($element['#api_key'])) ? $element['#api_key'] : \Drupal::config('webform.settings')->get('element.default_addressfinder_api_key');

    $element['#attached']['drupalSettings']['webform']['location']['addressfinder'] = [
      'api_key' => $api_key,
    ];

    $no_postal = (!empty($element['#no_postal'])) ? $element['#no_postal'] : \Drupal::config('webform.settings')->get('element.no_postal');
    $element['#attached']['drupalSettings']['webform']['location']['addressfinder']['no_postal'] = $no_postal;

    $is_nz = (!empty($element['#is_nz'])) ? $element['#is_nz'] : \Drupal::config('webform.settings')->get('element.is_nz');
    $element['#attached']['drupalSettings']['webform']['location']['addressfinder']['is_nz'] = $is_nz;
    $element['#attached']['library'][] = 'webform_location_addressfinder/webform.element.location.addressfinder';
  }

}
