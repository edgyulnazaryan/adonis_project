var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

server.listen(8000, function (){
    console.log(111)
});
io.on('connection', function (socket) {

    console.log("client connected");

    socket.on('disconnect', function() {
        redisClient.quit();
    });
});
