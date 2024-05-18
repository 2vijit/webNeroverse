<!-- Vendor js -->
<script src="{{url('/public/assets/js/vendor.min.js')}}"></script>

<!-- Plugins js-->
<script src="{{url('/public/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
{{--<script src="{{url('/public/assets/libs/apexcharts/apexcharts.min.js')}}"></script>--}}

<script src="{{url('/public/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>

<!-- Footable js -->
<script src="{{url('/public/assets/libs/footable/footable.all.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('/public/assets/js/pages/foo-tables.init.js')}}"></script>

<!-- Bootstrap Tables js -->
<script src="{{url('/public/assets/libs/bootstrap-table/bootstrap-table.min.js')}}"></script>

<!-- Init js -->
<script src="{{url('/public/assets/js/pages/bootstrap-tables.init.js')}}"></script>

<!-- third party js -->
<script src="{{url('/public/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('/public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{url('/public/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('/public/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')}}"></script>
<!-- third party js ends -->

<!-- Tickets js -->
<script src="{{url('/public/assets/js/pages/tickets.js')}}"></script>

<script src="{{url('/public/assets/libs/mohithg-switchery/switchery.min.js')}}"></script>
<script src="{{url('/public/assets/libs/multiselect/js/jquery.multi-select.js')}}"></script>
<script src="{{url('/public/assets/libs/select2/js/select2.min.js')}}"></script>
{{--<script src="{{url('/public/assets/libs/jquery-mockjax/jquery.mockjax.min.js')}}"></script>--}}
<script src="{{url('/public/assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js')}}"></script>
<script src="{{url('/public/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{url('/public/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>


<!-- Init js-->
{{--<script src="{{url('/public/assets/js/pages/form-advanced.init.js')}}"></script>--}}

<!-- Dashboar 1 init js-->
{{--<script src="{{url('/public/assets/js/pages/dashboard-1.init.js')}}"></script>--}}

<!-- App js-->
<script src="{{url('/public/assets/js/app.min.js')}}"></script>

<!-- CKEDITOR -->
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>


<script>
    CKEDITOR.config.extraAllowedContent = '*(*);*{*}';
</script>
<!--toastr-->
<script src="{{url('/public/assets/js/toastr.min.js')}}"></script>
<script>
    @if(session('message'))
    toastr.info('{{session('message')}}')
    @endif
    @if(session('warning'))
    toastr.warning('{{session('warning')}}')
    @endif
    @if(session('success'))
    toastr.success('{{session('success')}}')
    @endif
    @if(session('danger'))
    toastr.error('{{session('danger')}}')
    @endif

    //Jquery On ecnyer event bonding
    (function($) {
        $.fn.onEnter = function(func) {
            this.bind('keypress', function(e) {
                if (e.keyCode === 13) func.apply(this, [e]);
            });
            return this;
        };
        })(jQuery);
</script>
<!--toastr-->



@yield('footer.js')
