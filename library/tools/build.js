var util  = require('util'),
    spawn = require('child_process').spawn,
    fs    = require('fs');

fs.readFile('./lunch.json', function (err, data) {

    if (err) {
        throw err;
    }

    var list = JSON.parse(data.toString()).src,
        p = JSON.parse(data.toString()).path,
        dest = JSON.parse(data.toString()).dest,
        args = ['-jar', 'compiler.jar'];

    list.forEach(function (src) {
        args.push('--js');
        args.push(p + '/' + src);
    });

    args.push('--js_output_file');
    args.push(dest);

    var cmd = spawn('java', args);

    cmd.stdout.on('data', function (data) {
        console.log('stdout: ' + data);
    });

    cmd.stderr.on('data', function (data) {
        console.log('stderr: ' + data);
    });

    cmd.on('exit', function (code) {
        console.log('child process exited with code ' + code);
    });

});

/*

ls.stdout.on('data', function (data) {
console.log('stdout: ' + data);
});

ls.stderr.on('data', function (data) {
console.log('stderr: ' + data);
});

ls.on('exit', function (code) {
console.log('child process exited with code ' + code);
});

*/
