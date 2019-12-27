<template>
 <div class="comment" :class="[comment.me ? 'user' : '']">
    <span class="user">{{ comment.first_name }} {{ comment.last_name }}</span>
    <span class="date-created">{{ comment.created_at }}</span>
    <p v-html="comment.comment"></p>
    <div class="clearfix"></div>
 </div>
</template>

<script>
export default {

	props: ['comment'],

	computed: {

	}

}
</script>