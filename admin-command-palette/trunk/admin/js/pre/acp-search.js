// Set the search options
var acp_fuse_options = {
	'keys' : ['title'],
	'threshold' : '.3'
};

// Update the settings if the data is there.
if ( 'undefined' !== typeof acp_user_options && '' !== acp_user_options.threshold ) {
	acp_fuse_options.threshold = acp_user_options.threshold;
}

// Trigger search on keyup
$('.admin-command-palette input[type=search]').keyup( function(e) {

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

	// Only show the loader if a search is being made.
	if ( e.keyCode !== 40 && e.keyCode !== 38 ) {
		$('.admin-command-palette-results-count .loader').removeClass('invisible');
	}

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
	}, 10);

});
