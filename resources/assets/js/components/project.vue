<template>
    
    <div class="my-3 p-3 bg-white rounded box-shadow"  >
      <div class="container">
      <div class="jumbotron mt-3">
        <h1>{{project.name}}</h1>
        <p class="lead">This example is a quick exercise to show how my basic website works.</p>
        <p>Description: </p>
        <p class="lead">{{project.desc}}</p>
        <form class="comment-like-form" @click.prevent="like" >
          <input type="hidden" :value="csrf" name="_token">
          <input class="like btn btn-lg btn-primary" style="color: #fff;" type="submit" :value="isLiked ? 'Dislike' : 'Like this project'">
          <p><small style="color: #6c757d; font-size: 10px;">{{likes_number}}</small></p>
      </form>
      <div v-if="project.user_id == user_id">
      <a :href="'/project/' + project_id + '/edit'" >Edit</a>
      <form @submit.prevent = "deleteProject">
        <input type="hidden" value="DELETE" name="_method">
        <input type="hidden" :value="csrf" name="_token">
        <input class="like btn" style="color: #fff;" type="submit" value = "Delete" >
      </form>
      </div>
      </div>
      <h3>Comments</h3>
        <comment   v-for="(cmnt, index) in comments"
		 @deleteComment="deleteComment(index)"
		:key=cmnt.id 
		:comment = cmnt 
		:comment_url = comment_url  
		:csrf=csrf 
		:current_user_id=user_id
    :index=index
    :active_users=active_users
    >
		</comment>
        <div class="input-group mb-3">
          <form id="comment-form" @submit.prevent = "sendComment">
            <input type="hidden" :value="csrf" name="_token">
            <input name="content" v-model="comment" type="text" class="form-control" placeholder="Write your comment" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Comment</button>
            </div>   
          </form>
          </div>
          </div>
      </div>
</template>

<script>
import commentComponent from "./comment.vue";

export default {
  props: ["project_id", "username", "user_id", "liked"],
  data() {
    return {
      comment: "",
      comments: [],
      isLiked: this.liked,
      likes_number: "",
      project: "",
      comment_url: "/project/" + this.project_id + "/comment/",
      active_users: [],
      csrf: $('meta[name="csrf-token"]').attr("content")
    };
  },
  computed: {
    channel() {
      return window.Echo.join("project." + this.project_id);
	},
	realTimeComments(){
		return window.Echo.private("user." + this.user_id + ".comment")
	}
  },
  mounted() {
    var th = this;
    $('meta[name="user"]').attr("data-comment", false);
    axios.get("/api/project/" + th.project_id, {
        headers: {
          "X-CSRF-TOKEN": th.csrf
        }
      }).then(function(data) {
        th.project = data.data.data;
        th.comments = data.data.data.comments;
        th.likes_number = th.project.likes;
      });

    this.realTimeComments.listen("CommentEvent",function(data) {
        let parsedData = data.msg;
        switch (data.msg.type){
          case 'creating' :
            th.comments.push(parsedData.comment);
            break;
          case 'editing' : 
            th.comments[parsedData.index].content = parsedData.comment;
            break;
          case 'deleting' : 
          console.log(parsedData.index);
            th.deleteComment(parsedData.index);
            break;
            
        }
      }
    );

    this.channel.here(users => {
        th.active_users = users;
        console.log(th.active_users);
      }).joining(user => {
        th.active_users.push(user);
      }).leaving(user => {
        th.active_users.splice(th.active_users.indexOf(user), 1);
      });
  },
  methods: {
    sendComment() {
      let th = this;
      if (this.comment == "") {
        return;
      }
      axios.post(th.comment_url, {
          headers: {
            "X-CSRF-TOKEN": th.csrf
          },
          data: JSON.stringify(th.comment),
          active_users: th.active_users,
          type : 'creating'
        }).then(data => {
          var newComment = data.data.data;
          th.comments.push(newComment);
        }).catch(function(error) {
          console.log(error);
        });

      th.comment = "";
    },
    deleteProject() {
      let th = this;
	  axios.post("/project/" + th.project_id, {
		headers: {
          "X-CSRF-TOKEN": th.csrf
		},
		_method : 'DELETE'
	  }).then((data)=> window.location.href = '/project')
    },

    deleteComment(index) {
      this.comments.splice(index, 1);
    },

    like() {
      let th = this;
      axios.post("/project/" + th.project_id + "/like", {
          headers: {
            "X-CSRF-TOKEN": th.csrf
          },
          isLike: th.isLiked,
          projectId: th.project_id
        }).then(data => {
          th.likes_number = data.data["likes"] == "" ? 0 : data.data["likes"];
        }).catch(data => {
          console.log(data);
        });
      this.isLiked = !this.isLiked;
    }
  },
  components: {
    comment: commentComponent
  }
};
</script>

