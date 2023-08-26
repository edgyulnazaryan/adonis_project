const express = require('express');
const app = express();
const {v4 : uuidv4} = require('uuid');

const port = process.env.port || 3031;

let mysql = require("mysql");
let connection = mysql.createConnection({
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'adonis'
})

const server = app.listen(`${port}`, () => {
    console.log('Employer Server is started on ' + `${port}` + ' port');
    // connection.connect();
})


const io = require("socket.io")(server, {
    cors : { origin : '*' }
});
const employers = [];

io.on('connection', (socket) => {
    socket.on('onlineEmployer', function (employerId) {
        employers[employerId.employerId] = socket.id;
        io.emit('updateEmployerStatus', employers)
    });

    socket.on('disconnect', () => {
        let j = employers.indexOf(socket.id);
        employers.splice(j, 1, 0);
        io.emit('updateEmployerStatus', employers);

    })
})
