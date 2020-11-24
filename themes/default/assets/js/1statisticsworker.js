var connections = 0;
var url;
var updateDelay;
var port;
var stoped;

function readData() {
    if( stoped == false ){
        try {
            importScripts(url);
        }catch (e) {
			port.postMessage(e.message);
            setTimeout(readData, updateDelay);
        }
    }
}

function processData(data) {
    if (data.length > 0) {
        port.postMessage(data);
    }
    setTimeout(readData, updateDelay);
}

onconnect = function(e) {
    port = e.ports[0];
    connections++;

    port.onmessage = function(e) {
        var data = e.data;
            switch (data.cmd) {
                case 'start':
                    updateDelay = data.updateDelay;
                    url = data.url;
                    stoped = false;
                    port.postMessage("Worker: Starting #"+ connections);
                    readData();
                    break;
                case 'pause':
                    stoped = true;
                    port.postMessage("Worker: "+ connections + " paused");
                    readData();
                    break;
                case 'resume':
                    stoped = false;
                    port.postMessage("Worker: Starting #"+ connections);
                    readData();
                    break;
                case 'stop':
                    port.postMessage("Worker: Stopping #"+ connections);
                    self.close();
                    break;
            };
    }

    port.start();
}
