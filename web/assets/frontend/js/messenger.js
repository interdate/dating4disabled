/*******indexOf support for IE < 9 ******* */

if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}


/**********************************/










$(document).ready(
	function($){
		
		$('a.chat').click(function(){
			var id = $(this).attr('id');
			var idArr = id.split("_");
			var contactId = idArr[1];
			var contactName = idArr[2];
			
			var options = {
				contactId: contactId,
				contactName: contactName,
				creatingInCycle: false
			};
			
			var chat = new Chat(options);
			chat.open();
			
		});
		
		blinkingTitle = false;
	}
);


function Chat(options){	
	this.contactId = options.contactId;
	this.contactName = options.contactName;
	this.creatingInCycle = options.creatingInCycle;
	this.chatWraper;
	this.scrollBarWraper;
	this.sentMessagesArea;	
	this.isMinimized;
	this.waitingMessages = [];
	
	this.getContactId = function(){
		return this.contactId;		
	};
	
	this.getContactName = function(){
		return this.contactName;		
	};
	
	this.open = function(){
		
		if(ChatManager.newMessagesRequest != ''){
			ChatManager.newMessagesRequest.abort(); 					
		}
		
		
		
		$.ajax({
			url: '/user/messenger/chat/open/userId:' + ChatManager.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?openChat=true&userId='+ChatManager.currentUserId+'&contactId='+this.contactId,
			timeout:10000,
			dataType: 'json',
			context: this,
			error:function(error){
				console.log(JSON.stringify(error));
				$('.error').html(error.responseText);
			},
			success: function(response, status){
				
				//console.log(JSON.stringify(response.chatHistory));
								
				var chat = ChatManager.getChat(this.contactId); 
				
				if(!chat){					
					ChatManager.setChat(this);
					
					var html = ChatManager.template.html.replace(/\[CONTACT_ID\]/g, this.contactId);					
					html = html.replace(/\[CONTACT_NAME\]/g, this.contactName);
					
					var activeChatsNumber = ChatManager.getAllChats().length;
					var position = ChatManager.calculateChatPosition(activeChatsNumber - 1);
					
					var thisChat = this;
					
					this.chatWraper = $('.chatsArea').append(html).find('.chatWindow:last-child');
					
					this.setOverAll();
					
					this.chatWraper
						.click(function(){
							thisChat.setOverAll();
						})
						.css({"right":position.x, "bottom":position.y, "z-index":100})						
						.find('.close')						
						.click(function(){
							thisChat.close();
						})						
						.siblings('.minimize, .header')						
						.click(function(){
							thisChat.minimize();
						});
					
					this.chatWraper.find('textarea').keypress(function(e){
						if(thisChat.enterKeyPressed(e)){
							thisChat.sendMessage($(this));
						}
					});										
					
					this.scrollBarWraper = this.chatWraper.find('.scrollbar1');
					this.scrollBarWraper.tinyscrollbar();	
					this.sentMessagesArea = this.scrollBarWraper.find('.overview');
					
					this.sentMessagesArea.initHeight = 245;
					
					this.sentMessagesArea.needsToBeScrolled = function(){	
						if(this.height() > this.initHeight){
							return true;
						}
						return false;
					};					
					
					this.sentMessagesArea.scroll = function(){
						var height = this.height();
						var initHeight = this.initHeight;						
						thisChat.scrollBarWraper.tinyscrollbar_update(height - initHeight + 10);
					};					
					
					//console.log(JSON.stringify(response.chatHistory));
					
					if(this.creatingInCycle)				
						this.minimize();						
					
					var isNew = false;
					
					if(response.chatHistory.length > 0){
						for(var i in response.chatHistory){
							var message = response.chatHistory[i];
							this.insertMessage(message);							
							//alert(message.isRead);							
							if(message.from == this.contactId && !message.isRead){
								isNew = true;
								if(!this.isMinimized)							
									this.setMessageAsRead(message);
								else
									this.addMessageToWaiting(message);								
							}
								//
						}				
					}
					
					if(isNew && this.isMinimized){
						this.blinkingStart();
						ChatManager.blinkingTitleStart();
						//ChatManager.play('newMessageSound');
						$('body').append('<embed src="/assets/frontend/media/newMessage.mp3" autoplay="true" autostart="true" type="audio/x-wav" width="1" height="1">');
					}	
					
					if(this.sentMessagesArea.needsToBeScrolled()){						
						this.sentMessagesArea.scroll();
					}
					
					if(!this.creatingInCycle)				
						ChatManager.checkActiveChatsNewMessages();
					else
						setTimeout(function(){
							ChatManager.checkActiveChatsNewMessages();  
						}, 200);
						
					
				}
				
			}
			
		});		
	};	
	
	
	this.close = function(){
		
		/*
		if(ChatManager.newMessagesRequest != '')
			ChatManager.newMessagesRequest.abort();
		*/
		
		//alert('/user/messenger/chat/close/userId:' + ChatManager.currentUserId + '/contactId:' + this.contactId);
		//return;
		
		$.ajax({
			url: '/user/messenger/chat/close/userId:' + ChatManager.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?closeChat=true&userId='+ChatManager.currentUserId+'&contactId='+this.contactId,
			error:function(error){
				console.log(JSON.stringify(error));
				$('.error').html(error.responseText);
			},
			timeout:10000,
			dataType: 'json',
			context: this,
			success: function(response, status){				
				if(response.success){					
					$('.chatsArea').find('#'+this.contactId).remove();					
					ChatManager.unsetChat(this);
					ChatManager.relocateChats();
					//ChatManager.checkActiveChatsNewMessages();
					ChatManager.blinkingTitleStop();
				}
			}
		});		
	};
	
	this.minimize = function(){
		$('#'+this.contactId).find('.body, textarea').toggleClass('hiden');
		this.isMinimized = $('#'+this.contactId).find('.body, textarea').hasClass('hiden');
		
		if(!this.isMinimized){
			
			if(this.waitingMessages.length > 0){
				for(var i in this.waitingMessages){
					var message = this.waitingMessages[i];
					this.setMessageAsRead(message);
				}
			}
			
			this.waitingMessages = [];
			
			if(this.sentMessagesArea.needsToBeScrolled()){						
				this.sentMessagesArea.scroll();
			}
			
			this.blinkingStop();
			ChatManager.blinkingTitleStop();
			
			this.setOverAll();
			
		}
		
	};
	
	this.setOverAll = function(){
		$('.chatWindow').css({"z-index":10});
		$('#'+this.contactId).css({"z-index":100});
	};
	
	this.enterKeyPressed = function(e){
		if (e.keyCode == 13) {	       
			return true;
	    }		
		return false;
	};	
	
	this.insertMessage = function(message){
		
		message.text = message.text.replace(/(?:(https?\:\/\/[^\s]+))/m,'<a href="$1" target="_blank">$1</a>'); 
		
		var html = ChatManager.messageTemplate.replace(/\[MESSAGE\]/g, message.text);		
		html = html.replace(/\[USER_PICTURE\]/, message.userImage);		
		html = html.replace(/\[DATE_TIME\]/, message.dateTime);
		
		var direction = (message.from == this.contactId) ? "in" : "out";
		html = html.replace(/\[DIRECTION\]/, direction);
		
		var profileId = (message.from == this.contactId) ? this.contactId : ChatManager.currentUserId;		
		html = html.replace(/\[PROFILE_ID\]/, profileId);
		
		html = html.replace(/\[MESSAGE_SECTION_ID\]/, message.id);
		
		this.sentMessagesArea.append(html);	
		if(this.sentMessagesArea.needsToBeScrolled()){						
			this.sentMessagesArea.scroll();
		}		
	};	
	
	this.addMessageToWaiting = function(message){
		this.waitingMessages.push(message);
	};
	
	this.blinkingStart = function(){
		$('#'+this.contactId).find('.header').addClass('blinking');
	};
	
	this.blinkingStop = function(){
		$('#'+this.contactId).find('.header').removeClass('blinking');
	};
	
	this.setMessageAsRead = function(message){
		
		$.ajax({
			url: '/user/messenger/message/read/messageId:' + message.id + '/userId:' + ChatManager.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?setMessageAsRead=true&userId='+ChatManager.currentUserId+'&contactId='+this.contactId+'&messageId='+message.id,
			timeout:10000,
			dataType: 'json',
			context: this,
			success: function(response, status){				
				if(response.success){
					
				}
			}
		});
		
	};
	
	this.sendMessage = function(textarea){
		
		var message = textarea.val();
		
		if(message.length == 0){			
			return false;
		}
		
		textarea.val('');
		var messageOptions = {
			id: ChatManager.createRandomId(),
			text: message,
			userImage: ChatManager.currentUserImage,			
			dateTime: "",
		};
		
		this.insertMessage(messageOptions);
		
		//console.log('START SENDING');
				
		$.ajax({
			url: '/user/messenger/message/send/userId:' + ChatManager.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?sendMessage=true&userId='+ChatManager.currentUserId+'&contactId='+this.contactId,
			timeout:80000,
			dataType: 'json',
			type: 'Post',
			data: 'message='+encodeURIComponent(message),
			context: this,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			error: function(response){				
				console.log(JSON.stringify(response));
				$('.error').html(response.responseText);
				//alert('הודעה לא נשלחה. תנסו שוב.');
			},
			success: function(response, status){				
				if(response.success){
					//console.log('END SENDING');
					console.log('MESSAGE:' + JSON.stringify(response.message));
					var message = response.message;
					$('#'+messageOptions.id).find('.message .dateTime').text(message.dateTime);
					/*
					if(!message.contactIsOnline){
						alert('‫המשתמש/ת נמצא/ת במצב לא מקוון. הודעות שיישלחו יועברו כאשר המשתמש/ת ת/ימצא במצב מקוון.‬');
					}
					*/
					
					
				}
				else{
					//console.log(JSON.stringify(response));
					//alert('הודעה לא נשלחה. תנסו שוב.');
					//alert(JSON.stringify(response));
					alert('הודעה לא נשלחה. תנסו שוב.');
				}				
								
			}
		});
		
	};
	
}



