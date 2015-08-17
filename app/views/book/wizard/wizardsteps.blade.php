<ul class="nav nav-pills nav-wizard">
    @foreach ($wizardSteps as $key => $wizardStep)
        <li class="wizard-step">
            @if($key == $currentStep)
                @if($key != 1)
                    <div class="nav-wedge nav-wedge-current"></div>
                @endif

                <div class="wizard-step-content wizard-step-current">{{ $wizardStep->title }}</div>

                @if($key != count($wizardSteps))
                    <div class="nav-arrow nav-arrow-current"></div>
                @endif
            @elseif($progress == 'COMPLETE' || $key <= $progress)
                @if($key != 1)
                    <div class="nav-wedge nav-wedge-before"></div>
                @endif

                <div class="wizard-step-content wizard-step-before"
                     onclick="setRedirectTo({{ $key }}); submitForm();">{{ $wizardStep->title }}</div>

                @if($key != count($wizardSteps))
                    <div class="nav-arrow nav-arrow-before"></div>
                @endif
            @else
                @if($key != 1)
                    <div class="nav-wedge"></div>
                @endif

                <div class="wizard-step-content">{{ $wizardStep->title }}</div>

                @if($key != count($wizardSteps))
                    <div class="nav-arrow"></div>
                @endif
            @endif
        </li>
    @endforeach
</ul>