var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
	$('#connections').append("<div class='connected_user'><h4 class='user_name'>"+this.name+"</h4></div>");
};

conn.onmessage = function(e) {
	var messages = JSON.parse(e.data);
	console.log(messages);
	$('#chat_output').append("<div><h4 class='user_name'>"+messages['user']+"</h4><p class='message_inc'>"+messages['text']+"</p></div>");
	var block = $('#chat_output');
  	block.scrollTop(block.prop('scrollHeight'));
};