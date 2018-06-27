<template>
    <div>
        <div class="mt-5" v-if="signedIn">
            <div class="form-group">
        <textarea rows="5"
                  id="text"
                  name="text"
                  class="form-control"
                  placeholder="Add comment..."
                  v-model="text"
                  required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" @click="addComment">Add comment</button>
        </div>
        <div v-else>
            <p>Please <a href="/login">sign in</a> to add comment</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                text: ''
            };
        },

        computed: {
            signedIn() {
                return window.Globals.signedIn;
            }
        },

        methods: {
            addComment() {
                axios.post(this.endpoint, { text: this.text })
                    .then(({data}) => {
                        this.text = '';
                        flash('Your comment has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>