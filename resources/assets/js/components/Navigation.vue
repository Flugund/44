<style lang="sass" scoped>
.toggle-user {
    position: fixed;
    top: 1em;
    right: 1em;
    z-index: 1000;
    text-align: center;
    
    .fa-user {
        font-size: 2em;
        width: 50px;
        height: 50px;
        background-color: #FFF;
        border: 3px solid #000;
        border-radius: 50%;
        font-size: 2em;
        line-height: 1.6em;
        cursor: pointer;
    }
}

.user {
    z-index: 999;
    width: 33%;
    height: 100%;
    background: #fff;
    position: fixed;
    top: 0;
    right: 0;
    padding: 1em;
    border-left: thick solid #000;

    h1 {
        font-size: 3em;
    }

    h2 {
        font-size: 2em;
    }
}
</style>

<template>
    <div class="toggle-user">
        <i class="fa fa-user" @click="toggleUserProfile"></i> <br/>
        {{ user.points }}
    </div>
    

    <div class="user" v-if="user.show">
        <h1>Points: {{ user.points }}</h1>

        <h2 v-for="feedback in user.feedbacks">{{ feedback.title }}</h2>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'user' : {
                    'show': false,
                    'points': 13123,
                    'feedbacks': [
                        {'title': 'test1'},
                        {'title': 'test2'},
                        {'title': 'test3'},
                        {'title': 'test4'}
                    ]
                }
            };
        },

        ready() {

        },

        methods: {
            toggleUserProfile() {
                this.user.show = !this.user.show;
            }
        }
    }
</script>
