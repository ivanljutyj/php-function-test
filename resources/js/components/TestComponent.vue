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
                <button type="button" class="btn btn-primary mt-3" @click="addFunction">Add new
                    function
                </button>
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
        functions: [{
          code: 'function test() { }'
        }],
        cmOptions: {
          tabSize: 4,
          mode: 'text/x-php',
          theme: 'base16-dark',
          lineNumbers: true,
          line: true,
        }
      }
    },
    methods: {
      addFunction() {
        this.functions.push({
            code: 'function test'+this.functions.length+'() { }'
        })
      }
    }
  }
</script>

<style scoped>
</style>