var ChatManager = {		
	
	currentUserId : '',
	currentUserImage: '',
	chats : [],
	//activeSessions : [],
	templateHolder: '',
	template : {},
	messageTemplate : '',
	newMessagesRequest : '',
	docTitle : document.title,
		
	init: function(){
		
		
		
		$.ajaxSetup({ cache: false });
		
		ChatManager.currentUserId = $('#currentUserId').val(),
		ChatManager.currentUserImage = $('#currentUserImage').val(),
		ChatManager.templateHolder = $('#chatTemplate'),
		ChatManager.template = {
			html: ChatManager.templateHolder.html(),
			width: ChatManager.templateHolder.find('.chatWindow').width(),
			header: {
				height: ChatManager.templateHolder.find('.header').height() 
			}
		};
		
		ChatManager.messageTemplate = $('#messageSectionTemplate').html();		
		
		//$('body').append('<embed src="/assets/frontend/media/newMessage.mp3" autoplay="false" autostart="false" type="audio/wav" width="1" height="1" id="newMessageSound" enablejavascript="true">');		
		
		ChatManager.checkNewMessages();
		ChatManager.openChatsByActiveSessions();		
		$(window).resize(function(){
			ChatManager.relocateChats();
		});
		
		//console.log('INIT CHAT');
		
	},
	
	getAllChats: function(){
		return this.chats;
	},
	
	getChat: function(contactId){	
		if(ChatManager.chats.length > 0){		
			for(var i in ChatManager.chats){
				var chat = ChatManager.chats[i];
				if(chat.contactId == contactId){
					return chat;
				}
			}
		}
		
		return false;
	},
	
	setChat: function(chat){		
		ChatManager.chats.push(chat);
	},
	
	unsetChat: function(chat){
		
		var index = ChatManager.chats.indexOf(chat);
		if (index > -1) {
			ChatManager.chats.splice(index, 1);
		}
	},
	
	relocateChats: function(){		
		for(var i in ChatManager.chats){
			var chat = ChatManager.chats[i];
			var position = ChatManager.calculateChatPosition(i);
			$('.chatsArea').find('#'+chat.contactId).css({"right":position.x, "bottom": position.y});
		}	
	},
	
	calculateChatPosition: function(i){
		
		var chatsNumberInRow = Math.floor($(window).width() / (ChatManager.template.width + 20) );
		var currentRowIndex =  Math.floor( i / chatsNumberInRow );		
		
		var chatsNumberIncurrentRow = i - (chatsNumberInRow * currentRowIndex);
		var chatPositionX = chatsNumberIncurrentRow * ChatManager.template.width + (chatsNumberIncurrentRow * 20) + 20;
		
		if(chatPositionX == 0){
			chatPositionX = 20;
		}
		
		var chatPositionY = currentRowIndex * ChatManager.template.header.height + 20;
		
		if(chatPositionY > 20){
			chatPositionY += currentRowIndex * 20;       
		}
		
		return position = {
			x:chatPositionX,
			y:chatPositionY 
		};
	},
	  
	
	checkActiveChatsNewMessages: function(){				
		if(ChatManager.getAllChats().length > 0){
			
			if(ChatManager.newMessagesRequest != '')
				ChatManager.newMessagesRequest.abort();
			
			//console.log('START');
			ChatManager.newMessagesRequest = $.ajax({
				url: '/user/messenger/activeChats/newMessages/userId:' + ChatManager.currentUserId,				
				timeout:80000,
				dataType: 'json',
				//data: 'message='+message,
				context: this,
				error: function(response){
					//console.log('ABORT');
					//console.log(JSON.stringify(response));
					$('.error').html(response.responseText);
				},
				success: function(response, status){				
					console.log(JSON.stringify(response));
					//console.log('END');
									
					if(response.newMessages.length > 0){
						for(var i in response.newMessages){
							var message = response.newMessages[i];					
							var chat = ChatManager.getChat(message.from);
													
							if(chat){							
								chat.insertMessage(message);
								
								if(chat.isMinimized){
									chat.addMessageToWaiting(message);									
									chat.blinkingStart();
									ChatManager.blinkingTitleStart();
									//ChatManager.play('newMessageSound');
									$('body').append('<embed src="/assets/frontend/media/newMessage.mp3" autoplay="true" autostart="true" type="audio/x-wav" width="1" height="1">');
								}else{								
									chat.setMessageAsRead(message);
									chat.blinkingStop();
									ChatManager.blinkingTitleStop();
								}								
							}
							else{
								//console.log("This chat is not active.");
								var options = {
									contactId: message.from,
									contactName: message.userName,
									creatingInCycle: true
								};
									
								var chat = new Chat(options);
								chat.open();
							}
							
						}			
							
					}								  
					
					ChatManager.checkActiveChatsNewMessages();
					
				}
			});
		
		}
	},
	
	
	checkNewMessages: function(){
		
		console.log("START CHECK NEW MESSAGES");
		
		$.ajax({
			url: '/user/messenger/newMessages/userId:' + ChatManager.currentUserId,
			//url: '/chat/index.php?checkNewMessages=true&userId='+ChatManager.currentUserId,
			timeout:80000,
			dataType: 'json',
			//data: 'message='+message,
			context: this,
			error: function(response){
				//console.log('ABORT');
				//console.log(JSON.stringify(response));
				//ChatManager.checkActiveChatsNewMessages();
				$('.error').html(response.responseText);
			},
			success: function(newMessages, status){				
				//console.log(JSON.stringify(newMessages));
				console.log('END CHECK NEW MESSAGES');
				
				if(newMessages.fromUsers.length > 0){
					for(var i in newMessages.fromUsers){
						var user = newMessages.fromUsers[i];
						var options = {
							contactId: user.id,
							contactName: user.name,
							creatingInCycle: true
						};
						
						var chat = new Chat(options);
						chat.open();
					}				
				}
				
				setTimeout(function(){
					ChatManager.checkNewMessages();
				}, 15000);
		 
			}
		});
	},
	
	
	openChatsByActiveSessions: function(){
		
		
		$.ajax({
			url: '/user/messenger/activeChats/userId:' + ChatManager.currentUserId,
			//url: '/chat/index.php?getActiveChats=true&userId='+ChatManager.currentUserId,
			timeout:80000,
			dataType: 'json',			
			context: this,
			error: function(response){				
				//console.log(JSON.stringify(error));
				$('.error').html(response.responseText);
			},
			success: function(response, status){
				console.log(JSON.stringify(response));
				var activeChats = response.activeChats;
				
				if(activeChats.length > 0){
					
					
					
					for(var i in activeChats){
						contact = activeChats[i];
						var options = {
							contactId: contact.id,
							contactName: contact.name,
							creatingInCycle: true
						};
							
						
						
						var chat = new Chat(options);
						chat.open();
						
					}
				}	
				
				/*
				setTimeout(function(){
					ChatManager.checkActiveChatsNewMessages();  
				}, 200);
				*/
				
			}
		});
	},	
	
	blinkingTitleStart: function(){	
		ChatManager.blinkingTitleStop();
		blinkingTitle = setInterval(function(){
			document.title = (document.title == "***New Message***" ? ChatManager.docTitle : "***New Message***");
		}, 500);
		
	},
	
	blinkingTitleStop: function(){
		if( blinkingTitle ){
			clearInterval(blinkingTitle);
			document.title = ChatManager.docTitle;
		}
	}, 
	
	
	play: function(id){
		var sound = document.getElementById(id);		
		sound.Play();		
	},	
	
	createRandomId: function(){
	    var text = "";
	    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	    for( var i=0; i < 8; i++ )
	        text += possible.charAt(Math.floor(Math.random() * possible.length));

	    return text;
	}
	
	
};




window.onload = ChatManager.init;