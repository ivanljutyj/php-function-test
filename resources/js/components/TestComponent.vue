<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5" v-for="(func, index) in functions">
                    <div class="card-header">Function #{{ index+1 }}</div>

                    <div class="card-body">
                        <codemirror v-model="func.code"
                                    :options="cmOptions"></codemirror>
                    </div>
                </div>
                <form class="form-inline mt-3">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mr-2"
                                @click="addFunction">Add new function
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mr-2"
                                @click="startTest">Start test
                        </button>
                    </div>
                    <div class="form-group">
                        <label class="mr-2">Iterations</label>
                        <input class="form-control" type="number"
                               v-model="iterations">
                    </div>
                </form>
                <div v-show="loading && !error">Tests are running...</div>

                <div class="error" v-show="error">
                    {{ error }}
                </div>
                <table class="table mt-3" v-show="testResults.length">
                    <thead>
                    <th>Function</th>
                    <th>Time</th>
                    <th>Memory</th>
                    <th>Memory Peak</th>
                    </thead>
                    <tbody>
                    <tr v-for="(result, index) in testResults">
                        <td>Function #{{ index + 1 }}</td>
                        <td>{{result.time}}</td>
                        <td>{{result.memory}}</td>
                        <td>{{result.memory_peak}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
  import {codemirror} from 'vue-codemirror'
  import 'codemirror/lib/codemirror.css'

  export default {
    name: "TestComponent",
    components: {
      codemirror
    },
    data() {
      return {
        loading: false,
        functions: [{
          code: '(function() { // code here })();'
        }],
        iterations: 100,
        options: [],
        testResults: [],
        cmOptions: {
          tabSize: 4,
          mode: 'text/x-php',
          theme: 'base16-dark',
          lineNumbers: true,
          line: true,
        },
        error: null
      }
    },
    methods: {
      addFunction() {
        this.functions.push({
          code: '(function() { // code here })();'
        })
      },
      startTest() {
        this.loading = true;
        axios.post('/api/test', {
          functions: this.functions,
          iterations: this.iterations
        }).then(response => {
          this.testResults = response.data;
          this.loading = false;
        }).catch((error) => {
          this.error = error.response.data.message;
        });
      }
    }
  }
</script>

<style scoped>
    .error {
        color: red;
        font-weight: bold;
    }
</style>
