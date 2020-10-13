(($, _, crmApi, crmStatus, locationService) => {
  describe('Row Actions', () => {
    let fixture, letterheadId, originalWindow;

    beforeEach(() => {
      letterheadId = parseInt(_.uniqueId(), 10);
      fixture = `
        <table>
          <tr data-letterhead-id="${letterheadId}">
            <td>
              <a class="action-item letterhead-enable">Enable</a>
              <a class="action-item letterhead-delete">Delete</a>
              <a class="action-item letterhead-disable">Disable</a>
            </td>
          </tr>
        </table>
      `;

      originalWindow = window;
      window = {
        location: jasmine.createSpyObj('location', ['reload'])
      };

      $('body').append(fixture);
      $().triggerBlockedOnReadyListeners();
    });

    afterEach(() => {
      window = originalWindow;

      $('body').empty();
    });

    describe('when clicking a enable letterhead action', () => {
      beforeEach(() => {
        $('.letterhead-enable').click();
      });

      it('displays a enabling letterhead message', () => {
        expect(crmStatus).toHaveBeenCalledWith(
          jasmine.objectContaining({ start: ts('Enabling...') }),
          jasmine.any(Object)
        );
      });

      it('enables the letterhead', () => {
        expect(crmApi).toHaveBeenCalledWith('Letterhead', 'create', {
          id: letterheadId,
          is_active: '1'
        });
      });

      describe('after enabling the letterhead', () => {
        beforeEach((done) => {
          crmStatus.resolve();
          setTimeout(done);
        });

        it('displays a enabled letterhead message', () => {
          expect(crmStatus).toHaveBeenCalledWith(
            jasmine.objectContaining({ success: ts('Enabled') }),
            jasmine.any(Object)
          );
        });

        it('refreshes the page', () => {
          expect(locationService.reload).toHaveBeenCalledWith();
        });
      });
    });

    describe('when clicking a delete letterhead action', () => {
      beforeEach(() => {
        $('.letterhead-delete').click();
      });

      it('displays a deleting letterhead message', () => {
        expect(crmStatus).toHaveBeenCalledWith(
          jasmine.objectContaining({ start: ts('Deleting...') }),
          jasmine.any(Object)
        );
      });

      it('deletes the letterhead', () => {
        expect(crmApi).toHaveBeenCalledWith('Letterhead', 'delete', {
          id: letterheadId
        });
      });

      describe('after deleting the letterhead', () => {
        beforeEach((done) => {
          crmStatus.resolve();
          setTimeout(done);
        });

        it('displays a deleted letterhead message', () => {
          expect(crmStatus).toHaveBeenCalledWith(
            jasmine.objectContaining({ success: ts('Deleted') }),
            jasmine.any(Object)
          );
        });

        it('refreshes the page', () => {
          expect(locationService.reload).toHaveBeenCalledWith();
        });
      });
    });

    describe('when clicking a disable letterhead action', () => {
      beforeEach(() => {
        $('.letterhead-disable').click();
      });

      it('displays a disabling letterhead message', () => {
        expect(crmStatus).toHaveBeenCalledWith(
          jasmine.objectContaining({ start: ts('Disabling...') }),
          jasmine.any(Object)
        );
      });

      it('disables the letterhead', () => {
        expect(crmApi).toHaveBeenCalledWith('Letterhead', 'create', {
          id: letterheadId,
          is_active: '0'
        });
      });

      describe('after disabling the letterhead', () => {
        beforeEach((done) => {
          crmStatus.resolve();
          setTimeout(done);
        });

        it('displays a disabled letterhead message', () => {
          expect(crmStatus).toHaveBeenCalledWith(
            jasmine.objectContaining({ success: ts('Disabled') }),
            jasmine.any(Object)
          );
        });

        it('refreshes the page', () => {
          expect(locationService.reload).toHaveBeenCalledWith();
        });
      });
    });
  });
})(CRM.$, CRM._, CRM.api3, CRM.status, window.locationService);
