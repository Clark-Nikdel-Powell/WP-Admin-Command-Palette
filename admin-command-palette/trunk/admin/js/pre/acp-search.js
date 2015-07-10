
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

	var i;
	var results = [];
	results['acp-data-keys'] = [];
	for ( i = 0; i < acp_result.length; i++ ) {
		var o = acp_result[i];
		var index = o.name;
		if ( !(index in results) ) {
			results[index] = [];
			results['acp-data-keys'].push(index);
		}
		results[index].push(o);
	}

	var template = '{{#results}}<li><a href="{{url}}">{{title}}</a></li>{{/results}}';

	console.log(results);

	for ( i = 0; i < results['acp-data-keys'].length; i++ ) {
		var key = results['acp-data-keys'][i];
		var data = results[key];

		console.log(data);

		var section = '.results[data-name=' + key + ']';
		$(section).removeClass('hide');

		var list = section + ' .list';
		var ractive = new Ractive({
			el: list,
			template: template,
			data: { results: data } 
		});
	}

});
