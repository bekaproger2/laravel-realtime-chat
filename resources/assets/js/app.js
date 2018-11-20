
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('chat', require('./components/chat.vue'));
Vue.component('comment', require('./components/comment.vue'));
Vue.component('project', require('./components/project.vue'));

const app = new Vue({
    el: '#app',
    data : function(){
        return {
            msgs: ''
        }
    }

});

window.listenForComments = function(){
   
        if($('meta[name="user"]').attr('data-user-id') != false){
            
            window.Echo.private('user.' +  $('meta[name="user"]').attr('data-user-id') + '.comment')
            .listen('CommentEvent', function(data){
                if($('meta[name="user"]').attr('data-comment') === 'true'){
                    console.log('la la');
                    var ntfs = document.querySelector('#not-count').textContent;
                    document.querySelector('#not-count').textContent = parseInt(ntfs) + 1;
                }else{
                    return
                }
                
            });
            
        }else{
            return
        }
        
    }

// window.listenForMessages = function(listen){
//     if(listen == false || listen == "" ){
//         console.log('NO');
//         return
//     }else if (listen == true){
//         console.log('NO');
//         if($('meta[name="user"]').attr('data-user-id') != false){
//             console.log('NO');
//             window.Echo.private('chat.' +  $('meta[name="user"]').attr('data-user-id'))
//             .listen('Chat', function(data){
//                 console.log(data);
//                 var ntfs = document.querySelector('#not-count').textContent;
//                 document.querySelector('#not-count').textContent = parseInt(ntfs) + 1;
//             });
//         }else{
//             console.log('NO');
//             return
//         }
//     }
// }
window.onload = function (){
    window.listenForComments();
    // window.listenForMessages(Boolean($('meta[name="user"]').attr('data-inbox')))
}

            // $(document).ready(function(){
            //     window.Echo.private('user.' +  $('meta[name="csrf-token"]').attr('data-user-id') + '.comment')
            //         .listen('CommentEvent', function(data){
            //             console.log(data);
            //             var ntfs = document.querySelector('#not-count').textContent;
            //             document.querySelector('#not-count').textContent = parseInt(ntfs) + 1;

            //         });
            //     window.Echo.private('user.' + $('meta[name="csrf-token"]').attr('data-user-id') + '.like')
            //         .listen('LikeEvent', function(data){
            //             console.log(data);
            //         });

            // });
