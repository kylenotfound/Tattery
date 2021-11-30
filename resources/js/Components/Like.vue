<template>

    <section class="section">
        <!--If the "userLiked" prop != 1 then the tattoo was not liked by the user -->
        <div v-if="likeState != 1">
            <button id="like-button" class="btn btn-primary" @click="likeTattoo">Like</button>
            <span>Likes: {{ likeCount }}</span>
        </div>
        <!--Otherwise the tattoo was liked by the user -->
        <div v-if="likeState == 1">
            <button id="like-button" class="btn btn-primary" @click="likeTattoo">Unlike</button>
            <span>Likes: {{ likeCount }}</span>
        </div>
    </section>

</template>

<script>
    export default {

        props: ['tattooId', 'originalLikeState', 'originalLikeCount'],

        data: function() {
            return {
                likeState: this.originalLikeState,
                likeCount: this.originalLikeCount,
            }
        },

        methods: {
            likeTattoo() {
                if (this.likeState != 1) {
                    axios.post('/like/' + this.tattooId)
                    .then(response => {
                        this.likeState = response.data.liked;
                        this.likeCount = response.data.count;
                        document.getElementById('like-button').innerText = "UnLike";
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
                if(this.likeState == 1) {
                    axios.post('/unlike/' + this.tattooId)
                    .then(response => {
                        this.likeState = response.data.liked;
                        this.likeCount = response.data.count;
                        document.getElementById('like-button').innerText = "Like";
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }

            },

        }
    };
</script>
