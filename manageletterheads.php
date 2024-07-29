<?php

use CRM_ManageLetterheads_Hook_BuildForm_AddLetterheadDropdown as AddLetterheadDropdown;
use CRM_ManageLetterheads_Hook_AlterAPIPermissions_AddLetterheadPermissions as AddLetterheadPermissions;

require_once 'manageletterheads.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function manageletterheads_civicrm_config(&$config) {
  _manageletterheads_civix_civicrm_config($config);

  Civi::dispatcher()->addListener(
    'civi.api.respond',
    ['CRM_ManageLetterheads_Event_Listener_LetterheadExtraFields', 'onRespond'],
    10
  );
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function manageletterheads_civicrm_install() {
  _manageletterheads_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function manageletterheads_civicrm_enable() {
  _manageletterheads_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_permission().
 */
function manageletterheads_civicrm_permission(&$permissions) {
  $permissions['manage letterheads'] = [
    ts('CiviCRM: manage letterheads'),
    ts('Allows managing of a list of letterheads that can be selected by users when creating emails and PDF letters'),
  ];
}

/**
 * Implements hook_civicrm_buildForm().
 */
function manageletterheads_civicrm_buildForm($formName, $form) {
  $hooks = [
    new AddLetterheadDropdown(),
  ];

  foreach ($hooks as $hook) {
    $hook->run($formName, $form);
  }
}

/**
 * Implements hook_civicrm_alterAPIPermissions().
 */
function manageletterheads_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions) {
  $hooks = [
    new AddLetterheadPermissions(),
  ];

  foreach ($hooks as $hook) {
    $hook->run($entity, $action, $params, $permissions);
  }
}
