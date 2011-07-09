window.addEvent('domready', function() {
    document.formvalidator.setHandler('name',
		                      function (value) {
			                  regex=/^.*$/;
			                  return regex.test(value);
	                              });
    document.formvalidator.setHandler('alias',
		                      function (value) {
			                  regex=/^.*$/;
			                  return regex.test(value);
	                              });
});