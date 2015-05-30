<?php

class AdminController extends BaseController{

    /** @var  AdminService */
    private $adminService;

    function __construct()
    {
        $this->adminService = App::make('AdminService');
    }


    public function goToAdminPagina(){
        return View::make('admin/admin')->with(array('title'=>'Admin'));
     }

     public function backupDatabase($username = null, $password = null){
        $authenticationSuccessfull = $this->authenticate($username, $password);

        if($authenticationSuccessfull){
            $this->adminService->backupDatabase();
            return Redirect::to('getBooks');
        }
        return Redirect::to('login');
     }

     private function authenticate($username = null, $password = null){
        $authenticationSuccessfull = false;
        
        if(Auth::check() and Auth::user()->admin == true){
            $authenticationSuccessfull = true;
        }else if(Auth::attempt(array('username' => $username, 'password' => $password, 'admin' => true))){
            $authenticationSuccessfull = true;
        }
        return $authenticationSuccessfull;
     }
}