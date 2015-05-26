<?php

class AdminService {

    public function backupDatabase(){
        include(app_path() . '/service/jobs/BackupDatabaseJob.php');
    }

}