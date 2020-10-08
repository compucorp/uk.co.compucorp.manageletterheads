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
    $pager = $this->getPager();
    list($offset, $limit) = $pager->getOffsetAndRowCount();

    $this->assign_by_ref('pager', $pager);
    $this->assign('letterheads', $this->getLetterheads($offset, $limit));

    parent::run();
  }

  /**
   * Returns the pager object that can be used to paginate letterheads.
   *
   * @return CRM_Utils_Pager
   */
  private function getPager() {
    $totalLetterheads = civicrm_api3('Letterhead', 'getcount', []);
    $params['total'] = $totalLetterheads;
    $params['currentPage'] = $this->get(CRM_Utils_Pager::PAGE_ID);
    $params['rowCount'] = CRM_Utils_Pager::ROWCOUNT;
    $pager = new CRM_Utils_Pager($params);

    return $pager;
  }

  /**
   * Returns the full list of letterheads.
   *
   * The letterheads fields are formatted so they include values as rendered on
   * the template.
   *
   * @param $offset
   *   The offset record to start fetching letterheads from.
   * @param $limit
   *   The limit of letterheads to return.
   * @return array
   */
  private function getLetterheads($offset, $limit) {
    $letterheads = civicrm_api3('Letterhead', 'get', [
      'sequential' => 1,
      'options' => [
        'limit' => $limit,
        'offset' => $offset,
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
