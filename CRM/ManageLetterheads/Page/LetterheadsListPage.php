<?php

use CRM_ManageLetterheads_BAO_LetterheadAvailability as LetterheadAvailability;

/**
 * LetterheadsListPage class.
 *
 * A page that displays the full list of letterheads.
 */
class CRM_ManageLetterheads_Page_LetterheadsListPage extends CRM_Core_Page {

  /**
   * @var array
   *   List of "Available For" labels, indexed by value.
   */
  private $availableForLabels;

  /**
   * Assigns the page's template values.
   */
  public function run() {
    $this->availableForLabels = LetterheadAvailability::buildOptions('available_for');

    $this->assign('letterheads', $this->getLetterheads());

    parent::run();
  }

  /**
   * Returns the full list of letterheads.
   *
   * The letterheads fields are formatted so they include values as rendered on
   * the template.
   *
   * @return array
   */
  private function getLetterheads() {
    $letterheads = civicrm_api3('Letterhead', 'get', [
      'sequential' => 1,
      'options' => [
        'limit' => 0,
        'sort' => 'weight ASC',
      ],
    ]);

    return array_map(
      [$this, 'getLetterheadViewValues'],
      $letterheads['values']
    );
  }

  /**
   * Returns the formatted values for a given letterhead.
   *
   * It returns the available for labels instead of their values as well as
   * "Yes" or "No" for the active field instead of using numerical values.
   *
   * @param array $letterhead
   *   The letterhead data as returned by the API.
   * @return array
   *   The formatted letterhead.
   */
  private function getLetterheadViewValues(array $letterhead) {
    $availableForLabels = $this->getAvailableForLabelsFromValues(
      $letterhead['available_for']
    );

    return [
      'id' => $letterhead['id'],
      'title' => $letterhead['title'],
      'description' => $letterhead['description'],
      'available_for' => implode($availableForLabels, ', '),
      'weight' => $letterhead['weight'],
      'is_active' => $letterhead['is_active'] === '1' ? ts('Yes') : ts('No'),
    ];
  }

  /**
   * Returns the labels for the given Available For values.
   *
   * @param array $optionValues
   *   A list of Available For values.
   * @return array
   *   A list of Available For labels.
   */
  private function getAvailableForLabelsFromValues(array $optionValues) {
    return array_map(
      function ($optionValue) {
        return $this->availableForLabels[$optionValue];
      },
      $optionValues
    );
  }

}
