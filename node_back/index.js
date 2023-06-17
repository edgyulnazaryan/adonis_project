var app = require('express')();
var server = require('http').createServer(app);
// var io = require('socket.io')(server);

const io = require('socket.io')(server, {
    cors : {origin : "*"}
});


/*io.on('connection', function (socket){
    console.log("Connected !!");
    socket.on('user_connected', function (user_id){
        console.log("USER CONNECTED !!" + user_id)
    });

    socket.on('disconnect', function (){
        console.log("USER DISCONNECTED !!")
    });

});

server.listen(3000, () => {
    console.log("Server is running")
})*/


io.on('connection', (socket) => {
    console.log('New client connected');

    // Handle online event
    socket.on('online', (userId) => {
        console.log(`User ${userId} is online`);
        // Perform any necessary actions when the user comes online
    });

    // Handle offline event
    socket.on('offline', (userId) => {
        console.log(`User ${userId} is offline`);
        // Perform any necessary actions when the user goes offline
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected');
        // Perform any necessary cleanup or actions when the client disconnects
    });
});
