(function() {

	var params = queryString.parse(location.search);
	var searchQuery = params.q;

	var vm = new SearchResultsViewModel(searchQuery, new BlogSearchService());

	ko.applyBindings(vm);

	function SearchResultsViewModel(searchQuery, searchService) {
		var vm = this;

		vm.searchQuery = searchQuery; // 1-time binding
		vm.results     = ko.observableArray([]);
		vm.isSearching = ko.observable(false);

		init()

			function init() {
				if (searchQuery) {
					vm.isSearching(true);

					searchService.search(searchQuery, function(err, results) {
						vm.isSearching(false);
						if (err) return;

						vm.results(results);
					});
				}
			}
	}

	function BlogSearchService() {
		var svc = this;

		var indexName = 'posts-and-pages';
		var client = AzureSearch({
			url: 'https://ihs-websites.search.windows.net',
			key:'CCC03375AC4AAAA5D6FFB73029E4F51E',
			version: '2015-02-28-preview'
		});

		svc.search = search;

		function search(query, callback) {
			var searchOptions = { search: query, '$select': 'id, title, link, pubdate, content, description' };
			client.search(indexName, searchOptions, callback);
		}
	}
}());

