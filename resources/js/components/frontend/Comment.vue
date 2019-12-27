<template>
    <div class="comments-list">
          <span v-show="loading" class="spinner icon_refresh"></span>
          <comment-single v-for="comment in comments" :comment="comment" :key="comment.id"></comment-single>
          <comment-form v-on:commented="updateComment" :type="type" :id="id"></comment-form>
    </div>

</template>

<script>

import CommentSingle from './CommentSingle.vue'
import CommentForm from './CommentForm.vue'

export default {

    data () {
      return {
        comments: [],
        user_comment:false,
        loading: false,
      }
    },

    props: ['type','id'],

    components: {
      CommentSingle,
      CommentForm
    },

    created () {
        this.loading = true;

        // Fetch the comments
        axios.get('/comments?type=' + this.type+'&id=' + this.id)
            .then(response => {
                // success callback
                this.comments = response.data.data;
                this.loading = false;
            }
        )
        .catch(error => {
                console.error(error);
                this.loading = false;
        });

    },

    methods: {
      updateComment (comment) {
        this.user_comment = true;
        this.comments.push(comment);
      } 
    }

}
</script>

<style>

  .spinner {
    width: 20px;
    height: 20px;

    display: inline-block;
    -webkit-animation: sk-rotateplane 1.2s infinite ease-in-out;
    animation: sk-rotateplane 1.2s infinite ease-in-out;
  }

  @-webkit-keyframes sk-rotateplane {
    0% { -webkit-transform: perspective(120px) }
    50% { -webkit-transform: perspective(120px) rotateY(180deg) }
    100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
  }

  @keyframes sk-rotateplane {
    0% { 
      transform: perspective(120px) rotateX(0deg) rotateY(0deg);
      -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg);
      background-color: #47b784;
    } 50% { 
      transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
      -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
      background-color: #36495d;
    } 100% { 
      transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
      -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
      background-color: #47b784;
    }
  }
</style>