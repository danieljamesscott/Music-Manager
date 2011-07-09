window.addEvent('domready', function() {
    document.formvalidator.setHandler('album_id',
		                      function (value) {
			                  regex=/^[0-9]+$/;
			                  return regex.test(value);
	                              });
    document.formvalidator.setHandler('song_id',
		                      function (value) {
			                  regex=/^[0-9]+$/;
			                  return regex.test(value);
	                              });
});