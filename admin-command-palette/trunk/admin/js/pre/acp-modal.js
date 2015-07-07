var AcpModal;
window.AcpModal = AcpModal || {};

AcpModal = {

	modal: $('.admin-command-palette'),

	inputField: $('.admin-command-palette input[type=search]'),

	isOpen: function() {
		return AcpModal.modal.hasClass('open');
	},

	init: function() {
		var Mousetrap = window.Mousetrap || {};
		Mousetrap.bind('shift shift', function() {
			if (AcpModal.isOpen()) {
				AcpModal.close();
				return;
			}
			AcpModal.open();
		});
		Mousetrap.bind('esc', function() {
			if (AcpModal.isOpen()) {
				AcpModal.close();
			}
		});
	},
	
	open: function() {
		AcpModal.modal.addClass('open');
		AcpModal.inputField.focus();
	},
	
	close: function() {
		AcpModal.inputField.blur();
		AcpModal.inputField.val('');
		AcpModal.modal.removeClass('open');
	}

};

AcpModal.init();