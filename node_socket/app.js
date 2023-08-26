const express = require('express');
const app = express();
const {v4 : uuidv4} = require('uuid');

const port = process.env.port || 8000;

let mysql = require("mysql");
let connection = mysql.createConnection({
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
    console.log(1111)
    socket.on('cart', function () {
        console.log(44)
        io.emit('product_added_cart')
    });


    socket.on('disconnect', () => {
        let i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);

    })
})
