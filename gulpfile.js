var gulp        = require('gulp');
var gutil       = require('gulp-util');
var gulpCommand = require('gulp-command')(gulp);
var htmlhint    = require('gulp-htmlhint');
var csslint     = require('gulp-csslint');
		csslint.addFormatter('csslint-stylish');
var ftp         = require('vinyl-ftp');
var Crawler     = require('simplecrawler');

gulp.task('html', function(){
	gulp.src("./dest/**/*.html")
		.pipe(htmlhint('.htmlhintrc.json'))
		.pipe(htmlhint.reporter("htmlhint-stylish"))
});

gulp.task('css', function() {
	gulp.src('./dest/css/**/*.css')
		.pipe(csslint('.csslintrc.json'))
		.pipe(csslint.formatter("stylish"));
});

gulp.task('azure-search', function() {
	require('./azure-search.js');
});

gulp.task('link', function(cb) {
  var crawler = Crawler('http://127.0.0.1:4000/')
    .on('fetch404', function(queueItem, response) {
      gutil.log('Status code: ' + response.statusCode + ' (Link from ' + queueItem.referrer + ' to', queueItem.url + ')');
    })
    .on('complete', function(queueItem) {
      cb();
    });
		crawler.start();
});

gulp
	.option('deploy', '-e, --env', 'Specify environment "staging" or "production". The default value is staging')
	.option('deploy', '-u, --user', 'FTP User')
	.option('deploy', '-p, --password', 'FTP Password')
	.task('deploy', function() {

		if (typeof this.flags.user == 'undefined') {
			console.log('FTP User is empty. Please set user with -u option.');
			console.log('ex) gulp ftp -u username -p password');
			process.exit();	
		}

		if (typeof this.flags.password == 'undefined') {
			console.log('FTP Password is empty. Please set password with -p option.');
			console.log('ex) gulp ftp -u username -p password');
			process.exit();	
		}

		// 環境の切り替え
		var conn   = '';
		var globs  = [];
		var base   = '';
		var buffer = false;

		switch (this.flags.env) {
			case 'production':
				conn = ftp.create( {
					host:     '',
					port:     21,
					user:     this.flags.user,
					password: this.flags.password,
					parallel: 5,
					log:      gutil.log
				} );
				globs = [
					'dest/**'
				];
				base   = 'dest';
				buffer = false;

				console.log('');
				console.log(' /$$$$$$$                      /$$                           /$$$$$$$$');
				console.log('| $$__  $$                    | $$                          |__  $$__/       ');
				console.log('| $$  \\ $$  /$$$$$$   /$$$$$$ | $$  /$$$$$$  /$$   /$$         | $$  /$$$$$$ ');
				console.log('| $$  | $$ /$$__  $$ /$$__  $$| $$ /$$__  $$| $$  | $$         | $$ /$$__  $$');
				console.log('| $$  | $$| $$$$$$$$| $$  \\ $$| $$| $$  \\ $$| $$  | $$         | $$| $$  \\ $$');
				console.log('| $$  | $$| $$_____/| $$  | $$| $$| $$  | $$| $$  | $$         | $$| $$  | $$');
				console.log('| $$$$$$$/|  $$$$$$$| $$$$$$$/| $$|  $$$$$$/|  $$$$$$$         | $$|  $$$$$$/');
				console.log('|_______/  \\_______/| $$____/ |__/ \\______/  \\____  $$         |__/ \\______/ ');
				console.log('                    | $$                     /$$  | $$');
				console.log('                    | $$                    |  $$$$$$/');
				console.log('                    |__/                     \\______/');
				console.log('');
				console.log(' /$$$$$$$                           /$$                       /$$     /$$    ');
				console.log('| $$__  $$                         | $$                      | $$    |__/                    ');
				console.log('| $$  \\ $$ /$$$$$$   /$$$$$$   /$$$$$$$ /$$   /$$  /$$$$$$$ /$$$$$$   /$$  /$$$$$$  /$$$$$$$');
				console.log('| $$$$$$$//$$__  $$ /$$__  $$ /$$__  $$| $$  | $$ /$$_____/|_  $$_/  | $$ /$$__  $$| $$__  $$');
				console.log('| $$____/| $$  \\__/| $$  \\ $$| $$  | $$| $$  | $$| $$        | $$    | $$| $$  \\ $$| $$  \\ $$');
				console.log('| $$     | $$      | $$  | $$| $$  | $$| $$  | $$| $$        | $$ /$$| $$| $$  | $$| $$  | $$');
				console.log('| $$     | $$      |  $$$$$$/|  $$$$$$$|  $$$$$$/|  $$$$$$$  |  $$$$/| $$|  $$$$$$/| $$  | $$');
				console.log('|__/     |__/       \\______/  \\_______/ \\______/  \\_______/   \\___/  |__/ \\______/ |__/  |__/');
				console.log('');
				console.log(' *** To stop this process, Ctrl-C now!   ***');
				console.log('');
				break;

			default:
				conn = ftp.create( {
					host:     'waws-prod-os1-003.ftp.azurewebsites.windows.net',
					port:     21,
					user:     this.flags.user,
					password: this.flags.password,
					parallel: 5,
					log:      gutil.log
				} );
				globs = [
					'dest/**'
				];
				base   = 'dest';
				buffer = false;

				console.log('');
				console.log('  ____          _            _____     ');
				console.log(' |    \\ ___ ___| |___ _ _   |_   _|___ ');
				console.log(' |  |  | -_| . | | . | | |    | | | . |');
				console.log(' |____/|___|  _|_|___|_  |    |_| |___|');
				console.log('           |_|       |___|             ');
				console.log('');
				console.log('   _____ _              _             ');
				console.log('  / ____| |            (_)            ');
				console.log(' | (___ | |_ __ _  __ _ _ _ __   __ _ ');
				console.log('  \\___ \\| __/ _` |/ _` | | \'_ \\ \/ _` |');
				console.log('  ____) | || (_| | (_| | | | | | (_| |');
				console.log(' |_____/ \\__\\__,_|\\__, |_|_| |_|\\__, |');
				console.log('                   __/ |         __/ |');
				console.log('                  |___/         |___/ ');
				console.log('');
				console.log(' *** To stop this process, Ctrl-C now!   ***');
				console.log('');
				break;
		}

		return gulp.src( globs, { base: base, buffer: buffer } )
			.pipe( conn.differentSize( '/site/wwwroot' ) )
			.pipe( conn.dest( '/site/wwwroot' ) );
});

