"use strict";
function Chat(){

    this.content = $('#content');
    this.status = $('#status');
    this.timeline = $('#timeline');

    // color identifying each user, assigned by server
    this.color = false;

}

Chat.prototype.init = function () {

    var self = this;

    // For mozilla web browser we use it's built-in WebSocket
    window.WebSocket = window.WebSocket || window.MozWebSocket;

    // message for browsers that do not support web sockets
    if (!window.WebSocket) {
        self.content.html($('<p>', { text: 'Sorry, your browser doesn\'t support WebSockets.'} ));
        $('span').hide();
        return;
    }

    // open connection
    this.connection = new WebSocket('ws://127.0.0.1:1420');
};


Chat.prototype.bindEvents = function () {

    var self = this;

    self.connection.onopen = function () {
        var user_data = JSON.stringify({ user_id: user_id, user_name: user_name });
        self.connection.send(user_data);
    };

    self.connection.onerror = function (error) {
        // for the case of any error
        self.content.html($('<p>', { text: 'Sorry, but the server is down.' } ));
    };

    // receiving messages from the server
    self.connection.onmessage = function (message) {
        // for the case when received information is not json
        try {
            var json = JSON.parse(message.data);
        } catch (e) {
            console.log('Not a valid JSON: ', message.data);
            return;
        }

        if (json.type === 'first') { // received first message from server
            self.color = json.data;
        } else if (json.type === 'history') { // received all the history from the server
            // displaying all the messages
            for (var i=0; i < json.data.length; i++) {
                self.addMessage(json.data[i].name, json.data[i].message,
                    json.data[i].color, new Date(json.data[i].created_at));
            }
        } else if (json.type === 'message') { // received a single message
            self.addMessage(json.data.name, json.data.message,
                json.data.color, new Date(json.data.created_at));
        } else {
            console.log('Wrong json: ', json);
        }
    };


    /**
     * Send mesage when user clicks Submit button
     */

    $(document).on('click', '#user_message', this.sendMessage.bind(this));


    /**
     *  If server does not respond for three seconds
     */
    setInterval(function() {
        $('#status').css('display', 'none');
        if (self.connection.readyState !== 1) {
            $('#status').css('display', 'block');
            self.status.text('Error');
        }
    }, 3000);

};

/**
 * Send mesage when user clicks Submit button
 */
Chat.prototype.sendMessage = function () {
    var msg = $('#textarea').data('markdown').parseContent().replace('</p>','').replace('<p>','');
    if (!msg) {
        return;
    }

    // sending message to the server
    this.connection.send(msg);
    $('#textarea').val('');

};

/**
 * Add message to the chat
 */
Chat.prototype.addMessage = function (author, message, color, dt) {
    this.timeline.prepend('<div class="m-list-timeline__item">\n' +
            '<span class="m-list-timeline__badge "></span>' +
            '<span class="m-list-timeline__icon flaticon-user"></span>' +
            '<span class="m-list-timeline__text">' +
                '<span style="color:' + color + '">' + author + '</span> @ ' + message +
            '</span>' +
            '<span class="m-list-timeline__time">' +
                + dt.getDate() + "/" + (dt.getMonth()+1) + "/" +
                + dt.getFullYear() + " @ "  +
                + dt.getHours() + ":" +
                + dt.getMinutes() + ":" +
                + dt.getSeconds() +
            '</span>' +
          '</div>');

};

$(document).ready(function() {
    var chat = new Chat();
    chat.init();
    chat.bindEvents();
});



