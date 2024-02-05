const index = Bun.file("./index.html");

const server = Bun.serve({
	port: 1337,
	fetch(req, server) {
		return new Response(index);
	},
	websocket: {
		open(ws) {
			const msg = `New has entered the chat`;
			ws.subscribe("chat");
			server.publish("chat", msg);
		},
		message(ws, message) {
			// this is a group chat
			// so the server re-broadcasts incoming message to everyone
			ws.publish("chat", `Send : ${message}`);
		},
		close(ws) {
			const msg = `Send has left the chat`;
			ws.unsubscribe("chat");
			server.publish("chat", msg);
		},
	},
});

console.log("Server is running on port 1337!");
