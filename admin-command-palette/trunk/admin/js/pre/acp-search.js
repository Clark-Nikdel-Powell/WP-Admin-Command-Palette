
var acp_fuse_options = {
	'keys' : ['title'],
	'threshold' : '.3'
};

$('.admin-command-palette input[type=search]').keyup( function() {

	var query = $(this).val();
	if ( query.length < 3 ) {
		return;
	}

	var acp_search = new Fuse(acp_search_data, acp_fuse_options);
	var acp_result = acp_search.search(query);

	if ( acp_result.length === 0 ) {
		return;
	}

	var el = '.admin-command-palette-results ul';
	var template = '<li>{{ title }}</li>';

	var data = acp_result;

	console.log(data);

	var ractive = new Ractive({
		el: el,
		template: template,
		data: data
	});

});
