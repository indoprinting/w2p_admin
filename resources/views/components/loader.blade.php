<div id="loading">
    <div class="logoLoader"></div>
    <div class="textLoader">
        {{-- <img src="{{ asset('images/admin/loading.gif') }}" alt=""> --}}
        <div class="fulfilling-bouncing-circle-spinner">
            <div class="circle"></div>
            <div class="orbit"></div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("#loading").hide();
        $(".loader").hide();
        $('.loading').on('load', function() {
            $("#loading").hide();
            $(".loader").hide();
        });
        $('.loading').on('click', function() {
            $("#loading").show();
            $(".loader").show();
        });

        $(document).on('keyup', function(e) {
            if (e.key == "Escape") {
                $("#loading").hide();
                $(".loader").hide();
            }
        });

    });
</script>
