// var socket = io(WS_URL, { query: "id= "+USER_ID });
// var app2 = new Vue({
//     el: '#notifApp',
//     data: {
//         totalnotifCount : 0,
//         user_id: USER_ID,
//         notifLists: [],
//         notifBox: [],
//         socketConnected : {
//             status: false,
//             msg: 'Connecting Please Wait...'
//         },
//         bArr: {}
//     },
//     methods: {
//
//     }
// });
// socket.on('connect', function(data){
//     app2.socketConnected.status = true;
//     socket.emit('unprocessOrderList');
// });
// socket.on('connect_error', function(){
//     app2.socketConnected.status = false;
//     app2.socketConnected.msg = 'Could not connect to server';
//     app2.notifLists = [];
// });
// socket.on('unprocessOrderListRes', function(data){
//     // console.log(data);
//     // if (data.userDisconnected) {
//     //     app2.chatLists.findIndex(function(el) {
//     //         if(el.socket_id == data.socket_id){
//     //             el.online = 'N';
//     //             el.socket_id = '';
//     //         }
//     //     });
//     // }else if (data.userConnected) {
//     //     app2.chatLists.findIndex(function(el) {
//     //         if(el.id == data.userId){
//     //             el.online = 'Y';
//     //             el.socket_id = data.socket_id;
//     //         }
//     //     });
//     // }else {
//     //     data.chatList.findIndex(function(el) {
//     //         el.msgCount = 0;
//     //     });
//     //     app2.totalmsgCount = 0;
//     //     app2.chatLists = data.chatList;
//     // }
//
//     // data.unprocessOrderList.findIndex(function(el) {
//     //     el.processCount = 0;
//     // });
//
//     app2.totalnotifCount = 0;
//     app2.notifLists = data.unprocessOrderList;
//
//     if (data.unprocessOrderList)
//     {
//         app2.totalnotifCount = data.unprocessOrderList.length;
//     }
//
// });
// socket.on('addOrderResponse', function(data){
//     if(!app2.notifBox.includes(data.fromUserId)){
//         app2.notifLists.findIndex(function(el, el1) {
//             el.msgCount += 1;
//             app.totalmsgCount += 1;
//             // if(el.id == data.fromUserId){
//             //     el.msgCount += 1;
//             //     app.totalmsgCount += 1;
//             // }
//         });
//     }
// });
//
// var notifbox = {
//     data: function () {
//         return {
//             notif: [],
//
//         }
//     },
//     props: ['user_id','cChat', 'socket', 'chatBoxClose', 'chatBoxMinimize'],
//     mounted: function(){
//         socket.emit('getMessages', {fromUserId: this.user_id,toUserId: this.cChat.id});
//         socket.on('getOrderResponse', this.getOrderResponse);
//         socket.on('addOrderResponse', this.addOrderResponse);
//         // socket.on('typing', this.typingListener);
//         // socket.on('image-uploaded', this.imageuploaded);
//     },
//     destroyed: function() {
//         socket.removeListener('getMessagesResponse', this.getMessagesResponse);
//         socket.removeListener('addMessageResponse', this.addMessageResponse);
//         socket.removeListener('typing', this.typingListener);
//     },
//     methods: {
//         sendMessage: function(event){
//             if(event.keyCode === 13){
//                 if (this.message.length > 0) {
//                     let messagePacket = this.createMsgObj('text', '', this.message);
//                     this.socket.emit('addMessage', messagePacket);
//                     this.messages.push(messagePacket);
//                     this.message = "";
//                     this.scrollToBottom();
//                 }else{
//                     alert("Please Enter Your Message.");
//                 }
//             }else{
//                 if((event.keyCode != 116) && (event.keyCode != 82 && !event.ctrlKey)){
//                     this.socket.emit('typing', {typing:'typing...',socket_id:this.cChat.socket_id});
//                     clearTimeout(this.timeout);
//                     this.timeout = setTimeout(this.timeoutFunction, 500);
//                 }
//             }
//         },
//         timeoutFunction: function(){
//             socket.emit("typing", {typing:false,socket_id:this.cChat.socket_id});
//         },
//         scrollToBottom: function(){
//             $("#chatboxscroll-"+this.cChat.id).stop().animate({ scrollTop: $("#chatboxscroll-"+this.cChat.id)[0].scrollHeight}, 1);
//         },
//         createMsgObj : function(type, fileFormat, message){
//             return {
//                 type: type,
//                 fileFormat: fileFormat,
//                 filePath: '',
//                 fromUserId: this.user_id,
//                 toUserId: this.cChat.id,
//                 toSocketId: this.cChat.socket_id,
//                 message: message,
//                 time: new moment().format("hh:mm A"),
//                 date: new moment().format("Y-MM-D")
//             }
//         },
//         addMessageResponse: function(data){
//             // if (data && data.fromUserId == this.cChat.id) {
//             //     this.order.push(data);
//             //     this.scrollToBottom();
//             // }
//             this.order.push(data);
//             this.scrollToBottom();
//         },
//         typingListener: function(data){
//             if (data.typing && data.to_socket_id == this.cChat.socket_id) {
//                 this.typing = "is "+data.typing;
//             } else {
//                 this.typing = "";
//             }
//         },
//         getOrderResponse: function(data){
//             // if (data.toUserId == this.cChat.id) {
//             //     this.messages = data.result;
//             //     this.$nextTick(function () {
//             //         this.scrollToBottom();
//             //     });
//             // }
//             this.order = data.result;
//             this.$nextTick(function () {
//                 this.scrollToBottom();
//             });
//         }
//     },
//     filters: {
//         dateFormat: function(value) {
//             return new moment(value).format("D-MMM-YY")
//         }
//     },
//     template: `
//         <div class="chat_box" v-bind:id="'chatbox-' + cChat.id" >
//             <div class="col-md-12 col-sm-12">
//                 <div class="card">
//                     <div class="card-header bg-info text-white">
//                         <h4 class="card-title text-white">{{ cChat.username }} | <span style="font-size: 10px">{{ cChat.groupname }}</span></h4><span>{{ typing }}</span>
// <!--                        <span style="font-size: 10px">{{ cChat.last_login }}</span>-->
//                         <a class="heading-elements-toggle"><i class="ft-x" @click="chatBoxClose(cChat.id)"></i></a>
//                         <div class="heading-elements">
//                             <ul class="list-inline mb-0">
//                                 <li><a data-action="close" @click="chatBoxClose(cChat.id)"><i class="ft-x"></i></a></li>
//                             </ul>
//                         </div>
//                     </div>
//                     <div class="card-content collapse show">
//                         <div class="card-body">
//
//                             <div class="message_container">
//                                  <div class="message">
//                                   <div class="direct-chat-messages" v-bind:id="'chatboxscroll-' + cChat.id">
//                                     <div v-for="messagePacket in messages" class="direct-chat-msg" v-bind:class="{ 'right' : (messagePacket.fromUserId == user_id) }" >
//
//
//                                         <div v-if="messagePacket.type == 'text'" v-bind:class="{ 'pull-right text-sender ' : (messagePacket.fromUserId == user_id), 'pull-left text-receiver' : (messagePacket.fromUserId != user_id) }" v-html=messagePacket.message class="direct-chat-text clearfix" style="margin-right: 1px;margin-left: 1px;word-break: break-all;padding: 3px 10px; width: 100%">
//                                         </div>
//                                          <div class="direct-chat-info clearfix">
//                                             <small class="direct-chat-timestamp"  v-bind:class="{ 'pull-right ' : (messagePacket.fromUserId == user_id), 'pull-left ' : (messagePacket.fromUserId != user_id) }">{{ messagePacket.date | dateFormat }},{{ messagePacket.time }}</small>
//                                         </div>
//
//
//                                     </div>
//                                 </div>
//
//                                  </div>
//                                   <div class="time">
//
//                                  </div>
//                             </div>
//
//
//
//                         </div>
//                     </div>
//                     <div style="display: block; padding:10px" class="box-footer">
//                         <div class="input-group">
//                             <input name="message" v-bind:id="'msginput-' + cChat.id" v-model.trim="message" placeholder="Type Message And Hit Enter" class="form-control" type="text" v-on:keydown="sendMessage($event)">
//                             <span class="input-group-btn">
//                             </span>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </div>`
// };
//
