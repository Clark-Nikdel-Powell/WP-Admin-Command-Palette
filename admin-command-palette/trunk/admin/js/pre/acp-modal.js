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
			AcpModal.toggle();
		});
		Mousetrap.bind('esc', function() {
			AcpModal.close();
		});
	},

	toggle: function() {
		if (AcpModal.isOpen()) {
			AcpModal.close();
		} else {
			AcpModal.open();
		}
	},

	open: function() {
		if (AcpModal.isOpen()) {
			return;
		}
		AcpModal.modal.addClass('open');
		AcpModal.inputField.focus();
	},

	close: function() {
		if (!AcpModal.isOpen()) {
			return;
		}
		AcpModal.inputField.blur();
		AcpModal.inputField.val('');
		AcpModal.modal.removeClass('open');
		$('.acp-results').addClass('hide');
		$('.acp-list').html('');
		$('.acp-count-info .amount').attr('data-amount', 0).html('');
		$('.admin-command-palette-results-count').addClass('hide');
	}

};

AcpModal.init();