<template>
    <button type="submit" :class="classes" @click="toggle">
        <span>&hearts;</span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        props: ['post'],

        data() {
            return {
                favoritesCount: this.post.favoritesCount,
                isFavorited: this.post.isFavorited,
            }
        },

        computed: {
          classes() {
              return ['btn', this.isFavorited ? 'btn-primary' : 'btn-default'];
          },
            endpoint() {
              return `/posts/${this.post.category.slug}/${this.post.id}/favorites`;
            },
        },

        methods: {
            toggle() {
                if (this.isFavorited){
                   this.destroy();
                } else {
                    this.create();
                }
            },

            create() {
                axios.post(this.endpoint);
                this.isFavorited = true;
                this.favoritesCount++;
            },

            destroy() {
                axios.delete(this.endpoint);
                this.isFavorited = false;
                this.favoritesCount--;
            }
        }
    }
</script>