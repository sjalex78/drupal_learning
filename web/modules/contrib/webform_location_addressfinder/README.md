Webform AddressFinder Readme
============================

This module implements integration between Webform and the AddressFinder
service (https://addressfinder.com.au/), providing autocompletion and
validation for addresses in Australia and New Zealand.

It requires registration with the AddressFinder service and the generation
of an API key on their website.

To use the module, install (composer require
drupal/webform_location_addressFinder) and enable it as you would any other
drupal module, then visit /admin/structure/webform/config/elements, tick the
checkbox next to "Location (AddressFinder)" in the Element Types table and save
the updated configuration. You can then add a "Location (AddressFinder)"
element in the configuration of a form. The AddressFinder API key is entered in
the element configuration, on the General tab, at the bottom of the 'Location
(AddressFinder) settings' section of the form.

The module was based on the Algolia Places plugin, and developed by Ladoo as
part of the build of a new site for Victoria's Road Safety Camera Commissioner
(https://cameracommissioner.vic.gov.au). The module has been released to the
public domain with the permission of the Commissioner.
