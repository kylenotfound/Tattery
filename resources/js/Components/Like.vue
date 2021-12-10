<template>

    <section class="section">
         <button class="btn btn-primary p-2" @click="likeTattoo" v-text="buttonText"></button>
         <span v-text="countText"></span>
    </section>

</template>

<script>

    import { EventBus } from '../app.js';

    export default {

        props: ['tattooId', 'likes', 'count'],

        data: function() {
            return {
                status: this.likes,
                likeCount: this.count,
            }
        },

        methods: {
            likeTattoo() {
                if (!this.status) {
                    axios.post('/like/' + this.tattooId)
                    .then(response => {
                        this.status = !this.status;
                        this.likeCount = response.data.count;
                        EventBus.$emit('like', this.likeCount);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
                if (this.status) {
                    axios.post('/unlike/' + this.tattooId)
                    .then(response => {
                        this.status = !this.status;
                        this.likeCount = response.data.count;
                        EventBus.$emit('like', this.likeCount);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            },
        },

        computed: {
            buttonText() {
                return (this.status) ? 'Unlike' : 'Like';
            },

            countText() {
                return "Likes: " + this.likeCount;
            }
        },

    };
</script>
