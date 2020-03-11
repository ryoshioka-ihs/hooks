/*
 * Azure Search
 *
 * Azure Searchのインデックスを作成、更新するスクリプトです。
 * 実行するには、事前に以下を行う必要があります。
 *
 *  - nodejsのインストール
 *  - npm install
 *
 * サイト内検索のインデックスを更新するには、下記のコマンドを実行します。
 *
 *   node ./_azure-search/update-search-index.js
 *
 */
var AzureSearch  = require('azure-search');
var each         = require('async-each-series');

var searchClient = AzureSearch({
	url: "https://ihs-websites.search.windows.net",
	key: "69C5A1A53B19B756D4740023405178E1",
	version: '2015-02-28-preview'
});

var indexName = 'posts-and-pages';

var items = require( "./dest/search/searchIndex.json" );

function rebuildSearchIndex(posts) {
	var schema = {
		name: indexName,
		fields: [
		{ 
			name: 'id',
			type: 'Edm.String',
			searchable: false,
			filterable: true,
			retrievable: true,
			sortable: true,
			facetable: false,
			key: true 
		},
		{ 
			name: 'title',
			type: 'Edm.String',
			searchable: true,
			filterable: true,
			retrievable: true,
			sortable: true,
			facetable: false,
			key: false,
			analyzer: 'ja.microsoft'
		},
		{ 
			name: 'content',
			type: 'Edm.String',
			searchable: true,
			filterable: true,
			retrievable: true,
			sortable: true,
			facetable: false,
			key: false,
			analyzer: 'ja.microsoft'
		},
		{ 
			name: 'description',
			type: 'Edm.String',
			searchable: true,
			filterable: true,
			retrievable: true,
			sortable: true,
			facetable: false,
			key: false,
			analyzer: 'ja.microsoft'
		},
		{ 
			name: 'link',
			type: 'Edm.String',
			searchable: false,
			filterable: false,
			retrievable: true,
			sortable: true,
			facetable: false,
			key: false 
		},
		{ 
			name: 'categories',
			type: 'Collection(Edm.String)',
			searchable: true,
			filterable: true,
			retrievable: true,
			sortable: false,
			facetable: true,
			key: false 
		},
		{ 
			name: 'pubdate',
			type: 'Edm.DateTimeOffset',
			searchable: false,
			filterable: true,
			retrievable: true,
			sortable: false,
			facetable: true,
			key: false 
		}
		],
		suggesters: [
		{
			name: 'main',
			searchMode: 'analyzingInfixMatching',
			sourceFields: ['categories']
		}
		],
		scoringProfiles: [
			{  
				"name": "boostCategory",
				"text": {  
					"weights": {  
						"title": 1.5,  
						"description": 5,  
						"categories": 2,
						"content": 1  
					}  
				}  
			} ,  
		],
		defaultScoringProfile: "boostCategory",
		corsOptions: {
			allowedOrigins: ['*']
		}
	};

	console.log('Deleting index...');
	searchClient.deleteIndex(indexName, function (err) {
		if (err) console.error(err);

		console.log('Creating index...')
			searchClient.createIndex(schema, function (err, schema) {
				if (err) {
					console.dir(err);
					throw err;
				}

				each(posts, function(post, next) {
					console.log('Adding', post.title, '...')
						searchClient.addDocuments(indexName, [post], function (err, details) {
							console.log(err || (details.length && details[0].status ? 'OK' : 'failed'));
							next(err, details);
						});
				}, function (err) {
					console.log('Finished rebuilding index.');
				});
			});
	});
}

rebuildSearchIndex(items);

