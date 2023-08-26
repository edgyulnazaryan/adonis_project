const express = require('express');
const app = express();
const {v4 : uuidv4} = require('uuid');

const port = 8000;
console.log(port)
let mysql = require("mysql");
let connection = mysql.createConnection({
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'adonis'
})

const server = app.listen(`${port}`, () => {
    console.log("Redis Server is started");
    connection.connect();
})


const io = require("socket.io")(server, {
    cors : { origin : '*' }
});

io.on('connection', (socket) => {
    socket.on('cart', function (cart) {
        console.log(cart)
        io.emit('cart', cart)
    });

    /*socket.on('disconnect', () => {

    })*/
})
