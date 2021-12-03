<template>

    <section class="section">
        <div>
            <span v-text="followersText"></span>
            <span v-text="followingText"></span>
        </div>
    </section>

</template>

<script>

    import { EventBus } from '../app.js';

    export default {

        props: ['followersCount', 'followingCount'],

        data: function() {
            return {
                followers: this.followersCount,
                following: this.followingCount,
            }
        },

        created() {
            EventBus.$on('followers', (data) => {
                this.followers = data;
            });

            EventBus.$on('following', (data) => {
                this.following = data;
            })
        },

        computed: {
            followersText() {
                return "Followers: " + this.followers;
            },

            followingText() {
                return "Following: " + this.following;
            }
        }
    };
</script>
