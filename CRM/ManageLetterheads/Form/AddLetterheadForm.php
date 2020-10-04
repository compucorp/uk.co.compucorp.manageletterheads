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
    $this->preventAjaxSubmit();
    parent::buildQuickForm();
  }

  /**
   * Handles the letterhead creation process.
   */
  public function postProcess() {
    $formValues = $this->controller->exportValues($this->_name);

    $this->createLetterhead($formValues);
    $this->addSuccessMessage();
    $this->redirectToLetterheadsListPage();
  }

  /**
   * Creates the letterhead using the given form values.
   */
  private function createLetterhead($formValues) {
    $letterhead = [
      'title' => $formValues['title'],
      'description' => $formValues['description'],
      'content' => $formValues['content'],
      'available_for' => array_keys($formValues['available_for']),
      'weight' => $formValues['weight'],
      'is_active' => isset($formValues['is_active']) ? '1' : '0',
    ];

    civicrm_api3('Letterhead', 'create', $letterhead);
  }

  /**
   * Displays a success message after the letterhead has been created.
   */
  private function addSuccessMessage() {
    CRM_Core_Session::setStatus(
      ts('Letterhead has been saved.'),
      ts('Saved'),
      'success'
    );
  }

  /**
   * Redirects the user to the list page.
   */
  private function redirectToLetterheadsListPage() {
    $url = CRM_Utils_System::url('civicrm/letterheads/list', NULL, TRUE);

    CRM_Utils_System::redirect($url);
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
        'sort' => 'weight DESC',
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
