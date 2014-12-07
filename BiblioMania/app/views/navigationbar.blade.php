<div class="col-md-2 bs-sidebar hidden-print affix-top">
    @section('sidebar')
        <ul class="nav">
            <li>{{ HTML::link('getHuurders', trans('messages.navigatie.huurders'), array('id'=>'tenantsNavigationLink', 'title' => 'Huurders')) }}</li>
            <li>{{ HTML::link('getContracten', trans('messages.navigatie.contracten'), array('id'=>'contractsNavigationLink', 'title' => 'Ga naar de contracten pagina')) }}</li>
            <li>{{ HTML::link('getBetalingen', trans('messages.navigatie.betalingen'), array('id'=>'paymentsNavigationLink', 'title' => 'Betalingen')) }}</li>
            <li>{{ HTML::link('goToBetalendeHuurders', trans('messages.navigatie.betalingsOverzicht'), array('id'=>'contractsPayedForNavigationLink', 'title' => 'Bekijk huurders die betaald hebben')) }}</li>
            @if(UserManager::isLoggedIn() == true and UserManager::isAdmin() == true)
                <li>{{ HTML::link('adminPagina/', trans('messages.navigatie.adminpagina'), array('id'=>'adminNavigationLink', 'title' => 'Ga naar de adminpagina')) }}</li>
            @endif
        </ul>
    @show
</div>