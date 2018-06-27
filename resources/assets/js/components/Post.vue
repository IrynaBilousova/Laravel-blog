<script>
import Comments from './Comments.vue';

export default {
    props: ['initialCommentsCount'],

    components: { Comments },

    data(){
        return {
            commentsCount: this.initialCommentsCount
        }
    }
}
</script>