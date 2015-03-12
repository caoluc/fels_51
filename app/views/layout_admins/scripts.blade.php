@if (App::environment('local'))
<script src="{{ url_ex('js/jquery-2.1.1.min.js') }}"></script>
<script src="{{ url_ex('js/jquery-ui-1.11.1.min.js') }}"></script>
<script src="{{ url_ex('js/bootstrap-3.2.0.min.js') }}"></script>
<script src="{{ url_ex('js/knockout-3.2.0.min.js') }}"></script>
@else
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/knockout/3.2.0/knockout-min.js"></script>
@endif
<script src="{{ url_ex('js/adminlte/app.js') }}"></script>
<script src="{{ url_ex('js/jquery.history.min.js') }}"></script>
<script src="{{ url_ex('js/spin.min.js') }}"></script>
<script src="{{ url_ex('js/ladda.min.js') }}"></script>
<script type="application/javascript">
if( typeof fels_51 === 'undefined') {
    fels_51 = {
        optionValues : {},
        defaultOptions: {
            "offset": 0,
            "limit": 20,
            "order": "id",
            "direction": "asc"
        },
        model: [],
        target: ""
    };

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
}
</script>
<script src="{{ url_ex('js/plugins/bootstrap-growl/bootstrap-growl.js') }}"></script>
<script src="{{ url_ex('js/shared/common.js') }}"></script>
