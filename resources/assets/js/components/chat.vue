<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <message v-for="msg in messages" :key="msg.id" :message="msg"></message>
                <form @submit.prevent = "sendMessage" >
                    <input type="hidden" name="_token" :value="csrf" />
                    <input class="form-control" v-model="textMessage" >
                    <button type="submit" class="btn btn-primary" :disabled="textMessage == '' ? true : false">Send</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import chatMessage from './message.vue';
    export default {
        name: 'chat',
        props : ['receiver',  'chatRoom', 'token'],
        data() {
            return {
                messages: [],
                textMessage: '',
                csrf: $('meta[name="csrf-token"]').attr('content'),
                receiver_online : false
            }
        },
        computed : {
            channel(){
                return window.Echo.join('chat.' + this.chatRoom);
            }

        },
        mounted(){
            if(this.chatRoom != null){
                let th = this;

                /**
                 * connecting to the channel 
                 */
                this.channel
                    .here((usernames)=>{
                        th.receiver_online = usernames.length > 1 ?  true : false
                    })
                    .joining((username)=>{
                        th.receiver_online = true
                    })
                    .leaving((username)=>{
                        th.receiver_online =false
                    })
                    .listen('Chat', (data)=>{
                        th.messages.push(data.messages.message);
                    });

                /**
                 * getting all messages 
                 */
                axios.get('/api/chat/' + th.chatRoom , { 
                }).then((data)=>{
                    th.messages = data.data.data;
                })
            }else{
                return 
            }
            
        },
        methods : {
            sendMessage(){
                let th = this;
                if(th.textMessage == ""){
                    return
                }

                axios.post( th.receiver +'/message', {
                    body: JSON.stringify(th.textMessage),
                    receiver: th.receiver,
                    chatroom : th.chatRoom ,
                    receiver_online: th.receiver_online ? true : false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then((data)=>{
                    th.textMessage = '';
                    let parsedData = data.data.data ;
                    th.messages.push(parsedData);
                    th.chatRoom =  parsedData.chat_room_id;
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        components:{
            message: chatMessage
        }
    }
</script>