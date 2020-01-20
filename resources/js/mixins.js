// define a mixin object
let myMixin = {
    created: function () {
        this.hello()
    },
    data() {
        return {
            alertMessage: 'Hoiii'
        }
    },
    methods: {
        hello: function () {
            console.log('hello from mixin!')
        }
    }
};
