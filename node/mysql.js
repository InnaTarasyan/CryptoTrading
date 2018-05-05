// reading data from config.json file
var config = require('./config.json');

/**
 * MySQL connection
 */

var mysql   = require('mysql');

//connection establishment
var connection = mysql.createConnection(config);


// selects all data from the chat table
var  getInformationFromDB = function(callback) {

    connection.connect();

    connection.query("SELECT * FROM chat join users on chat.user_id = users.id", function (err, result, fields) {
        if (err) return callback(err);
        if(result.length){
            return callback(null, result);
        }
    });

    connection.end();

};

// store data into the chat table
var storeInformationToDB = function (callback) {

    var connection =  mysql.createConnection(config);

    connection.query('INSERT INTO chat SET ?', arguments[1], function(err, result) {
        if (err) return callback(err);
        return callback(null, result);
    });

    connection.end();

};


// find data in chat table by id
var findInformationInDB = function(callback){
    var connection =  mysql.createConnection(config);
    connection.query("SELECT * FROM chat where user_id = ? ", arguments[1], function (err, result) {
        if (err) return callback(err);
        if(result.length){
            return callback(null, result[0].color);
        } else {
            return callback(null, -1);
        }
    });

    connection.end();
};


module.exports = {
    getInformationFromDB : getInformationFromDB,
    storeInformationToDB : storeInformationToDB,
    findInformationInDB  : findInformationInDB
};


