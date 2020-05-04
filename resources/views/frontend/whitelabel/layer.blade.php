<script type="application/javascript">
    var whitelabel = @json($whitelabel);
    var brandColor = @json($whitelabel['color']);
    var layers = @json($whitelabel['layers']);
    var wl_name = @json($whitelabel['name']);
    var url = window.location.hostname;
    var whitelabelPrefix = (url.indexOf('reise-wunsch.de') !== -1
        || url.indexOf('wish-service.com') !== -1
        || url.indexOf('travelwishservice.com') !== -1
    ) ?  wl_name+"_WL" : wl_name;

    jQuery(function($){
        $(document).ready(function () {
            dt.initLayerVersion();
        });
    });
</script>
