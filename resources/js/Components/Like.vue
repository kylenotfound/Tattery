<template>

    <section class="section">
         <div v-if="this.status">
            <button @click="likeTattoo" class="btn btn-link shadow-none" style="border-radius: 0em;">
                <span class="text-danger"><i class="fas fa-heart"></i></span></button>
            <span v-text="countText"></span>
        </div>
        <div v-else>
            <button @click="likeTattoo" class="btn btn-link shadow-none" style="border-radius: 0em;">
                <span class="text-danger"><i class="far fa-heart"></i></span></button>
            <span v-text="countText"></span>
        </div>
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
                        EventBus.$emit('totalLikes', response.data.totalCount);
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
                        EventBus.$emit('totalLikes', response.data.totalCount);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
            },
        },

        computed: {
            countText() {
                return this.likeCount + " Likes";
            }
        },

    };
</script>
