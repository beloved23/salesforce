 <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
             <script src="{{asset('js/select2.min.js')}}"></script>
         <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
                  <script src="{{asset('js/jquery.form-validator.js')}}"></script>
                                        <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
            <!-- start - This is for export functionality only -->
    @include('components.datatable_buttons')
    <!-- end - This is for export functionality only -->
    <script>
      //Display data in datable 
      $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
         "displayLength": 50
    });
         $.formUtils.addValidator({
  name : 'select_option',
  validatorFunction : function(value, $el, config, language, $form) {
    return /^\d+$/.test(value);
  },
  errorMessage : 'Please select an option',
  errorMessageKey: 'selectOption'
});
                    $.validate();
                                         $('.location-geography').select2();
    </script>