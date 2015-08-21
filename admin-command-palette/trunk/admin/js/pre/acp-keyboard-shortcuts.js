// Keyboard Shortcuts set up via Mousetrap.
// Copied from class-acp-admin-actions.php for sake of time.
// Will refactor in a DRY way later.

// ESC triggers a blur of inputs, but closes the ACP Modal
Mousetrap.bind('esc', function() {

	if ( 1 === $('.acp input:focus').length ) {
		AcpModal.close();
	}

	$('input').trigger('blur');

});

// Add New Whatever
if ( 0 < $('a[href*="post-new.php"]').length ) {

	Mousetrap.bind('shift+n', function() {

		if ( 1 === $( "input:focus" ).length ) {
			return;
		}

		window.location.replace($('a[href*="post-new.php"]').attr('href'));

	});

}

// Open Post/Page in New Tab
Mousetrap.bind('shift+v', function() {

	if ( 1 === $( "input:focus" ).length ) {
		return;
	}

	var url = $("#view-post-btn a").attr('href');
	window.open(url,'_blank');

});

// Preview
Mousetrap.bind('shift+p', function() {

	if ( 1 === $( "input:focus" ).length ) {
		return;
	}

	if (1 === $('.preview').length) {
		$('.preview')[0].click();
	}

});

// Submit Form
Mousetrap.bind('shift+s', function() {

	if ( 1 === $( "input:focus" ).length ) {
		return;
	}

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

	if ( 1 === $( "input:focus" ).length ) {
		return;
	}

	$(".submitdelete")[0].click();
});

// Set Featured Image
Mousetrap.bind('shift+f', function() {

	if ( 1 === $( "input:focus" ).length ) {
		return;
	}

	$(".set-post-thumbnail")[0].click();
} );

// Pagination
if ( $('.pagination-links').length !== 0 ) {

	Mousetrap.bind('shift+right', function() {

		if ( 1 === $( "input:focus" ).length ) {
			return;
		}

		$("a.last-page")[0].click();
	});

	Mousetrap.bind('right', function() {

		if ( 1 === $( "input:focus" ).length ) {
			return;
		}

		$("a.next-page")[0].click();
	});

	Mousetrap.bind('shift+left', function() {

		if ( 1 === $( "input:focus" ).length ) {
			return;
		}

		$("a.first-page")[0].click();
	});

	Mousetrap.bind('left', function() {

		if ( 1 === $( "input:focus" ).length ) {
			return;
		}

		$("a.prev-page")[0].click();
	});

}