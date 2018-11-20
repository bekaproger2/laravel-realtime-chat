<template>
<div>
    <div :id="message.id" class="media text-muted pt-3" >
      <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray" style="float:left">
        <div class="d-flex justify-content-between align-items-center w-100">
          <p class="message-user-info"><strong class="text-gray-dark">{{message.sender}}</strong>  messageed <small>{{new Date(Date.parse(message.created_at['date'])).toDateString()}}</small> </p> 
          <p></p>
        </div> 
        <span class="d-block user-message">{{message.message}}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name : 'chatMessage',
  props: ['message'],
  data(){
    return {

    }
  }
}
</script>
<style>
.message-user-info{
  font-size: 16px;
}
.user-message{
  font-size: 16px;
}
</style>
