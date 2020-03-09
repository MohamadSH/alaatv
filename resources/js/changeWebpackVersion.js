var fs = require('fs'),
    mixManifestPath = 'public/mix-manifest.json';

fs.readFile(mixManifestPath, {encoding: 'utf-8'}, function(err,data){
    if (!err) {
        fs.writeFile(mixManifestPath, data.replace(/\?id=.*"/gi, '?id='+Date.now()+'"'), function(err) {
            if(err) {
                return console.log(err);
            }
            console.log("webpack version updated ;)");
        });
    } else {
        console.log(err);
    }
});
