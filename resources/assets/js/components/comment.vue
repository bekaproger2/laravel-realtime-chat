<template>
<div>
    <div :id="comment.id" class="media text-muted pt-3" >
      <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" style="float:left">
        <div class="d-flex justify-content-between align-items-center w-100">
          <p class="comment-user-info"><strong class="text-gray-dark">{{comment.username}}</strong>  commented <small>{{new Date(Date.parse(comment.created_at['date'])).toDateString()}}</small></p>
          <div v-if="current_user_id == comment.user_id ">
            <a href="#" @click.prevent="show_edit_form = !show_edit_form" >Edit</a><br>
            <a href="#" @click.prevent="deleteComment(comment.id)" >Delete</a> 
          </div> 
          <p></p>
        </div> 
        <span class="d-block user-comment">{{comment.content}}</span>
      </div>
    </div>
    <div class="input-group mb-3" v-show="show_edit_form" >
      <form id="edit-form" @submit.prevent = "editComment()">
        <input name="_method" value="PUT" type="hidden" >
        <input type="hidden" :value="csrf" name="_token" >
        <input v-model="edited_comment" type="text" class="form-control" placeholder="Edit your comment" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Edit</button>
        </div>   
      </form>
    </div>
  </div>
 
</template>

<script>
export default {
  name: "commentComponent",
  props: ["comment", "current_user_id", "comment_url", "csrf", 'index', 'active_users'],
  data() {
    return {
      edited_comment: "",
      show_edit_form: false
    };
  },
  methods: {
    editComment() {
      let th = this;
      axios
        .put(th.comment_url + this.comment.id, {
          headers: {
            "X-CSRF-TOKEN": th.csrf
          },
          type : 'editing',
          index : th.index,
          active_users : th.active_users,
          data: JSON.stringify(th.edited_comment)
        })
        .then(data => {
          th.comment.content = JSON.parse(data.data.comment);
        })
        .catch(error => {
          console.log(error);
        });
      th.show_edit_form = false;
    },
    deleteComment(id) {
      let th = this;
      axios
        .post(this.comment_url + id, {
          	headers: {
            	"X-CSRF-TOKEN": this.csrf
          	},
            _method: "DELETE",
            active_users : th.active_users,
            type : 'deleting',
            index : th.index
		})
		.catch(data => {
			console.log(data);
		});

		this.$emit('deleteComment');
    }
  }
};
</script>

