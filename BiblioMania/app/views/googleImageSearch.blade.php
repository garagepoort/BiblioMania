<div id="content">
    {{ HTML::image('images/ajax-loader.gif', 'loader', array('id'=>'loader-icon', 'class'=>'googleSearchLoader')) }}
    <table id="google-image-search-table" class="google-image-search-table" hidden>
    </table>
</div>
<div id="branding"  style="float: left;"></div><br />
<input id={{ $imageUrlInput }} name={{ $imageUrlInput }} hidden>
<script type="text/javascript">
    var imageUrlInput = "{{ $imageUrlInput }}";
</script>
{{ HTML::script('assets/js/other/googleImageSearch.js'); }}