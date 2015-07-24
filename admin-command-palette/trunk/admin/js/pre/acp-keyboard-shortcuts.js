// Keyboard Shortcuts set up via Mousetrap.
// Copied from class-admin-command-palette-admin-actions.php for sake of time.
// Will refactor in a DRY way later.

function focus_check() {

	jQuery(document).ready(function($) {

		if ( 1 === $( "input:focus" ).length ) {
			return;
		}

	});

}

// ESC triggers a blur of inputs, but closes the ACP Modal
Mousetrap.bind('esc', function() {

	if ( 1 === $('.admin-command-palette input:focus').length ) {
		AcpModal.close();
	}

	$('input').trigger('blur');

});

// Add New Whatever
if (1 === $('a.add-new-h2').length) {

	Mousetrap.bind('n', function() {

		focus_check();
		window.location.replace($('a.add-new-h2').attr('href'));

	});

}

// Open Post/Page in New Tab
Mousetrap.bind('shift+v', function() {

	focus_check();

	var url = $("#view-post-btn a").attr('href');
	window.open(url,'_blank');

});

// Preview
Mousetrap.bind('shift+p', function() {

	focus_check();
	if (1 === $('.preview').length) {
		$('.preview')[0].click();
	}

});

// Submit Form
Mousetrap.bind('shift+s', function() {

	focus_check();

	if (1 === $('#publish').length) {
		$('#publish')[0].click();
	}
	else if (1 === $('#submit').length) {
		$('#submit')[0].click();
	}
	else if (1 === $('#createusersub').length) {
		$('#createusersub')[0].click();
	}
	else if (1 === $('a.button-primary').length) {
		$('a.button-primary')[0].click();
	}

});

// Trash
Mousetrap.bind('shift+t', function() {
	focus_check();
	$(".submitdelete")[0].click();
});

// Set Featured Image
Mousetrap.bind('shift+f', function() {
	focus_check();
	$(".set-post-thumbnail")[0].click();
} );

// Pagination
if ( $('.pagination-links').length !== 0 ) {

	Mousetrap.bind('shift+right', function() {
		focus_check();
		$("a.last-page")[0].click();
	});

	Mousetrap.bind('right', function() {
		focus_check();
		$("a.next-page")[0].click();
	});

	Mousetrap.bind('shift+left', function() {
		focus_check();
		$("a.first-page")[0].click();
	});

	Mousetrap.bind('left', function() {
		focus_check();
		$("a.prev-page")[0].click();
	});

}