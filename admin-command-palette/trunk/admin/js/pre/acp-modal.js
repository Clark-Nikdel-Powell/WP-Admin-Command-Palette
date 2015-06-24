(function( $ ) {
	'use strict';

	window.AcpModal = {
		init: function() {
			Mousetrap.bind('shift shift', function(e) {
				AcpModal.open();
				$('.admin-command-palette input[type=search]').focus();
			});
			console.log('init');
		},
		open: function() {
			var acp = $('.admin-command-palette');
			acp.addClass('open');
			console.log('open');
		},
		close: function() {
			var acp = $('.admin-command-palette');
			acp.removeClass('open');
			console.log('close');
		}
	};

})( jQuery );