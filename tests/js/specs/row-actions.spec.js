(($, _, crmApi, crmStatus, locationService) => {
  describe('Row Actions', () => {
    let fixture, letterheadId, originalWindow;

    beforeEach(() => {
      letterheadId = parseInt(_.uniqueId(), 10);
      fixture = `
        <table>
          <tr data-letterhead-id="${letterheadId}">
            <td>
              <a class="action-item letterhead-delete">Delete</a>
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
  });
})(CRM.$, CRM._, CRM.api3, CRM.status, window.locationService);
