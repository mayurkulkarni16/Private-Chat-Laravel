<template>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Dashboard
                    <i class="fa fa-times float-right" aria-hidden="true"></i>
                </div>
                <ul class="list-group">
                    <li class="list-group-item" @click.prevent="openChat(friend)" v-for="friend in friends" :key="friend.id">
                        <a href="">
                            {{ friend.name }}
                            <span class="badge badge-pill badge-danger" v-if="friend.session && (friend.session.unreadCount > 0)"> {{friend.session.unreadCount}} </span>
                        </a>
                        <i class="fa fa-circle float-right text-success" v-if="friend.online" aria-hidden="true"></i>
                        <i class="fa fa-circle float-right text-danger" v-else aria-hidden="true"></i>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <span v-for="friend in friends" :key="friend.id" v-if="friend.session">
                <message-component v-if="friend.session.open" @close="close(friend)" :friend="friend"></message-component>
            </span>
        </div>
    </div>
</template>

<script>
    import MessageComponent from "./MessageComponent";
    export default {
        components: {MessageComponent},
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                friends: []
            }
        },
        methods: {
            close(friend){
                friend.session.open = false
            },
            getFriends(){
                axios.post('/getFriends')
                    .then((response) => {
                        this.friends = response.data.data;
                        this.friends.forEach(friend => (friend.session ? this.listenForEverySession(friend) : ''))
                        // console.log(response.data.data);
                    });
            },
            listenForEverySession(friend){
                Echo.private(`Chat.${friend.session.id}`)
                    .listen('PrivateChatEvent', e => (friend.session.open ? '' : friend.session.unreadCount++) );
            },
            openChat(friend){
               if (friend.session) {
                   this.friends.forEach(friend => friend.session ? friend.session.open=false : '');
                   friend.session.open = true;
                   friend.session.unreadCount = 0;
                   // console.log(friend);
               } else {
                   this.createSession(friend);
               }
            },
            createSession(friend){
                this.friends.forEach(friend => friend.session ? friend.session.open=false : '');
                axios.post('/session/create', {friend_id: friend.id})
                    .then((response) => {
                        (friend.session = response.data.data),
                            (friend.session.open = true)
                        // console.log(response.data);
                    });
            },
        },

        created() {
            this.getFriends();

            Echo.channel('Chat').listen('SessionEvent', e => {
                let friend = this.friends.find(friend => friend.id === e.session_by);
                friend.session = e.session;
                this.listenForEverySession(friend);
            })

            Echo.join('Chat')
            .here((users) => {
                console.log(users);
                console.log('HELLO');
                this.friends.forEach(friend => {
                    users.forEach(user => {
                        if (user.id === friend.id){
                            friend.online = true;
                        }
                    })
                })
            })
            .joining((user) => {
                this.friends.forEach(friend => user.id === friend.id? friend.online = true: '');
            })
            .leaving((user) => {
                this.friends.forEach(friend => user.id === friend.id? friend.online = false: '');
            });
        }
    }
</script>
