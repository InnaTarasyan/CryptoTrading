"use strict";

// history of the latest user messages
var history = [ ];

/**
 * MySQL connection. I am using node-mysql package
 */
var mysqlfile = require('./mysql');

var storage = mysqlfile;
var retrieve = storage.getInformationFromDB;

// here we fill the 'history' array with data from 'chat' table
retrieve(function (err, result) {
    if (err) console.log("Database error!");
    Array.prototype.push.apply(history, result);
    history.slice(-80);
});

// function to store new coming messages to the 'chat' table
var store = storage.storeInformationToDB;

// find message in db
var find = storage.findInformationInDB;

process.title = 'cointrading-chat';

// Websocket server port
var webSocketsServerPort = 1420;

// websocket and http servers
var webSocketServer = require('websocket').server;
var http = require('http');


// list of currently connected clients
var clients = [ ];


var colors = [];
while (colors.length < 100) {
    do {
        var color = Math.floor((Math.random()*1000000)+1);
    } while (colors.indexOf(color) >= 0);
    colors.push("#" + ("000000" + color.toString(16)).slice(-6));
}



/**
 * HTTP server
 */
var server = http.createServer(function(request, response) {});


server.listen(webSocketsServerPort, function() {
    console.log((new Date()) + " Server is listening on port " + webSocketsServerPort);
});

/**
 * WebSocket server
 */
var wsServer = new webSocketServer({
    // WebSocket server is tied to a HTTP server.
    httpServer: server
});

// Works on each connection to the WebSocket server
wsServer.on('request', function(request) {
    console.log((new Date()) + ' Connection from origin ' + request.origin + '.');

    // Ensuring that client is connecting from your website
    var connection = request.accept(null, request.origin);

    // the client index
    var index = clients.push(connection) - 1;
    var userId = false;
    var userColor = false;
    var name = false;

    console.log((new Date()) + ' Accepted connection.');

    // sends the entire history
    if (history.length > 0) {
        connection.sendUTF(JSON.stringify( { type: 'history', data: history} ));
    }

    // user sent some message
    connection.on('message', function(message) {
        if (message.type === 'utf8') { // accepting only text
            if (userId === false) { // first message sent by user is their name
                // remember user name
                userId = JSON.parse(message.utf8Data).user_id;

                name = JSON.parse(message.utf8Data).user_name;

                // Send the corresponding color back to the user
                find(function (err, result) {
                    if (err) console.log("Database error!");

                    userColor = (result != -1) ? result: colors.shift();
                    connection.sendUTF(JSON.stringify({ type:'first', data: userColor }));

                    console.log((new Date()) + ' User is known as: ' + userId
                        + ' with ' + userColor + ' color.');

                }, userId);


            } else { // broadcasting the message

                console.log((new Date()) + ' Received Message from ' + userId + ': ' + message.utf8Data);

                // history of all sent messages
                var obj = {
                    created_at: new Date,
                    message: message.utf8Data,
                    user_id: userId,
                    name: name,
                    color: userColor
                };
                history.push(obj);

                var entireMessage = JSON.parse(JSON.stringify(obj));
                entireMessage.updated_at = new Date;
                delete entireMessage.name;

                store(function (err) {
                    if (err) console.log(err);
                }, entireMessage);

                history = history.slice(-80);

                // broadcast message to all connected clients
                var json = JSON.stringify({ type:'message', data: obj });
                for (var i=0; i < clients.length; i++) {
                    clients[i].sendUTF(json);
                }
            }
        }
    });

    // user disconnected
    connection.on('close', function(connection) {
        if (userId !== false && userColor !== false) {
            console.log((new Date()) + " Connection "
                + connection.remoteAddress + " disconnected.");

            // remove user from the list of connected clients
            clients.splice(index, 1);
            // push back user's color to be reused by another user
            colors.push(userColor);
        }
    });

});
