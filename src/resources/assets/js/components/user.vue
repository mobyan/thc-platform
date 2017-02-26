<template>
    <div>
        <form>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" v-model="user.name" class="form-control" id="name" placeholder="name">
        </div>
        <div class="form-group">
            <label for="type">Email</label>
            <input type="text" v-model="user.email" class="form-control" id="type" placeholder="type">
        </div>
        <div class="form-group">
            <label for="type">AppId</label>
            <input type="text" v-model="user.app_id" class="form-control" id="type" placeholder="type">
        </div>
        <button type="submit" @click.prevent="save()" class="btn btn-default">Submit</button>
    </form>
</div>
</template>
<script >
export default {
        data : () => {
            return {
                user: {},
            }
        },
        created: function () {

            this.$http.get('/api/user/' + this.$route.params.user).then(res=>{
                this.user = res.body;
            })
        }
    }
</script>