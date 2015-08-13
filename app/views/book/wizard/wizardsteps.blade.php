<ul class="nav nav-pills nav-wizard">
    @foreach ($wizardSteps as $key => $wizardStep)
        <li>
            @if($key == $currentStep)
                @if($key != 1)
                    <div class="nav-wedge nav-wedge-current"></div>
                @endif

                <div class="wizard-step-content wizard-step-current">{{ $wizardStep }}</div>

                @if($key != count($wizardSteps))
                    <div class="nav-arrow nav-arrow-current"></div>
                @endif
            @elseif($key < $currentStep)
                @if($key != 1)
                    <div class="nav-wedge nav-wedge-before"></div>
                @endif

                <div class="wizard-step-content wizard-step-before">{{ $wizardStep }}</div>

                @if($key != count($wizardSteps))
                    <div class="nav-arrow nav-arrow-before"></div>
                @endif
            @else
                @if($key != 1)
                    <div class="nav-wedge"></div>
                @endif

                <div class="wizard-step-content">{{ $wizardStep }}</div>

                @if($key != count($wizardSteps))
                    <div class="nav-arrow"></div>
                @endif
            @endif
        </li>
    @endforeach
</ul>