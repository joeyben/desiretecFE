<div class="kwp-header-dynamic">
    <div class="kwp-color-overlay"></div>
    <div class="kwp-logo"></div>
    <div class="kwp-header-text"><h1></h1></div>
</div>

<div class="kwp-content kwp-completed">
    <h1></h1>
    <p></p>
</div>

<script>
    jQuery(function($){
        $(document).ready(function () {
            var layerName = $('.tab-link.current').data('tab');

            var layers = @json($layers);
            var layer = layers.find(l => l.layer.path === layerName);

            dt.fillContent(layer, layers.length > 1);
        });
    });

    dt.Tracking.rawEvent('{{ $whitelabel_name }}_exitwindow', 'success', 'Form sent successfully');
</script>
