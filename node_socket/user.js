let mysql = require("mysql");
let connection = mysql.createConnection({
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'adonis'
})

const express = require('express');
const app = express();
const {v4 : uuidv4} = require('uuid');
const redis = require('redis')
const port = process.env.port || 3030;
const server = app.listen(`${port}`, () => {
    console.log('Server is started on ' + `${port}` + ' port');
    // connection.connect();
})
const io = require("socket.io")(server, {
    cors : { origin : '*' }
});

const redisClient = redis.createClient();
redisClient.subscribe("cart");
redisClient.on("cart", function (channel, data) {
    console.log(channel, data)
})
/*
redisClient.on("cart", (channel_pattern, channel, event_data) => {
    console.log(123)
    var event = JSON.parse(event_data);
    const {
        uuid,
        data
    } = event;

})*/
/*redisClient.on('subscribe', function (channel, count) {
    console.log('SUBSCRIBE', channel, count)
})*/

const users = [];

redisClient.on('cart', function (cart) {
    console.log(cart)
    io.emit('cart', cart)
});

io.on('connection', (socket) => {
    socket.on('online', function (userId) {
        users[userId.userId] = userId;
        io.emit('updateUserStatus', users)
    });

    socket.on('disconnect', () => {
        let i = users.indexOf(socket.id);
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);

    })
})
