<template>
    <div class="write-comment">
            <div class="loader" v-show="loading" >
                <span class="spinner icon_refresh"></span>
            </div>
            <form action="" method="post" @submit.prevent="submit">
                <textarea v-model="data.comment" class="input-message" name="message" id="message" placeholder="Your comment..." required></textarea>
                <input :disabled="loading" class="btn btn-primary btn-main" type="submit" value="Comment">
            </form>
        <div class="clearfix"></div>
    </div>
</template>

<script>
export default {

    data() {
      return {
        loading: false,
        data: {}
      }
    },
    props: ['type','id'],

    methods: {
      submit() {
        this.loading = true;

        // Save Comment

        axios.post('/comment/store', {
              comment: this.data.comment,
              type: this.type,
              data_id: this.id,
            })
            .then(response => {
                // fire event for comment
              this.$emit('commented', response.data.data);

              // Clear the message
              this.data.comment = "";

              this.loading = false;
            })
            .catch(e => {
                this.loading = false;
                console.log(error);
            })
      }
    }

}
</script>