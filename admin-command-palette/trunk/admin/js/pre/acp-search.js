// Set the search options
var acp_fuse_options = {
	'keys' : ['title'],
	'threshold' : '.3'
};

// Update the settings if the data is there.
if ( 'undefined' !== typeof acp_user_options && '' !== acp_user_options.threshold ) {
	acp_fuse_options.threshold = acp_user_options.threshold;
}

var queryLength = 0;

// Trigger search on keyup
$('.admin-command-palette-modal input[type=search]').keyup( function() {

	// If the length of the query hasn't changed, then a character hasn't
	// been added or removed so stop processing
	if (queryLength === $(this).val().length) {
		return;
	}

	// Set length of query for use on next keyup
	queryLength = $(this).val().length;

	// Reset counter
	$('.acp-count-info .amount').attr('data-amount', 0).html('');

	// Reset items
	$('.acp-results').addClass('hide');
	$('.acp-list').html('');

	// Get the search query
	var query = $(this).val();
	if ( query.length === 0 ) {
		return;
	}

	// Reveal the header and loader
	$('.admin-command-palette-results-count').removeClass('hide');
	$('.admin-command-palette-results-count .loader').removeClass('invisible');

	// Search using Fuse
	var acp_search = new Fuse(acp_search_data, acp_fuse_options);

	// Capture the result
	var acp_result = acp_search.search(query);

	// If no results found, return.
	if ( acp_result.length === 0 ) {
		return;
	}

	var i; // Counter var
	var results = []; // Results array for output
	results['acp-data-keys'] = []; // Result keys for data template.

	// Loop through all the results, splitting them up by their name.
	for ( i = 0; i < acp_result.length; i++ ) {

		// Set up result object.
		var o = acp_result[i];

		// Set up index for the name of the object (post, page, tag, category, etc)
		var index = o.name;

		// If the index doesn't exist yet, then it's a new section of the results.
		if ( !(index in results) ) {
			results[index] = [];
			results['acp-data-keys'].push(index);
		}

		// Add the object to the section
		results[index].push(o);

		// Skip further results if a max number of results has been set and reached.
		if ( 'undefined' !== typeof acp_user_options && '' !== acp_user_options.max_results_per_section ) {

			if ( acp_user_options.max_results_per_section <= results[index].length ) {

				break;
			}

		}
	}

	// The template for each item
	var template = '{{#results}}<li><a href="{{url}}">{{title}}</a></li>{{/results}}';

	// Loop for each of the different types of results (posts, pages, tags, categories, etc)
	for ( i = 0; i < results['acp-data-keys'].length; i++ ) {

		// Retrieve the key that we're working with.
		var key = results['acp-data-keys'][i];

		// Set up the data for this specific key
		var data = results[key];

		// Add number of items to results count
		var current_count = parseInt( $('.acp-count-info .amount').attr('data-amount') );
		if ( 'undefined' === typeof current_count ) {
			current_count = 0;
		}
		var updated_count = current_count + data.length;

		$('.acp-count-info .amount').attr('data-amount', updated_count);
		$('.acp-count-info .amount').html( updated_count );

		// Find the section and unhide it
		var section = '.acp-results[data-name=' + key + ']';
		$(section).removeClass('hide');

		// Add the results to the list.
		var list = section + ' .acp-list';
		var ractive = new Ractive({
			el: list,
			template: template,
			data: { results: data }
		});

	}

	setTimeout(function() {
		$('.admin-command-palette-results-count .loader').addClass('invisible');
		// Auto select the first result
		$('.acp-list li').eq(0).addClass('selected');
	}, 10);

});

$(document).keydown( function(e) {

	// If ACP isn't open, stop processing
	if ( ! $('.admin-command-palette-modal').hasClass('open') ) {
		return;
	}
	
	// Get the pressed key
	var key = e.keyCode;
	// If pressed key was not Enter, Up, or Down, stop processing
	if ( key !== 13 && key !== 38 && key !== 40 ) {
		return;
	}

	// Remove input focus
	$('.admin-command-palette input[type=search]').blur();

	var $current;
	// Get items to traverse
	var $listItems = $('.acp-list li');
	// Get the currently selected item
	var $selected = $listItems.filter('.selected');
	// Get the index of the currently selected item
	var $selectedIndex = $listItems.index( $selected );

	if ( key === 13 ) { // ENTER

		// If no item is selected, stop processing
		if ( $selectedIndex === -1 ) { 
			return;
		}

		// Process the selected item
		var $action = $selected.find('a').attr('href');
		window.location = $action;

		// Exit the function to stop processing
		return;

	} else if ( key === 38 ) { // UP

		e.preventDefault(); // Stop scrolling

		// If no item is selected, or the first item is
		// selected, select the last item
		// otherwise, decrement the index to traverse up the items
		if ( $selectedIndex === -1 || $selectedIndex === 0 ) {
			$current = $listItems.eq( $listItems.length - 1 );
		} else {
			$current = $listItems.eq($selectedIndex - 1);
		}

	} else if ( key === 40 ) { // DOWN

		e.preventDefault(); // Stop scrolling
		
		// If no item is selected, or the last item is
		// selected, select the first item
		// otherwise, increment the index to traverse down the items
		if ( $selectedIndex === -1 || $selectedIndex === $listItems.length - 1 ) {
			$current = $listItems.eq(0);
		} else {
			$current = $listItems.eq($selectedIndex + 1);
		}

	}

	// Remove the selected class
	$listItems.removeClass('selected');

	// Add the selected class to the newly selected item
	$current.addClass('selected');
});	
