<?php

use CRM_ManageLetterheads_BAO_LetterheadAvailability as LetterheadAvailability;

/**
 * Create Letterhead Form class.
 */
class CRM_ManageLetterheads_Form_AddLetterheadForm extends CRM_Core_Form {

  /**
   * Adds the form fields and buttons.
   */
  public function buildQuickForm() {
    $this->addFormElements();
    $this->setDefaultWeight();
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Adds the form elements including fields and buttons.
   */
  private function addFormElements() {
    $this->add('text', 'title', ts('Title'), NULL, TRUE);
    $this->add('textarea', 'description', ts('Description'));
    $this->add('wysiwyg', 'content', ts('Content'), NULL, TRUE);
    $this->addCheckbox(
      'available_for',
      ts('Available For'),
      array_flip(LetterheadAvailability::buildOptions('available_for')),
      NULL,
      NULL,
      TRUE
    );
    $this->add('text', 'weight', ts('Order'));
    $this->addCheckbox(
      'is_active',
      ts('Enabled'),
      ['' => 1],
      NULL,
      ['checked' => 'checked']
    );

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ],
    ]);
  }

  /**
   * Sets the default value of the "order" (weight) field.
   *
   * The value is the highest weight value currently recorded, plus 1.
   */
  private function setDefaultWeight() {
    $lastLetterheadWeightValue = 0;
    $lastLetterheadByWeight = civicrm_api3('Letterhead', 'get', [
      'sequential' => 1,
      'options' => [
        'limit' => '1',
        'order_by' => 'weight DESC',
      ],
    ]);

    if ($lastLetterheadByWeight['count']) {
      $lastLetterheadWeightValue = $lastLetterheadByWeight['values'][0]['weight'];
    }

    $this->setDefaults([
      'weight' => $lastLetterheadWeightValue + 1,
    ]);
  }

  /**
   * Returns the list of names of form elements that will be visible to the user.
   *
   * @return array (string)
   */
  private function getRenderableElementNames() {
    $elementNames = [];

    foreach ($this->_elements as $element) {
      $label = $element->getLabel();

      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }

    return $elementNames;
  }

}
