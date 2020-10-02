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
    $this->add('text', 'title', ts('Title'));
    $this->add('textarea', 'description', ts('Description'));
    $this->add('wysiwyg', 'content', ts('Content'));
    $this->addCheckbox(
      'available_for',
      ts('Available For'),
      array_flip(LetterheadAvailability::buildOptions('available_for'))
    );
    $this->add('text', 'weight', ts('Order'));
    $this->addCheckbox('is_active', ts('Enabled'), ['' => '1']);

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ],
    ]);

    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
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
