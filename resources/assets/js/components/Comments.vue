<template>
    <div>
        <div v-for="(comment, index) in items" :key="comment.id">
            <comment :data="comment" @deleted="remove(index)"></comment>
        </div>

        <new-comment endpoint="/posts/aut-illo-accusamus-deleniti-facilis-quae-suscipit/254" @created="add"></new-comment>
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
                items: this.data,
                endpoint: location.pathname + '/comments'
            }
        },

        methods: {
            add(comment)
            {
                this.items.push(comment);
                this.$emit('added');
            },

            remove(index){
                this.items.splice(index, 1);

                this.$emit('removed');
            }
        }
    }
</script>