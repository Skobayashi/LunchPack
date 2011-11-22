var fs = require('fs'),
    src = '../../public_html/resources/lunch-pack/js/',
    destFile = '../../public_html/lunchpack.js',
    size = src.length,
    results = [],
    extension = '',

    denyDirs = [
        'locale'
    ];

var read = function (dir, done) {
    fs.readdir(dir, function (error, list) {
        if (error) {
            return done(error);
        }

        (function next(i) {
            var file = list[i];
            if (!file) {
                return done(null, results);
            }

            file = dir + '/' + file;
            fs.stat(file, function (error, stat) {
                if (stat && stat.isDirectory()) {
                    if (denyDirs.indexOf(file) !== -1) {
                        next(++i);
                    }
                    read(file, function (res) {
                        if (res) {
                            results = results.concat(res);
                        }
                        next(++i);
                    });
                } else {
                    extension = file.substring(file.lastIndexOf('.') + 1, file.length);
                    if (extension === 'js') {
                        results.push(file.substring(size + 1, file.length));
                    }
                    next(++i);
                }
            });
        })(0);
    });
};

read('../../public_html/resources/lunch-pack/js/', function (error, results) {
    if (error) {
        console.error(error + '');
    }
    var obj = {
        path: src,
        dest: destFile,
        src: results
    };
    var ws = fs.createWriteStream('lunch.json');
    ws.write(JSON.stringify(obj));
    ws.end();
});
