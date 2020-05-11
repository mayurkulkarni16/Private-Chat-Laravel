<template>
    <div class="card" style="height: 400px;">
        <div class="card-header">
            <b :class="{'text-danger':session_block}">
                {{friend.name}}
                <span v-if="session_block">(Blocked)</span>
            </b>
            <!-- Close Button -->
            <a href="" @click.prevent="close">
                <i class="fa fa-times float-right" aria-hidden="true"></i>
            </a>
            <!-- Close Button End -->

            <!-- Option Button -->
            <div class="dropdown float-right mr-4">
                <a href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" @click.prevent="unblock" v-if="session_block">Un Block</a>
                    <a class="dropdown-item" href="#" @click.prevent="block" v-else>Block</a>
                    <a class="dropdown-item" href="#" @click.prevent="clear">Clear Chat</a>
                </div>
            </div>

            <!-- Option Button End -->

        </div>
        <div class="card-body" v-chat-scroll="{smooth: true, notSmoothOnInit: true}" style="overflow-y: scroll">
            <p class="card-text" v-for="chat in chats" :key="chat.id" :class="{'text-right': chat.type === 0}">
                <i class="fas fa-check-double fa-xs" v-if="chat.read_at" style="font-size: 0.5rem"></i>
                <i class="fa fa-check fa-xs" :class="{'text-right': chat.read_at != null}" style="font-size: 0.5rem" aria-hidden="true"></i>
                {{ chat.message }}
            </p>
        </div>
        <form class="card-footer" @submit.prevent="send">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Type Message..." :disabled="session_block" v-model="message">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['friend'],
        data() {
            return {
                chats: [],
                message: null,
                session_block: false
            }
        },
        methods: {
            send(){
                if (this.message){
                    this.pushToChats(this.message);
                    axios.post(`/send/${this.friend.session.id}`, {
                        contents: this.message,
                        content_to: this.friend.id
                    }).then(response => this.chats[this.chats.length-1].id = response.data);
                    this.message = null;
                }
            },
            pushToChats(message){
                this.chats.push({ message: message, type: 0, sent_at: 'Just Now' });
            },
            close(){
                this.$emit('close');
            },
            clear(){
                this.chats = [];
            },
            block(){
                this.session_block = true;
            },
            unblock(){
                this.session_block = false;
            },
            getAllMessages(){
                axios.post(`/session/${this.friend.session.id}/chats`)
                .then(response => this.chats = response.data.data);
            },
            readAllRecentMessage(){
                axios.post(`/session/${this.friend.session.id}/readRecentMessage`)
            }
        },
        created() {
            this.getAllMessages();

            this.friend.session.open ? this.readAllRecentMessage() : '';

            Echo.private(`Chat.${this.friend.session.id}`)
                .listen('PrivateChatEvent', e => {
                    this.readAllRecentMessage();
                    this.chats.push({ message: e.message, type: 1, sent_at: 'Just Now' });
            });

            Echo.private(`Chat.${this.friend.session.id}`)
                .listen('MessageReadEvent', e => {
                    this.chats.forEach(chat => (chat.id === e.chat.id ? (chat.read_at = e.chat.read_at) : ''))
                });
        },
        name: "MessageComponent"
    }
</script>

<style scoped>

</style>
