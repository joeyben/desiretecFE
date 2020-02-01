<template>
   <div class="col-md-6 wish-note" >

      <textarea v-if="editMode"
               name="note"
               ref="note"
               maxlength="200"
               value=""
               v-model="note"
               :placeholder="placeholderText"
               @keyup.enter="saveNote()"
               @focus="isFocused = true" />
      <a v-if="editMode"
               @click.prevent="saveNote();">
         <i v-if="isFocused" class="fal fa-save"></i>
         <i v-else class="fal fa-edit"></i>
      </a>

      <p v-if="!editMode">{{ this.note }}</p>
      <a v-if="!editMode"
               @click.prevent="editMode = true">
         <i class="fal fa-edit"></i>
      </a>

   </div>

</template>

<script>
   export default {
      data() {
         return {
            editMode: false,
            isFocused: false,
            note: '',
            placeholderText: '',
         };
      },

      props: ['wishid', 'wishnote', 'lang'],

      mounted() {
         this.note = this.wishnote;
         this.placeholderText = this.lang;

         if (!this.note) {
            this.editMode = true;
         }
      },

      methods: {
         saveNote() {
            axios.post('/wishes/note/update', {
               id: this.wishid,
               note: this.note
            }).then(function (response) {
            })
            .catch(function (error) {
               console.log(error);
            });

            this.resetEditMode();
         },
         resetEditMode() {
            this.editMode = false;
            this.isFocused = false;
         },
      }
   }
</script>

<style scoped>
   .wish-note {
      display: flex;
      justify-content: flex-end;
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

   @media (max-width: 768px) {
      p {
         max-width: 240px;
      }
      textarea {
         width: 240px;
      }
      .wish-note {
         padding: 1em;
      }
   }
</style>
