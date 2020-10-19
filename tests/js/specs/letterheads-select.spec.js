(($) => {
  describe('Letterheads Select', () => {
    let $letterheadSelectRow, $templateSelectRow;

    afterEach(() => {
      $('body').empty();
    });

    describe('Email Form', () => {
      beforeEach(() => {
        $('body').append(getEmailFormFixture());
        $().triggerBlockedOnReadyListeners();

        $letterheadSelectRow = $(':contains("Select Letterhead")').parents('tr');
        $templateSelectRow = $('.crm-contactEmail-form-block-template');
      });

      it('adds the letterhead select after the template field row', () => {
        expect($letterheadSelectRow.prev().is($templateSelectRow)).toBe(true);
      });

      it('adds a "None" option to the list of letterheads', () => {
        expect($letterheadSelectRow.find('option[value=""]').text()).toBe('None');
      });

      it('adds the full list of letterheads to the select options', () => {
        expect($letterheadSelectRow.find('option[value=1]').text()).toBe('Letterhead (English)');
        expect($letterheadSelectRow.find('option[value=2]').text()).toBe('Letterhead (Welsh)');
        expect($letterheadSelectRow.find('option[value=3]').text()).toBe('Letterhead (French)');
      });
    });

    describe('PDF Form', () => {
      beforeEach(() => {
        $('body').append(getPdfFormFixture());
        $().triggerBlockedOnReadyListeners();

        $letterheadSelectRow = $(':contains("Select Letterhead")').parents('tr');
        $templateSelectRow = $('select[name="template"]').parents('tr');
      });

      it('adds the letterhead select after the template field row', () => {
        expect($letterheadSelectRow.prev().is($templateSelectRow)).toBe(true);
      });

      it('adds a "None" option to the list of letterheads', () => {
        expect($letterheadSelectRow.find('option[value=""]').text()).toBe('None');
      });

      it('adds the full list of letterheads to the select options', () => {
        expect($letterheadSelectRow.find('option[value=1]').text()).toBe('Letterhead (English)');
        expect($letterheadSelectRow.find('option[value=2]').text()).toBe('Letterhead (Welsh)');
        expect($letterheadSelectRow.find('option[value=3]').text()).toBe('Letterhead (French)');
      });
    });

    function getEmailFormFixture() {
      return `
        <table>
          <tr class="crm-contactEmail-form-block-template">
            <td class="label">
              <label>Use Template</label>
            </td>
            <td><select name="template"></select></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </table>
      `;
    }

    function getPdfFormFixture() {
      return `
        <div class="crm-contact-task-pdf-form-block">
          <table>
            <tr>
              <td class="label-left">
                <label>Use Template</label>
              </td>
              <td><select name="template"></select></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
            </tr>
          </table>
        </div>
      `;
    }
  });
})(CRM.$);
