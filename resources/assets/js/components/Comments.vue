<template>
    <div>
        <div v-for="(comment, index) in items" :key="comment.id">
            <comment :data="comment" @deleted="remove(index)"></comment>
        </div>

        <new-comment endpoint="endpoint" @created="add"></new-comment>
    </div>
</template>

<script>
    import Comment from './Comment.vue';
    import NewComment from './NewComment.vue';

    export default {

        props: ['data'],

        components: { Comment, NewComment },

        data() {
            return {
                dataSet: false,
                items: [],
                endpoint: location.pathname + '/comments'
            }
        },

        methods: {

            fetch() {
                axios.get(this.url())
                    .then(this.refresh);
            },

            url() {
                return `${location.pathname}/comments`
            },

            refresh({data}) {

            },

            add(comment) {
                this.items.push(comment);
                this.$emit('added');
            },

            remove(index) {
                this.items.splice(index, 1);

                this.$emit('removed');
            }
        }
    }
</script>