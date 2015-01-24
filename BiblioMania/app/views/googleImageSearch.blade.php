<div id={{ $contentDivId }}>
    {{ HTML::image('images/ajax-loader.gif', 'loader', array('class'=>'googleSearchLoader')) }}
    <table class="google-image-search-table" hidden>
    </table>
</div>
<div id="branding"  style="float: left;"></div><br />
<input id={{ $imageUrlInput }} name={{ $imageUrlInput }} hidden>
{{ HTML::script('assets/js/other/googleImageSearch.js'); }}