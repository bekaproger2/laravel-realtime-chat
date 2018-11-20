<template>

</template>

<script>
    export default {
        props: ['user_id'],
        data(){
            return {

            }
        },
        mounted() {
            var th = this;

            window.Echo.private('user.' + th.user_id + '.comment')
                .listen('CommentEvent', (data)=>{
                    console.log(data);
                    console.log('cdddddddddddddddddddddddddddddddddddddd')
                });
            window.Echo.private('user.' + th.user_id + '.like')
                .listen('LikeEvent', (data)=>{
                    console.log(data);
                });

        }
    }
</script>
