<div id="content">
    <table id="google-image-search-table" class="google-image-search-table">
    </table>
</div>
<div id="branding"  style="float: left;"></div><br />
<input id={{ $imageUrlInput }} name={{ $imageUrlInput }} hidden>
<script type="text/javascript">
    var imageUrlInput = {{ $imageUrlInput }};
</script>
{{ HTML::script('assets/js/other/googleImageSearch.js'); }}