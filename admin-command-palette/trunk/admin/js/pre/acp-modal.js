var AcpModal;
window.AcpModal = AcpModal || {};
AcpModal = {
	init: function() {
		var Mousetrap = window.Mousetrap || {};
		Mousetrap.bind('shift shift', function() {
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