define([
	"desktopnotifications.pusherJs"
	],function(){
		return {
			startListening: function(params){
				document.addEventListener('DOMContentLoaded', function () {
					if (Notification.permission !== "granted")
						Notification.requestPermission();
				});
				if(params.log_enabled == true){
					Pusher.log = function(message) {
						if (console && console.log) {
							console.log(message);
						}
					};
				}

				var pusher = new Pusher(params.secret, {
					encrypted: true
				});

				var channel = pusher.subscribe(params.channel);
				channel.bind(params.event, function(data) {
					data.icon = params.icon;
					if (!Notification) {
						alert('Desktop notifications not available in your browser. Try Chromium.'); 
						return;
					}

					if (Notification.permission !== "granted")
						Notification.requestPermission();
					else {
						var notification = new Notification(data.title, {
							icon: data.icon,
							body: data.body,
						});
						notification.onclick = function () {
							window.open(data.url);
						};
					}
				});	
			},
		};
	});