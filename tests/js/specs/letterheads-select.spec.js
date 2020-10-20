(($, crmWysiwyg) => {
  describe('Letterheads Select', () => {
    let $letterheadSelect, $letterheadSelectRow, $templateSelectRow, $messageEditor;

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

    describe('when selecting a letterhead', () => {
      beforeEach(() => {
        $('body').append(getEmailFormFixture());
        $().triggerBlockedOnReadyListeners();

        $letterheadSelect = $(':contains("Select Letterhead")').parents('tr').find('select');
        $messageEditor = $('.crm-form-wysiwyg');

        crmWysiwyg._create($messageEditor);
        crmWysiwyg.setVal(
          $messageEditor,
          'Example content'
        );
        $letterheadSelect.val('2');
        $letterheadSelect.trigger('change');
      });

      it('appends the letterhead to the message editor', () => {
        expect(crmWysiwyg.getVal($messageEditor))
          .toContain('<p>Welsh Letterhead</p>');
      });

      it('does not remove any existing content', () => {
        expect(crmWysiwyg.getVal($messageEditor))
          .toContain('Example content');
      });
    });

    describe('when selecting no letterhead', () => {
      beforeEach(() => {
        $('body').append(getEmailFormFixture());
        $().triggerBlockedOnReadyListeners();

        $letterheadSelect = $(':contains("Select Letterhead")').parents('tr').find('select');
        $messageEditor = $('.crm-form-wysiwyg');

        crmWysiwyg._create($messageEditor);
        crmWysiwyg.setVal(
          $messageEditor,
          'Example content'
        );
        $letterheadSelect.val('2');
        $letterheadSelect.trigger('change');
        $letterheadSelect.val('');
        $letterheadSelect.trigger('change');
      });

      it('does not contain a letterhead element', () => {
        expect(crmWysiwyg.getVal($messageEditor))
          .not.toContain('<p>Welsh Letterhead</p>');
      });

      it('does not remove any existing content', () => {
        expect(crmWysiwyg.getVal($messageEditor))
          .toContain('Example content');
      });
    });

    describe('when changing the current template', () => {
      beforeEach(() => {
        jasmine.clock().install();
        $('body').append(getEmailFormFixture());

        $().triggerBlockedOnReadyListeners();

        const $templateSelect = $('[name="template"]');
        $letterheadSelect = $(':contains("Select Letterhead")').parents('tr').find('select');
        $messageEditor = $('.crm-form-wysiwyg');

        crmWysiwyg._create($messageEditor);
        $letterheadSelect.val('2');
        $letterheadSelect.trigger('change');
        crmWysiwyg.setVal(
          $messageEditor,
          'Template content'
        );
        $templateSelect.trigger('change');
        CKEDITOR.instances.html_message.fire('change');
        jasmine.clock().tick();
      });

      afterEach(() => {
        jasmine.clock().uninstall();
      });

      it('preserves the letterhead element', () => {
        expect(crmWysiwyg.getVal($messageEditor))
          .toContain('<p>Welsh Letterhead</p>');
      });

      it('does not remove any existing content', () => {
        expect(crmWysiwyg.getVal($messageEditor))
          .toContain('Template content');
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
          <tr>
            <td colspan="2">
              <textarea name="html_message" class="crm-form-wysiwyg"></textarea>
            </td>
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
            <td colspan="2">
              <textarea name="html_message" class="crm-form-wysiwyg"></textarea>
            </td>
          </table>
        </div>
      `;
    }
  });
})(CRM.$, CRM.wysiwyg);
