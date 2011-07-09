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
    document.formvalidator.setHandler('creationyear',
		                      function (value) {
			                  regex=/^[0-9]+$/;
			                  return regex.test(value);
	                              });
    document.formvalidator.setHandler('albumart_front',
		                      function (value) {
			                  regex=/^.*$/;
			                  return regex.test(value);
	                              });
    document.formvalidator.setHandler('albumart_back',
		                      function (value) {
			                  regex=/^.*$/;
			                  return regex.test(value);
	                              });
});