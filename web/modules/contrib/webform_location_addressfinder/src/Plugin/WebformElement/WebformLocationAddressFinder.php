<?php

namespace Drupal\webform_location_addressfinder\Plugin\WebformElement;

use Drupal\webform\Plugin\WebformElement\WebformLocationBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an 'location' element using AddressFinder.com.au.
 *
 * @WebformElement(
 *   id = "webform_location_addressfinder",
 *   label = @Translation("Location (AddressFinder)"),
 *   description = @Translation("Provides a form element to collect valid location information (address, etc) using addressfinder.com.au."),
 *   category = @Translation("Composite elements"),
 *   multiline = TRUE,
 *   composite = TRUE,
 *   states_wrapper = TRUE,
 * )
 */
class WebformLocationAddressFinder extends WebformLocationBase {

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
    return $this->elementManager->isExcluded('webform_location_addressfinder') ? $this->t('Location') : parent::getPluginLabel();
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['composite']['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('AddressFinder API key'),
    ];
    $default_api_key = \Drupal::config('webform.settings')->get('element.default_addressfinder_api_key');
    if ($default_api_key) {
      $form['composite']['api_key']['#description'] = $this->t('Defaults to: %value', ['%value' => $default_api_key]);
    }

    $form['composite']['is_nz'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Get addresses for New Zealand instead of Australia'),
    ];

    $form['composite']['no_postal'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Disable use of postal addresses'),
    ];

    return $form;
  }

}
