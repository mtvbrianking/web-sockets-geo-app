require('dotenv').config();

// console.log(process.env.MAP_API_KEY);

var express = require('express');
var socket = require('socket.io');
var redis = require('redis');

// Bootstrap express

var app = express();

var server = app.listen(4000, function(){
  console.log('listening on *:4000');
});

// Static files

app.use('/', express.static('public'));

// Bootstrap socket.io

var io = socket(server);

io.on('connection', function(socket) {

  console.log(socket.id+' -> connected');

  socket.on('disconnect', function() {
    console.log(socket.id+' -> disconnected');
  });

});

// Serverside (PHP) message...

var client = redis.createClient("redis://127.0.0.1:6379");

// Subscribe to the 'device' channel
client.subscribe('device');

client.on("message", function(channel, log) {
  var log = JSON.parse(log);
  console.log("%s -> %s @[%s, %s]", channel, log.event, log.latitude, log.longitude);
  io.sockets.emit('log', log);
});
