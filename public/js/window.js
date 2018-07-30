<<<<<<< HEAD
var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
	var messages = JSON.parse(e.data);
	$('#chat_output').append("<div><h4 class='user_name'>"+messages['user']+"</h4><p class='message_inc'>"+messages['text']+"</p></div>");
	var block = $('#chat_output');
  	block.scrollTop(block.prop('scrollHeight'));
=======
var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
	var messages = JSON.parse(e.data);
	$('#chat_output').append("<div><h4 class='user_name'>"+messages['user']+"</h4><p class='message_inc'>"+messages['text']+"</p></div>");
	var block = $('#chat_output');
  	block.scrollTop(block.prop('scrollHeight'));
>>>>>>> origin/master
};