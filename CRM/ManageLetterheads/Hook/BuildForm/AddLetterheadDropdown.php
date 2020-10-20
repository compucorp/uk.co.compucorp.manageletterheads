<?php

/**
 * Adds the letterhead dropdown element to the Email and PDF Letter forms.
 *
 * The list of letterheads that should be visible for each form is also appended
 * as a configuration variable.
 */
class CRM_ManageLetterheads_Hook_BuildForm_AddLetterheadDropdown {

  /**
   * @var bool
   */
  private $isEmailForm = FALSE;

  /**
   * @var bool
   */
  private $isPdfLetterForm = FALSE;

  /**
   * Build Form hook handler.
   *
   * @param string $formName
   *   The name for the current form.
   * @param CRM_Core_Form $form
   *   The curernt form instance.
   */
  public function run ($formName, $form) {
    $this->isPdfLetterForm = get_class($form) === CRM_Contact_Form_Task_PDF::class;
    $this->isEmailForm = get_class($form) === CRM_Contact_Form_Task_Email::class;

    if (!$this->shouldRun()) {
      return;
    }

    $availableForName = $this->isEmailForm ? 'emails' : 'pdf_letters';
    $availableForValue = $this->getAvailableForValueFromName($availableForName);
    $letterheads = $this->getLetterheadsFromAvailableFor($availableForValue);

    $this->addListOfLetterheadOptionsToConfig($letterheads);
  }

  /**
   * Returns the "Available For" option value for the given name.
   *
   * @param string $optionName
   *   The name of the "Available For" option to return.
   * @return array
   */
  private function getAvailableForValueFromName($optionName) {
    $optionValue = civicrm_api3('OptionValue', 'getsingle', [
      'is_sequential' => '1',
      'option_group_id' => 'manageletterheads_available_for',
      'name' => $optionName,
    ]);

    return $optionValue['value'];
  }

  /**
   * Returns all the letterheads that belong to the given "Available For" value.
   *
   * Only active letterheads are returned, sorted by their weight.
   *
   * @param string $availableForValue
   *   The "Available For" value to filter letterheads by.
   */
  private function getLetterheadsFromAvailableFor($availableForValue) {
    $letterheads = [];
    $activeLetterheads = civicrm_api3('Letterhead', 'get', [
      'sequential' => '1',
      'is_active' => '1',
      'options' => ['sort' => 'weight ASC'],
    ]);

    foreach ($activeLetterheads['values'] as $letterhead) {
      if (in_array($availableForValue, $letterhead['available_for'])) {
        $letterheads[] = $letterhead;
      }
    }

    return $letterheads;
  }

  /**
   * Adds the given list of letterheads to a configuration variable.
   *
   * This configuration variable can be accessed by the front-end to build
   * the dropdown for the letterheads.
   *
   * The script to build this dropdown is also appended.
   *
   * @param array $letterheads
   *   A list of letterheads to add to the CiviCRM configuration.
   */
  private function addListOfLetterheadOptionsToConfig($letterheads) {
    CRM_Core_Resources::singleton()
      ->addScriptFile('uk.co.compucorp.manageletterheads', 'js/letterheads-dropdown.js')
      ->addSetting([
        'manageletterheads' => [
          'letterhead_options' => $letterheads,
        ],
      ]);
  }

  /**
   * Determines if the hook handler should run.
   *
   * Only runs for the Email or PDF Letter forms.
   *
   * @return bool
   */
  private function shouldRun () {
    return $this->isPdfLetterForm || $this->isEmailForm;
  }

}
