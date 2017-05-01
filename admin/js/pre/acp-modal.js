var AcpModal;
window.AcpModal = AcpModal || {};

AcpModal = {

	modal: $('.acp'),

	inputField: $('.acp input[type=search]'),

	isOpen: function() {
		return AcpModal.modal.hasClass('open');
	},

	init: function() {
		var Mousetrap = window.Mousetrap || {};
		Mousetrap.bindGlobal('shift shift', function() {
			AcpModal.toggle();
		});
		Mousetrap.bindGlobal('esc', function() {
			AcpModal.close();
		});
		$('body').on('click', '.acp-overlay.open', function() {
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
		$('.acp-results-count').addClass('hide');
	}

};

AcpModal.init();