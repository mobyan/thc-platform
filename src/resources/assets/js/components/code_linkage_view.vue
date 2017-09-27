<template>
    <div class="input-group">
        <!--         <input v-model="search.merged_name" :disabled="!editing" class="form-control" />
        <div class="input-group-btn">
            <button @click.prevent="searchInput()" :disabled="!editing" class="btn btn-white btn-primary"><i class="fa fa-search" /></button>
            <button @click.prevent="clearInput()" :disabled="!editing" class="btn btn-white btn-primary"><i class="fa fa-refresh" /></button>
        </div>
        <div class="search-select">
            <transition-group name="itemfade" tag="ul" mode="out-in" v-cloak v-show="isShow">
                <li v-for="(cv,index) in codes" :class="{selectback:index==now}" :key="index" @click.prevent="searchThis(index)" @mouseover="selectHover(index)" class="search-select-option search-select-list">
                    {{cv.merged_name}}
                </li>
            </transition-group>
        </div> -->
        <select v-model="select_1">
            <option v-for="item in level_1" v-bind:value="item">
                {{ item.name }}
            </option>
        </select>
        <select v-model="select_2" v-show="(level_2 != null)">
            <option v-for="item in level_2" v-bind:value="item">
                {{ item.name }}
            </option>
        </select>
        <select v-model="select_3" v-show="(level_3 != null)">
            <option v-for="item in level_3" v-bind:value="item">
                {{ item.name }}
            </option>
        </select>
        <select v-model="select_4" v-show="(level_4 != null)">
            <option v-for="item in level_4" v-bind:value="item">
                {{ item.name }}
            </option>
        </select>
        <select v-model="select_5" v-show="(level_5 != null)">
            <option v-for="item in level_5" v-bind:value="item">
                {{ item.name }}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    // props: ['code_object'],
    data: function() {
        return {
            level_1: null,
            level_2: null,
            level_3: null,
            level_4: null,
            level_5: null,
            select_1: null,
            select_2: null,
            select_3: null,
            select_4: null,
            select_5: null,
        }
    },
    methods: {
        // searchInput: function() {
        //     this.get();
        // },
    },
    watch: {
        select_1(curVal, oldVal) {
            this.select_2 = null;
            this.level_2 = null;
            if (this.select_1 != null) {
                this.$emit("codeChanged", this.select_1);
                // console.log("No.1", this.select_1.name);
                var self = this;
                this.$http.get('/api/code/searchLinkage?content=' + this.select_1.code).then(function(res) {
                    self.level_2 = [{ code: "0", name: "不限" }];
                    self.level_2 = self.level_2.concat(res.body);
                });
            }

        },
        select_2(curVal, oldVal) {
            this.select_3 = null;
            this.level_3 = null;
            if (this.select_2 == null) {
                return;
            }
            if (this.select_2.name == "不限") {
                this.$emit("codeChanged", this.select_1);
                // console.log("No.1", this.select_1.name);
                return;
            }
            this.$emit("codeChanged", this.select_2);
            // console.log("No.2", this.select_2.name);
            var self = this;
            this.$http.get('/api/code/searchLinkage?content=' + this.select_2.code).then(function(res) {
                self.level_3 = [{ code: "0", name: "不限" }];
                self.level_3 = self.level_3.concat(res.body);
            });
        },
        select_3(curVal, oldVal) {
            this.select_4 = null;
            this.level_4 = null;
            if (this.select_3 == null) {
                return;
            }
            if (this.select_3.name == "不限") {
                this.$emit("codeChanged", this.select_2);
                // console.log("No.2", this.select_2.name);
                return;
            }
            this.$emit("codeChanged", this.select_3);
            // console.log("No.3", this.select_3.name);
            var self = this;
            this.$http.get('/api/code/searchLinkage?content=' + this.select_3.code).then(function(res) {
                self.level_4 = [{ code: "0", name: "不限" }];
                self.level_4 = self.level_4.concat(res.body);
            });
        },
        select_4(curVal, oldVal) {
            this.select_5 = null;
            this.level_5 = null;
            if (this.select_4 == null) {
                return;
            }
            if (this.select_4.name == "不限") {
                this.$emit("codeChanged", this.select_3);
                // console.log("No.3", this.select_3.name);
                return;
            }
            this.$emit("codeChanged", this.select_4);
            // console.log("No.4", this.select_4.name);
            var self = this;
            this.$http.get('/api/code/searchLinkage?content=' + this.select_4.code).then(function(res) {
                self.level_5 = [{ code: "0", name: "不限" }];
                self.level_5 = self.level_5.concat(res.body);
            });
        },
        select_5(curVal, oldVal) {
            if (this.select_5 == null) {
                return;
            }
            if (this.select_5.name == "不限") {
                this.$emit("codeChanged", this.select_4);
                // console.log("No.4", this.select_4.name);
                return;
            }
            this.$emit("codeChanged", this.select_5);
            // console.log("No.5", this.select_5.name);
        },
    },
    created: function() {
        var self = this;
        this.$http.get('/api/code/searchLinkage?content=' + "0").then(function(res) {
            self.level_1 = res.body;
        });
    },
}
</script>