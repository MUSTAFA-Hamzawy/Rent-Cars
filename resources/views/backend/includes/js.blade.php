<!-- Bootstrap JS -->
<script src="{{asset('assets')}}/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="{{asset('assets')}}/js/jquery.min.js"></script>
<script src="{{asset('assets')}}/plugins/simplebar/js/simplebar.min.js"></script>
<script src="{{asset('assets')}}/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="{{asset('assets')}}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
@yield('tags-input-script')
@yield('data-tables-script')
<!--app JS-->
<script src="{{asset('assets')}}/js/app.js"></script>

{{--<script src="{{asset('assets')}}/js/ajax.jquery.min.js"></script>--}}
{{--<script src="{{asset('assets')}}/js/bootstrap5.bundle.min.js"></script>--}}

{{--For showing the image --}}
{{--<script type="text/javascript">--}}
{{--    $(document).ready(function () {--}}
{{--        $('#brand_image').change(function (e) {--}}
{{--            var reader = new FileReader();--}}
{{--            reader.onload = function (e) {--}}
{{--                $('#show_image').attr('src', e.target.result);--}}
{{--            }--}}
{{--            reader.readAsDataURL(e.target.files['0']);--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
