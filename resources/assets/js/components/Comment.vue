<template>
        <div :id="'comment' + id">
            <hr>
            <a :href="'profiles' + data.author.name" v-text="data.author.name"></a>
            <br>

            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="text"></textarea>
                </div>

                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="text"></div>

            <br>
            <span v-text="ago"></span>
            <br>

            <div class="row" v-if="canUpdate">
                <button class="btn btn-xs ml-3" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-xs ml-3" @click="destroy">Delete</button>
            </div>

        </div>
</template>
<script>
    import moment from 'moment';
    export default {
        props: ['data'],
        data() {

            return {
                editing: false,
                id: this.data.id,
                text: this.data.text
            };
        },

        computed: {
            ago(){
                return moment(this.data.created_at).fromNow();
            },

            signedIn(){
                return window.Globals.signedIn;
            },

            canUpdate() {
                    return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/comments/' + this.data.id, {
                    text: this.text
                });

                this.editing = false;

                flash(' Updated!');
            },

            destroy() {
                axios.delete('/comments/' + this.data.id);

                this.$emit('deleted', this.data.id);

                flash(' Your comment has been deleted!');
            }
        }
    }
</script>
