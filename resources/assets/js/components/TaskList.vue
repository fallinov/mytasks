<template>
    <div>
        <h1>MyTasks</h1>
        <form action="#" @submit.prevent="createTask()" class="form-inline my-2 my-lg-0">

            <div class="form-row">
                <div class="col-9 input-group">

                    <input v-model="taskNew.body"
                           ref="taskinput"
                           class="form-control"
                           placeholder="Encore du travail ?"
                           aria-label="Search"
                           type="text"
                           autofocus>
                </div>

                <div class="col-3">
                    <button class="form-control btn btn-primary" type="submit">
                        <span class="oi oi-plus"></span>
                    </button>
                </div>
            </div>
        </form>

        <h2>All Tasks</h2>
        <ul class="list-group">
            <li v-for="item in list" :key="item.id" class="list-group-item p-2">

                <div v-if="!isEdit(item.id)" @click="editTask(item.id)">
                    <div  class="float-left p-1">
                        {{ item.body }}
                    </div>

                    <button @click="deleteTask(item.id)" class="btn btn-outline-danger btn-sm float-right">
                        <span class="oi oi-x"></span>
                    </button>

                    <button @click="editTask(item.id)" class="btn btn-outline-primary btn-sm float-right mr-1">
                        <span class="oi oi-pencil"></span>
                    </button>
                </div>
                <!-- En mode édition -->
                <div v-else>
                        <form action="#" @submit.prevent="updateTask()">
                            <div  class="float-left">
                                <input id="taskEdit" v-model="taskEdit.body" class="form-control">
                            </div>

                            <button @click.prevent="resetTaskEdit"
                                    type="button" class="btn btn-outline-secondary btn-sm float-right">
                                annuler
                            </button>

                            <button @click="" type="submit" class="btn btn-outline-success btn-sm float-right mr-1">
                                <span class="oi oi-check"></span>
                            </button>
                        </form>
                </div>


            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                list: [],
                taskNew: {
                    id: '',
                    body: ''
                },
                taskEdit: {
                    id: '',
                    body: ''
                }
            };
        },

        created: function() {
            this.fetchTaskList();
        },

        computed: {

        },

        methods: {
            isEdit(id) {
                return this.taskEdit.id === id;
            },

            resetTaskEdit() {
                this.taskEdit.id = '';
                this.taskEdit.body = '';
            },

            fetchTaskList: function() {
                axios.get('api/tasks').then((response) => {
                    this.list = response.data;
                });
            },

            createTask: function () {
                axios.post('api/tasks', this.taskNew)
                    .then((res) => {
                        this.taskNew.body = '';
                        this.fetchTaskList();
                        this.$refs.taskinput.focus();
                    })
                    .catch((err) => console.error(err));
            },

            updateTask: function() {
                axios.patch('api/tasks/' + this.taskEdit.id, this.taskEdit)
                    .then((res) => {
                        this.resetTaskEdit()
                        this.fetchTaskList();
                    })
                    .catch((err) => console.error(err));
            },

            editTask: function(id) {
                axios.get('api/tasks/' + id).then((response) => {
                    this.taskEdit.id = response.data[0].id;
                    this.taskEdit.body = response.data[0].body;
                    /*
                        Après le prochain rafraichissement de Vue.js.
                        Vue.nextTick() nous permet d'attendre que la direcitve v-if sur l'input soit appliquée afin qu'il existe
                     */
                    Vue.nextTick().then(() => document.querySelector('#taskEdit').focus());
                });
            },

            deleteTask(id) {
                axios.delete('api/tasks/' + id)
                    .then((res) => {
                        this.fetchTaskList()
                    })
                    .catch((err) => console.error(err));
            },
        }
    }
</script>