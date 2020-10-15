(() => {
  CRM.status = jasmine.createSpy('crmStatus');

  CRM.status.and.callFake(fakeCrmStatus);

  /**
   * A mock function for the original CRM.status service.
   *
   * Returns a promise that can be manually resolved or rejected
   * during unit testing.
   *
   * @returns {Promise}
   */
  function fakeCrmStatus () {
    return new Promise ((resolve, reject) => {
      CRM.status.resolve = resolve;
      CRM.status.reject = reject;
    });
  }
})();
