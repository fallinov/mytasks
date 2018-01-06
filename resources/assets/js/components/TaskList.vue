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
                    <div class="float-left p-1">
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
                        <div class="float-left">
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
    //TODO Personaliser les message d'erreur côté serveur
    //TODO Affichage des messages de confirmation et d'erreur à l'utilisateur
    //TODO Tri par drag & drop des tâches (ajout order dans BD)
    //TODO Redisgn avec https://bulma.io/
    //TODO Créer application smartphone
    export default {
        data: function () {
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

        created: function () {
            this.fetchTaskList();
        },

        computed: {},

        methods: {
            isEdit(id) {
                return this.taskEdit.id === id;
            },

            resetTaskEdit() {
                this.taskEdit.id = '';
                this.taskEdit.body = '';
            },

            logError(error) {
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    console.log(error.response.data);
                    console.log(error.response.status);
                    console.log(error.response.headers);
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
                console.log(error.config);
            },

            fetchTaskList () {
                axios.get('api/tasks')
                    .then((response) => {
                        this.list = response.data;
                    })
                    .catch((error) => this.logError(error) );
            },

            createTask () {
                axios.post('api/tasks', this.taskNew)
                    .then((response) => {
                        this.taskNew.body = '';
                        this.fetchTaskList();
                        this.$refs.taskinput.focus();
                    })
                    .catch((error) => this.logError(error) );
            },

            updateTask () {
                axios.patch('api/tasks/' + this.taskEdit.id, this.taskEdit)
                    .then((response) => {
                        this.resetTaskEdit();
                        this.fetchTaskList();
                    })
                    .catch((error) => this.logError(error) );
            },

            editTask(id) {
                axios.get('api/tasks/' + id)
                    .then((response) => {
                        this.taskEdit.id = response.data[0].id;
                        this.taskEdit.body = response.data[0].body;
                        /* Après le prochain rafraichissement de Vue.js.
                           Vue.nextTick() nous permet d'attendre que la direcitve v-if sur l'input lié à this.taskEdit.id
                           soit appliquée */
                        Vue.nextTick().then(() => document.querySelector('#taskEdit').focus());
                    })
                    .catch((error) => this.logError(error) );
            },

            deleteTask(id) {
                axios.delete('api/tasks/' + id)
                    .then((res) => {
                        this.fetchTaskList()
                    })
                    .catch((error) => this.logError(error) );
            },
        }
    }
</script>