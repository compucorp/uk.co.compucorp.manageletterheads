(function ($, crmApi, crmStatus, ts, locationService) {
  $(document).ready(function () {
    var apiActions = getApiActionFunctions();

    $('.action-item.letterhead-enable').click(apiActions.enableLetterhead);
    $('.action-item.letterhead-delete').click(apiActions.deleteLetterhead);
    $('.action-item.letterhead-disable').click(apiActions.disableLetterhead);
  });

  /**
   * Generates a function that can be used to update the letterhead when clicking
   * on an action.
   *
   * When triggered, the function will call the given API action,
   * send the default letterhead data plus the letterhead ID and will display a
   * status message while the request is in progress. Once the request is done,
   * it will reload the page.
   *
   * @param {string} apiAction The Letterhead API action's name.
   * @param {object} actionData The default data to send to the API.
   * @param {object} messages Status messages.
   *
   * @returns {Function}
   */
  function getApiActionFactory(apiAction, actionData, messages) {
    return function executeApiAction () {
      var letterheadId = getLetterheadId(this);
      var promise = crmApi('Letterhead', apiAction, $.extend({}, actionData, {
        id: letterheadId
      }));

      crmStatus(messages, promise)
        .then(refreshListOfLetterheads);
    };
  }

  /**
   * Returns the list of actions for enabling, disabling, and deleting letterheads.
   *
   * @returns {object}
   */
  function getApiActionFunctions () {
    return {
      enableLetterhead: getApiActionFactory(
        'create',
        { is_active: '1' },
        {
          start: ts('Enabling...'),
          success: ts('Enabled'),
        }
      ),
      deleteLetterhead: getApiActionFactory(
        'delete',
        {},
        {
          start: ts('Deleting...'),
          success: ts('Deleted'),
        }
      ),
      disableLetterhead: getApiActionFactory(
        'create',
        { is_active: '0' },
        {
          start: ts('Disabling...'),
          success: ts('Disabled'),
        }
      )
    };
  }

  /**
   * Returns the letterhead ID as stored in the action's row element data attribute.
   *
   * @param {Element} actionsElementReference The action's link element reference.
   * @returns {string}
   */
  function getLetterheadId (actionsElementReference) {
    return $(actionsElementReference).parents('tr').data('letterhead-id');
  }

  /**
   * Refreshes the current page.
   */
  function refreshListOfLetterheads () {
    locationService.reload();
  }
})(CRM.$, CRM.api3, CRM.status, ts, window.locationService || window.location);
