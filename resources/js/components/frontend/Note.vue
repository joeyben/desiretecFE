<template>
   <div class="col-md-6 wish-note" >
      <div class="wish-note-wrapper edit-mode" v-if="editMode">
         <textarea name="note" maxlength="200" value="" :placeholder="placeholderText" @keyup.enter="saveNote" v-model="note" />
         <a @click.prevent="saveNote">
            <i class="fal fa-save"></i>
         </a>
      </div>
      <div class="wish-note-wrapper not-edit-mode" v-else>
         <p>{{ this.note }}</p>
         <a @click.prevent="editMode = !editMode">
            <i class="fal fa-edit"></i>
         </a>
      </div>
   </div>
</template>

<script>
   export default {
      data() {
         return {
            editMode: false,
            note: '',
            placeholderText: ''
         };
      },

      props: ['wishid', 'wishnote', 'lang'],

      mounted() {
         this.note = this.wishnote;
         this.placeholderText = this.lang;

         if (this.note == '') {
            this.editMode = true;
         }
      },

      methods: {
         saveNote() {
            this.editMode = false;

            axios.post('/wishes/updateNote', {
               id: this.wishid,
               note: this.note
            }).then(function (response) {
            })
            .catch(function (error) {
               console.log(error);
            });
         }
      }
   }
</script>

<style scoped>
   .wish-note {
      display: flex;
      justify-content: flex-end;
   }
   .wish-note-wrapper {
      display: flex;
      align-items: flex-start;
   }
   p {
      display: inline-block;
      margin-right: 15px;
      margin-bottom: 0;
      max-width: 420px;
   }
   i {
      font-size: 20px;
      width: 30px;
      color: #000;
   }
   textarea {
      padding: 3px 15px;
      border-radius: 3px;
      border: 1px solid #ccc;
      margin-right: 10px;
      font-size: 14px;
      font-weight: 100;
      width: 420px;
   }
   textarea::placeholder {
    color: #dedede !important;
    opacity: 1; /* Firefox */
    font-style: italic;
  }
</style>