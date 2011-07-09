window.addEvent('domready', function() {
    document.formvalidator.setHandler('artist_id',
		                      function (value) {
			                  regex=/^[0-9]+$/;
			                  return regex.test(value);
	                              });
    document.formvalidator.setHandler('album_id',
		                      function (value) {
			                  regex=/^[0-9]+$/;
			                  return regex.test(value);
	                              });
});