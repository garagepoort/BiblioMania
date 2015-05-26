<?php

class AdminService {

    public function backupDatabase(){
        include('../jobs/BackupDatabaseJob.php');
    }

}