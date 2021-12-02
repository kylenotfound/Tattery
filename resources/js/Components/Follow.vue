<template>

    <section class="section">
        <button id="follow-button" class="btn btn-primary" @click="updateFollowing" v-text="followingButtonText"></button>
        <span v-text="followersText"></span>
        <span v-text="followingText"></span>
    </section>

</template>

<script>
    export default {

        props: ['userId', 'state', 'followersCount', 'followingCount'],

        data: function() {
            return {
                status: this.state,
                followers: this.followersCount,
                following: this.followingCount,
            }
        },

        methods: {
            updateFollowing() {
                if (this.status != true) {
                    axios.post('/follow/' + this.userId)
                    .then(response => {
                        this.status = !this.status;
                        this.followers = response.data.followersCount;
                        console.log(this.followers);
                        this.following = response.data.followingCount;
                    })
                    .catch(error => {
                        console.log(error);
                        alert("error following");
                    });
                } 
                if(this.status == true) {
                    axios.post('/unfollow/' + this.userId)
                    .then(response => {
                        this.status = !this.status;
                        this.followers = response.data.followersCount;
                        this.following = response.data.followingCount;
                    })
                    .catch(error => {
                        console.log(error);
                        alert("error unfollowing");
                    });
                }
            }

        },

        computed: {
            followingButtonText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            },

            followersText() {
                return "Followers: " + this.followers;
            },

            followingText() {
                return "Following: " + this.following;
            }
        }
    };
</script>
