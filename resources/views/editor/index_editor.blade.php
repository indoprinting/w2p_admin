<!DOCTYPE HTML>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDP | {{ $title ?? 'Cetak Expres, Harga Ngepres, Kualitas The Best' }}</title>
    <meta content="indoprinting" name="description">
    <meta content="indoprinting" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/images/logo/favicon.png') }}" rel="icon">
    <!-- Style sheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('editor-online/css/main.css') }}">

    <!-- The CSS for the plugin itself - required -->
    <link rel="stylesheet" type="text/css" href="{{ asset('editor-online/css/FancyProductDesigner-all.css') }}" />

    <!-- Include required jQuery files -->
    <script src="{{ asset('editor-online/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('editor-online/js/jquery-ui.min.js') }}" type="text/javascript"></script>

    <!-- HTML5 canvas library - required -->
    <script src="{{ asset('editor-online/js/fabric.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('editor-online/js/jquery-confirm.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('editor-online/js/jquery-confirm.min.css') }}" type="text/javascript"></script>
    <!-- The plugin itself - required -->
    <script src="{{ asset('editor-online/js/FancyProductDesigner-all.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var $yourDesigner = $('#2'),
                pluginOpts = {
                    productsJSON: '/editor-online/products/json/kartu-nama.json', //see JSON folder for products sorted in categories
                    designsJSON: '/editor-online/clipart/clipart.json', //see JSON folder for designs sorted in categories
                    editorMode: false,
                    smartGuides: true,
                    uiTheme: 'doyle',
                    fonts: <?= $fonts ?>,
                    customTextParameters: {
                        colors: true,
                        removable: true,
                        resizable: true,
                        draggable: true,
                        rotatable: true,
                        autoCenter: true,
                        boundingBox: "Base",
                        curvable: true
                    },
                    customImageParameters: {
                        draggable: true,
                        removable: true,
                        resizable: true,
                        rotatable: true,
                        scaleX: 0.1,
                        scaleY: 0.1,
                        autoCenter: true,
                        boundingBox: "Base"
                    },
                    actions: {
                        'right': ['magnify-glass', 'zoom', 'reset-product', 'ruler'],
                        'bottom': ['undo', 'redo'],
                        'left': ['manage-layers', 'info', 'save', 'load']
                    }
                },

                yourDesigner = new FancyProductDesigner($yourDesigner, pluginOpts);

            $('#save-image-php').click(function() {
                $.confirm({
                    theme: 'bootstrap',
                    title: 'Confirm!',
                    boxWidth: '30%',
                    useBootstrap: false,
                    content: 'Sudah yakin dengan desainnya?',
                    buttons: {
                        confirm: function() {
                            yourDesigner.getProductDataURL(function(dataURL) {
                                var a = $.post("/products/savedesign2", {
                                        base64_image: dataURL
                                    },
                                    function(status) {
                                        window.location.replace(status);
                                    });
                            });
                        },
                        cancel: function() {}
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div id="main-container">
        <p class="fpd-container">
            <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
        </p>
        <div id="2" class="fpd-shadow-2 fpd-topbar fpd-tabs fpd-tabs-side fpd-top-actions-centered fpd-bottom-actions-centered fpd-views-inside-left"> </div>
        <br />
    </div>
</body>

</html>
