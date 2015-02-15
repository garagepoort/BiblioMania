<div id={{ $panelId }} class="container list-merge-container merge-container" hidden>
    <h5>{{ $title }}</h5>
    {{ Form::select('', array(), '', array('class' => 'input-sm form-control selectMerge')); }}
    <ul class="merge-list">
    </ul>
    <button class="btn btn-primary mergeButton">Samenvoegen</button>
</div>
{{ HTML::script('assets/js/other/merge.js'); }}