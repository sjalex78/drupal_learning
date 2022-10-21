/**
 * @file
 * JavaScript behaviors for AddressFinder location integration.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  // @see https://github.com/algolia/places
  // @see https://community.algolia.com/places/documentation.html#options
  Drupal.webform = Drupal.webform || {};
  Drupal.webform.locationAddressFinder = Drupal.webform.locationAddressFinder || {};
  Drupal.webform.locationAddressFinder.options = Drupal.webform.locationAddressFinder.options || {};

  /**
   * Initialize location addressfinder.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.webformLocationAddressFinder = {
    attach: function (context) {

      var mapping = {
        id: '[identifier]-id',
        full_address: '[identifier]-full-address',
        street_number_1: '[identifier]-street-number-1',
        street_number_2: '[identifier]-street-number-2',
        lot_identifier: '[identifier]-lot-identifier',
        site_name: '[identifier]-site-name',
        unit_identifier: '[identifier]-unit-identifier',
        unit_type: '[identifier]-unit-type',
        level_number: '[identifier]-level-number',
        level_type: '[identifier]-level-type',
        street_name: '[identifier]-street-name',
        street_type: '[identifier]-street-type',
        street_suffix: '[identifier]-street-suffix',
        street: '[identifier]-street',
        locality_name: '[identifier]-locality-name',
        state_territory: '[identifier]-state-territory',
        canonical_address: '[identifier]-canonical-address',
        canonical_address_id: '[identifier]-canonical-address-id',
        postcode: '[identifier]-postcode',
        address_line_1: '[identifier]-address-line-1',
        address_line_2: '[identifier]-address-line-2',
        latitude: '[identifier]-latitude',
        longitude: '[identifier]-longitude',
        meshblock: '[identifier]-meshblock',
        meshblock_2016: '[identifier]-meshblock-2016',
        gnaf_id: '[identifier]-gnaf-id',
        dpid: '[identifier]-dpid',
        box_identifier: '[identifier]-box-identifier',
        box_type: '[identifier]-box-type',
        legal_parcel_id: '[identifier]-legal-parcel-id',
      };

      let addAddressfinder = function(fieldInput, fieldIdentifier) {
        let isNZ = drupalSettings.webform.location.addressfinder.is_nz;
        let countryCode = isNZ ? 'NZ' : 'AU';
        let extra = {
          "address_params": {
          }
        };

        if (drupalSettings.webform.location.addressfinder.no_postal) {
          if (isNZ) {
            // Unset things?
          }
          else {
            extra.address_params.gnaf = 1;
          }
        }

        let widget = new AddressFinder.Widget(
          document.getElementById($(fieldInput).attr('id')),
          drupalSettings.webform.location.addressfinder.api_key, countryCode, extra
        );

        widget.on('result:select', function (fullAddress, metaData) {
          $.each(mapping, function (source, destination) {
            let completeDestination = destination.replace('[identifier]', fieldIdentifier);
            let e = $('[data-drupal-selector="' + completeDestination + '"]');
            if (e) {
              let new_value = metaData[source] || '';
              if (new_value == '' && source == 'address_line_1') {
                new_value = metaData['street'];
              }

              $(e).val(new_value);
            }
          });
        });

        // Prevent the 'Enter' key from submitting the form.
        $(fieldInput).on('keydown', function (event) {
          if (event.keyCode === 13) {
            event.preventDefault();
          }
        });

        // Disable autocomplete.
        var isChrome = /Chrome/.test(window.navigator.userAgent) && /Google Inc/.test(window.navigator.vendor);
        $(fieldInput).attr('autocomplete', (isChrome) ? 'nothanks' : 'false');
      };

      $(context).find('.webform-location-addressfinder--wrapper').once('webform-location-addressfinder').each(function (idx, element) {

        let fieldInput = $(element).find('input.webform-location-addressfinder').first();
        let fieldIdentifier = $(element).attr('data-drupal-selector');

        addAddressfinder(fieldInput, fieldIdentifier);
      });

      $(context).find('.form-type-webform-location-addressfinder-fulladdressonly').once('webform-location-addressfinder').each(function (idx, element) {

        let fieldInput = $(element).find('input').first();
        let fieldIdentifier = $(element).attr('data-drupal-selector');

        addAddressfinder(fieldInput, fieldIdentifier);
      });
    }
  };

})(jQuery, Drupal, drupalSettings);
