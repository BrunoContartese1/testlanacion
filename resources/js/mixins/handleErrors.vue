<script>
  export default {
    methods: {
      $handleErrors(data) {

        let errors = '<ul>';
        for (var datos in data) {
            errors += '<li>' + data[datos] + '</li>';
        }
        errors += '</ul>';

        Vue.toasted.show(errors, {
                    className: 'error',
                    position: 'top-right',
                    duration: 5000
                })
        }
    }
  };
</script>
