<template>

    <section class="section">
        <!--If the "userLiked" prop != 1 then the tattoo was not liked by the user -->
        <div v-if="likeState != 'liked'">
            <button id="like-button" class="btn btn-primary" @click="likeTattoo">Like</button>
            <span>Likes: {{ likeCount }}</span>
        </div>
        <!--Otherwise the tattoo was liked by the user -->
        <div v-if="likeState == 'liked'">
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
                if (this.likeState != 'liked') {

                    axios.post('/like/' + this.tattooId)
                    .then(response => {
                        document.getElementById('like-button').innerText = "UnLike";
                        this.likeState = response.data.liked;
                        this.likeCount = response.data.count;
                    })
                    .catch(error => {
                        alert('Could not like this post! Was it deleted?');
                        console.log(error);
                    });
                }
                if(this.likeState == 'liked') {
                    axios.post('/unlike/' + this.tattooId)
                    .then(response => {
                        document.getElementById('like-button').innerText = "Like";
                        this.likeState = response.data.liked;
                        this.likeCount = response.data.count;
                    })
                    .catch(error => {
                        alert('Could not unlike this post! Was it deleted?');
                        console.log(error);
                    });
                }

            },

        }
    };
</script>
