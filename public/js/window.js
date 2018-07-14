var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    console.log(e.data);
	
	var messages = JSON.parse(e.data);
	$('#chat_output').append(template(messages[i]));
	scroll();
};