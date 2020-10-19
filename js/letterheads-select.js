(($, _, letterheadOptions, ts) => {
  $(document).ready(function () {
    var $emailTemplateRow = $('.crm-contactEmail-form-block-template');
    var $pdfTemplateRow = $('select[name="template"]').parents('tr');
    var isEmailForm = $emailTemplateRow.length > 0;
    var options = isEmailForm
      ? { $templateRow: $emailTemplateRow, labelTdClass: 'label' }
      : { $templateRow: $pdfTemplateRow, labelClass: 'label-left' };

    appendLetterheadSelectRow(options);
  });

  /**
   * @param {LetterheadSelectRowOptions} options a list of options to use when
   *   appending the letterhead select row to the form.
   */
  function appendLetterheadSelectRow(options) {
    var $letterheadSelect = buildLetterheadSelect();
    var $letterheadSelectRow = $('<tr><td><label>Select Letterhead</label></td><td></td></tr>');

    $letterheadSelectRow.find('td:first').addClass(options.labelTdClass);
    $letterheadSelectRow.find('label').addClass(options.labelClass);
    $letterheadSelect.appendTo($letterheadSelectRow.find('td:last'));
    options.$templateRow.after($letterheadSelectRow);
  }

  /**
   * @return {object} a Select element with all the option values for the
   * letterheads stored in the configuration.
   */
  function buildLetterheadSelect () {
    var noneOption = { id: '', title: ts('None') };
    var optionTemplate = _.template('<option value="<%= id %>"><%= title %></option>');
    var selectHtml = '<select class="crm-form-select">' +
      _.chain(noneOption)
        .concat(letterheadOptions)
        .map(optionTemplate)
        .join('')
        .value()
      + '</select>';

    return $(selectHtml);
  }

  /**
   * @typedef {object} LetterheadSelectRowOptions
   *
   * @property {object} $templateRow The jQuery selector for the template field's parent row element.
   * @property {string} [labelClass] A class that will be applied directly to the label element.
   * @property {string} [labelTdClass] A class that will be applied to the label's parent TD element.
   */
})(CRM.$, CRM._, CRM.manageletterheads.letterhead_options, CRM.ts('uk.co.compucorp.manageletterheads'));
