const express = require('express');
const app = express();
const {v4 : uuidv4} = require('uuid');

const port = process.env.port || 3030;

let mysql = require("mysql");
let connection = mysql.createConnection({
    // DB_CONNECTION=mysql
// DB_HOST=127.0.0.1
// DB_PORT=3306
// DB_DATABASE=adonis
// DB_USERNAME=root
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'adonis'
})

const server = app.listen(`${port}`, () => {
    console.log("Server is started");
    connection.connect();
})

const io = require("socket.io")(server, {
    cors : { origin : '*' }
});
const users = [];
io.on('connection', (socket) => {
    socket.on('online', function (userId) {
        users[userId.userId] = socket.id;
        io.emit('updateUserStatus', users)
    });
    socket.on('disconnect', () => {
        let i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);
    })
})
