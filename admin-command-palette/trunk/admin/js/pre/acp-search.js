
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

	console.log(acp_result);

	var el = '.results[data-type=admin-pages] .list';
	var template = '{{#results}}<li><a href="{{url}}">{{title}}</a></li>{{/results}}';

	var ractive = new Ractive({
		el: el,
		template: template,
		data: { results: acp_result } 
	});

});
