// Set the search options
var acp_fuse_options = {
	'keys' : ['title'],
	'threshold' : '.3',
	'max_results_per_type' : '5',
	'includeScore' : true,
	'shouldSort' : true
};

var acp_search_data;
$.ajax({
	url : acpAjax.ajaxurl,
	data : { action: 'acp_gad'},
	success : function(response) {
		acp_search_data = response;
	}
});

var results_format = 'flat';

// Update the settings if the data is there.
if ( 'undefined' !== typeof acp_user_options ) {

	if ( '' !== acp_user_options.threshold ) {
		acp_fuse_options.threshold = acp_user_options.threshold;
	}

	if ( '' !== acp_user_options.max_results_per_type ) {
		acp_fuse_options.max_results_per_type = acp_user_options.max_results_per_type;
	}

	if ( 'grouped' === acp_user_options.results_format ) {
		results_format = 'grouped';
	}
}

var queryLength = 0;
var ajaxTimer;

// Trigger search on keyup
$('.acp input[type=search]').keyup( function(e) {

	var $input = $(this);

	clearTimeout(ajaxTimer);
	ajaxTimer = setTimeout(function() {
		// If the length of the query hasn't changed, then a character hasn't
		// been added or removed so stop processing
		if (queryLength === $input.val().length) {
			return;
		}

		// Set length of query for use on next keyup
		queryLength = $input.val().length;

		// Reset counter
		$('.acp-count-info .amount').attr('data-amount', 0).html('');

		// Reset items
		$('.acp-results').addClass('hide');
		$('.acp-list').html('');

		// Get the search query
		var query = $input.val();
		if ( query.length === 0 ) {
			return;
		}

		// Reveal the header and loader
		$('.acp-results-count').removeClass('hide');

		// Only show the loader if a search is being made.
		if ( e.keyCode !== 40 && e.keyCode !== 38 ) {
			$('.acp-results-count .loader').removeClass('invisible');
		}

		// Search using Fuse
		var acp_search = new Fuse(acp_search_data, acp_fuse_options);

		// Capture the result
		var acp_result = acp_search.search(query);

		switch ( results_format ) {
			case 'flat':
				resultsFlat( acp_result );
				break;
			case 'grouped':
				resultsGrouped( acp_result );
				break;
		}

		setTimeout(function() {
			$('.acp-results-count .loader').addClass('invisible');
			// Auto select the first result
			$('.acp-list li').eq(0).addClass('selected');
		}, 10);
	},500);

});

function resultsFlat(acp_result) {
	var i;
	var array = acp_result.splice(0, acp_fuse_options.max_results_per_type);
	var data = [];

	for ( i = 0; i < array.length; i++ ) {
		var item = array[i].item;
		if ( item.name === 'admin-action' ) {
			item['isAction'] = true;
		}
		item.properName = item.name.replace(/_/g, ' ');
		data.push( item );
	}

	// The template for each item
	var template = '{{#results}}{{#if isAction}}<li data-target="{{target}}" data-action="{{action}}">{{title}} <kbd>{{shortcut}}</kbd></li>{{/if}}{{#if !isAction}}<li><a href="{{url}}">{{title}}<small class="proper-name">{{properName}}</small></a></li>{{/if}}{{/results}}';

	// Add the results to the list.
	var list = '.acp-results .acp-list';

	Ractive.DEBUG = false;

	var ractive = new Ractive({
		el: list,
		template: template,
		data: { results: data }
	});

	$('.acp-count-info .amount').attr('data-amount', data.length );
	$('.acp-count-info .amount').html( data.length );

	// Find the section and unhide it
	var section = '.acp-results';
	$(section).removeClass('hide');
}

function resultsGrouped(acp_result) {

	var i; // Counter var
	var results = []; // Results array for output
	results['acp-data-keys'] = []; // Result keys for data template.

	// Loop through all the results, splitting them up by their name.
	for ( i = 0; i < acp_result.length; i++ ) {

		// Set up result object.
		var o = acp_result[i].item;

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
		if ( 'undefined' !== typeof acp_user_options && '' !== acp_fuse_options.max_results_per_type ) {

			if ( acp_fuse_options.max_results_per_type <= results[index].length ) {

				break;
			}

		}
	}

	// Loop for each of the different types of results (posts, pages, tags, categories, etc)
	for ( i = 0; i < results['acp-data-keys'].length; i++ ) {

		// The template for each item
		var template = '{{#results}}<li><a href="{{url}}">{{title}}</a></li>{{/results}}';

		// Retrieve the key that we're working with.
		var key = results['acp-data-keys'][i];

		if ( key === 'admin-action' ) {

			template = '{{#results}}<li data-target="{{target}}">{{title}} <kbd>{{shortcut}}</kbd></li>{{/results}}';

		}

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
}
