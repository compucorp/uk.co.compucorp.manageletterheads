(() => {
  CRM.api3 = jasmine.createSpy('crmApi');

  CRM.api3.and.returnValue(Promise.resolve());
})();
