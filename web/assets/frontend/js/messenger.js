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
		
		/*
		$('a.dialog').click(function(){
			var id = $(this).attr('id');
			var idArr = id.split("_");
			var contactId = idArr[1];
			var contactName = idArr[2];
			
			var options = {
				contactId: contactId,
				contactName: contactName,
				creatingInCycle: false
			};
			
			var dialog = new Dialog(options);
			dialog.open();
			
		});
		*/
		
		blinkingTitle = false;		
		
		$('#dialog').perfectScrollbar({
			wheelSpeed: 35
		});
		
		$("#dialog").scrollTop( $( "#dialog" ).prop( "scrollHeight" ) );
		$("#dialog").perfectScrollbar('update');
						
		
		
		$('.dialogInput textarea').keypress(function(e){
			//alert(1);
			if(dialog.enterKeyPressed(e)){
				dialog.sendMessage($(this));
			}
		});
		
	}
);




function Dialog(options){
	
	this.sentMessagesArea = $('#dialog');
	this.username = options.userName; 
	this.newMessagesRequest = '';
	
	//Chat.apply(this, options);	
	this.insertMessage = function(message){
		
		message.text = message.text.replace(/(?:(https?\:\/\/[^\s]+))/m,'<a href="$1" target="_blank">$1</a>'); 
		
		var html = Messenger.dialogMessageTemplate.replace(/\[MESSAGE\]/g, message.text);
		var username = (message.from == this.contactId) ? this.contactName : this.username;
		html = html.replace(/\[USERNAME\]/, username);
		html = html.replace(/\[DATE_TIME\]/, message.dateTime);				
		var profileId = (message.from == this.contactId) ? this.contactId : Messenger.currentUserId;		
		html = html.replace(/\[PROFILE_ID\]/, profileId);		
		html = html.replace(/\[MESSAGE_SECTION_ID\]/, message.id);		
		this.sentMessagesArea.append(html);	
		
		$("#dialog").scrollTop( $( "#dialog" ).prop( "scrollHeight" ) );
		$("#dialog").perfectScrollbar('update');		
	};
	
	
	this.checkNewMessages = function(){
		
		//alert('/user/messenger/dialog/newMessages/contactId:' + this.contactId);
		//return;
		
		if(this.newMessagesRequest != ''){
			this.newMessagesRequest.abort();
			//alert(this.newMessagesRequest);
		}	
		
		//return;
		
		console.log('START');
		
		this.newMessagesRequest = $.ajax({
			url: '/user/messenger/dialog/newMessages/contactId:' + this.contactId,				
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
				console.log('END');
								
				if(response.newMessages.length > 0){
					for(var i in response.newMessages){
						var message = response.newMessages[i];
						this.insertMessage(message);
						this.setMessageAsRead(message);
					}	
				}
				this.checkNewMessages();
				
			}
		});
		
		
		
	};
}





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
		
		if(Messenger.newMessagesRequest != ''){
			Messenger.newMessagesRequest.abort(); 					
		}
		
		/*
		alert('/user/messenger/chat/open/userId:' + Messenger.currentUserId + '/contactId:' + this.contactId);
		return;
		*/
		
		$.ajax({
			url: '/user/messenger/chat/open/userId:' + Messenger.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?openChat=true&userId='+Messenger.currentUserId+'&contactId='+this.contactId,
			timeout:10000,
			dataType: 'json',
			context: this,
			error:function(error){
				console.log(JSON.stringify(error));
				$('.error').html(error.responseText);
			},
			success: function(response, status){
				
				//console.log(JSON.stringify(response.chatHistory));
								
				var chat = Messenger.getChat(this.contactId); 
				
				if(!chat){					
					Messenger.setChat(this);
					
					var html = Messenger.template.html.replace(/\[CONTACT_ID\]/g, this.contactId);					
					html = html.replace(/\[CONTACT_NAME\]/g, this.contactName);
					
					var activeChatsNumber = Messenger.getAllChats().length;
					var position = Messenger.calculateChatPosition(activeChatsNumber - 1);
					
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
						}				
					}
					
					if(isNew && this.isMinimized){
						this.blinkingStart();
						Messenger.blinkingTitleStart();
						//Messenger.play('newMessageSound');
						$('body').append('<embed src="/assets/frontend/media/newMessage.mp3" autoplay="true" autostart="true" type="audio/x-wav" width="1" height="1">');
					}	
					
					if(this.sentMessagesArea.needsToBeScrolled()){						
						this.sentMessagesArea.scroll();
					}
					
					if(!this.creatingInCycle)				
						Messenger.checkActiveWindowsNewMessages();
					else
						setTimeout(function(){
							Messenger.checkActiveWindowsNewMessages();  
						}, 200);
						
					
				}
				
			}
			
		});		
	};	
	
	
	this.close = function(){
		
		/*
		if(Messenger.newMessagesRequest != '')
			Messenger.newMessagesRequest.abort();
		*/
		
		//alert('/user/messenger/chat/close/userId:' + Messenger.currentUserId + '/contactId:' + this.contactId);
		//return;
		
		$.ajax({
			url: '/user/messenger/chat/close/userId:' + Messenger.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?closeChat=true&userId='+Messenger.currentUserId+'&contactId='+this.contactId,
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
					Messenger.unsetChat(this);
					Messenger.relocateChats();
					//Messenger.checkActiveWindowsNewMessages();
					Messenger.blinkingTitleStop();
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
			Messenger.blinkingTitleStop();
			
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
		
		var html = Messenger.chatMessageTemplate.replace(/\[MESSAGE\]/g, message.text);		
		html = html.replace(/\[USER_PICTURE\]/, message.userImage);		
		html = html.replace(/\[DATE_TIME\]/, message.dateTime);
		
		var direction = (message.from == this.contactId) ? "in" : "out";
		html = html.replace(/\[DIRECTION\]/, direction);
		
		var profileId = (message.from == this.contactId) ? this.contactId : Messenger.currentUserId;		
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
			url: '/user/messenger/message/read/messageId:' + message.id + '/userId:' + Messenger.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?setMessageAsRead=true&userId='+Messenger.currentUserId+'&contactId='+this.contactId+'&messageId='+message.id,
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
			id: Messenger.createRandomId(),
			text: message,
			userImage: Messenger.currentUserImage,			
			dateTime: "",
		};
		
		this.insertMessage(messageOptions);
		
		//console.log('START SENDING');
				
		$.ajax({
			url: '/user/messenger/message/send/userId:' + Messenger.currentUserId + '/contactId:' + this.contactId,
			//url: '/chat/index.php?sendMessage=true&userId='+Messenger.currentUserId+'&contactId='+this.contactId,
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
					//console.log('MESSAGE:' + JSON.stringify(response.message));
					var message = response.message;
					$('#'+messageOptions.id).find('.dateTime').text(message.dateTime);
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










var Messenger = {		
	
	currentUserId : '',
	currentUserImage: '',
	chats : [],
	//activeSessions : [],
	templateHolder: '',
	template : {},
	chatMessageTemplate : '',
	dialogMessageTemplate : '',
	newMessagesRequest : '',
	docTitle : document.title,
		
	init: function(){
		
		$.ajaxSetup({ cache: false });
		
		Messenger.currentUserId = $('#currentUserId').val(),
		Messenger.currentUserImage = $('#currentUserImage').val(),
		Messenger.templateHolder = $('#chatTemplate'),
		Messenger.template = {
			html: Messenger.templateHolder.html(),
			width: Messenger.templateHolder.find('.chatWindow').width(),
			header: {
				height: Messenger.templateHolder.find('.header').height() 
			}
		};
		
		Messenger.chatMessageTemplate = $('#chatMessageSectionTemplate').html();
		Messenger.dialogMessageTemplate = $('#dialogMessageSectionTemplate').html();
		
		
		Messenger.checkNewMessages();
		Messenger.openChatsByActiveSessions();
		
		
		
		$(window).resize(function(){
			Messenger.relocateChats();
		});
		
	},
	
	getAllChats: function(){
		return this.chats;
	},
	
	getChat: function(contactId){	
		if(Messenger.chats.length > 0){		
			for(var i in Messenger.chats){
				var chat = Messenger.chats[i];
				if(chat.contactId == contactId){
					return chat;
				}
			}
		}
		
		return false;
	},
	
	setChat: function(chat){		
		Messenger.chats.push(chat);
	},
	
	unsetChat: function(chat){
		
		var index = Messenger.chats.indexOf(chat);
		if (index > -1) {
			Messenger.chats.splice(index, 1);
		}
	},
	
	relocateChats: function(){		
		for(var i in Messenger.chats){
			var chat = Messenger.chats[i];
			var position = Messenger.calculateChatPosition(i);
			$('.chatsArea').find('#'+chat.contactId).css({"right":position.x, "bottom": position.y});
		}	
	},
	
	calculateChatPosition: function(i){
		
		var chatsNumberInRow = Math.floor($(window).width() / (Messenger.template.width + 20) );
		var currentRowIndex =  Math.floor( i / chatsNumberInRow );		
		
		var chatsNumberIncurrentRow = i - (chatsNumberInRow * currentRowIndex);
		var chatPositionX = chatsNumberIncurrentRow * Messenger.template.width + (chatsNumberIncurrentRow * 20) + 20;
		
		if(chatPositionX == 0){
			chatPositionX = 20;
		}
		
		var chatPositionY = currentRowIndex * Messenger.template.header.height + 20;
		
		if(chatPositionY > 20){
			chatPositionY += currentRowIndex * 20;       
		}
		
		return position = {
			x:chatPositionX,
			y:chatPositionY 
		};
	},
	  
	
	checkActiveWindowsNewMessages: function(){
		
		//alert(1); 
		
		if(Messenger.getAllChats().length > 0 || dialog){
			
			if(Messenger.newMessagesRequest != '')
				Messenger.newMessagesRequest.abort();
			
			var checkForDialogAlso = false;
			var contactId = false;
			
			if(dialog){
				checkForDialogAlso = true;
				contactId = dialog.contactId;
			}
			
			console.log('START ActiveChatsNewMessages');
			Messenger.newMessagesRequest = $.ajax({
				url: '/user/messenger/activeChats/newMessages/userId:' + Messenger.currentUserId,				
				timeout:80000,
				dataType: 'json',
				data: 'checkForDialogAlso=' + checkForDialogAlso + '&contactId=' + contactId,
				context: this,
				error: function(response){
					console.log('ABORT ActiveChatsNewMessages');
					//console.log(JSON.stringify(response));
					$('.error').html(response.responseText);
				},
				success: function(response, status){				
					console.log(JSON.stringify(response));
					console.log('END ActiveChatsNewMessages');
									
					if(response.newMessages.length > 0){
						for(var i in response.newMessages){
							var message = response.newMessages[i];					
							var chat = Messenger.getChat(message.from);
													
							if(chat){
								
								//alert(dialog.contactId); 
								
								if(dialog && chat.contactId == dialog.contactId){									
									dialog.insertMessage(message);	
									dialog.setMessageAsRead(message);
								}
								
								chat.insertMessage(message);
								
								if(chat.isMinimized){
									chat.addMessageToWaiting(message);									
									chat.blinkingStart();
									Messenger.blinkingTitleStart();
									//Messenger.play('newMessageSound');
									$('body').append('<embed src="/assets/frontend/media/newMessage.mp3" autoplay="true" autostart="true" type="audio/x-wav" width="1" height="1">');
								}else{								
									chat.setMessageAsRead(message);
									chat.blinkingStop();
									Messenger.blinkingTitleStop();
								}								
							}							
							else if(dialog && message.from == dialog.contactId){
								//alert(dialog.contactId);
								dialog.insertMessage(message);	
								dialog.setMessageAsRead(message);
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
					
					Messenger.checkActiveWindowsNewMessages();
					
				}
			});
		
		}
	},
	
	
	checkNewMessages: function(){
		
		console.log("START CHECK NEW MESSAGES");
		
		$.ajax({
			url: '/user/messenger/newMessages/userId:' + Messenger.currentUserId,
			//url: '/chat/index.php?checkNewMessages=true&userId='+Messenger.currentUserId,
			timeout:80000,
			dataType: 'json',
			//data: 'message='+message,
			context: this,
			error: function(response){
				console.log('ABORT');
				console.log(JSON.stringify(response));
				//Messenger.checkActiveWindowsNewMessages();
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
						
						if(!dialog || (dialog && user.id != dialog.contactId) ){
							var chat = new Chat(options);
							chat.open();
						}
						
					}				
				}
				
				setTimeout(function(){
					Messenger.checkNewMessages();
				}, 15000);
		 
			}
		});
	},
	
	
	openChatsByActiveSessions: function(){
		
		
		$.ajax({
			url: '/user/messenger/activeChats/userId:' + Messenger.currentUserId,
			//url: '/chat/index.php?getActiveChats=true&userId='+Messenger.currentUserId,
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
				else{
					Messenger.checkActiveWindowsNewMessages();
				}	
				
				/*
				setTimeout(function(){
					Messenger.checkActiveWindowsNewMessages();  
				}, 200);
				*/
				
			}
		});
	},	
	
	blinkingTitleStart: function(){	
		Messenger.blinkingTitleStop();
		blinkingTitle = setInterval(function(){
			document.title = (document.title == "***New Message***" ? Messenger.docTitle : "***New Message***");
		}, 500);
		
	},
	
	blinkingTitleStop: function(){
		if( blinkingTitle ){
			clearInterval(blinkingTitle);
			document.title = Messenger.docTitle;
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




window.onload = function(){
	
	Messenger.init();
	
	dialog = false;
	
	var contactId = $('#contactId').val();
	
	if(contactId){
		
		var options = {
			contactId: contactId,
			contactName: $('#contactNickname').val(),
			userName: $('#userNickname').val(),
			creatingInCycle: false
		};
	
		Dialog.prototype = new Chat(options);
		Dialog.prototype.constructor = Dialog;
		dialog = new Dialog(options);	
	}
	
	//dialog.checkNewMessages();
	
}; 

