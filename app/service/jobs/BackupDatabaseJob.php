<?php 
	$logger = new Katzgrau\KLogger\Logger(app_path().'/storage/logs');

	$logger->info("Starting back up from database job");

		$databaseUser = Config::get("database.connections")['mysql']['username'];
		$databaseName = Config::get("database.connections")['mysql']['database'];
		$databasePassword = Config::get("database.connections")['mysql']['password'];

		$backUpScriptLocation = Config::get("properties.backupScriptLocation");
		$mySqlLocation = Config::get("properties.mysqlLocation");

		$commandToExecute = $mySqlLocation . 
								"mysqldump -u$databaseUser -p$databasePassword $databaseName > $backUpScriptLocation"
								."backup_bibliomania-$(date '+%Y-%m-%d').sql;"."echo $backUpScriptLocation"
								."backup_bibliomania-$(date '+%Y-%m-%d').sql";

		$logger->info("executing command: " . $commandToExecute);
		$returnFromCommand = shell_exec($commandToExecute);

		$logger->info("Backup script location: " . $returnFromCommand);

        $client = new Google_Client();
        $client->setClientId(Config::get('googleAPI.client_id'));
        $client->setClientSecret(Config::get('googleAPI.client_secret'));
        $client->setRedirectUri(Config::get('googleAPI.redirect_uri'));
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setAccessType('offline');
        $client->refreshToken(GoogleApiRepository::getRefreshTokenFromUser(Auth::user()->username));

        if ($client->getAccessToken()) {
        	$service = new Google_Service_Drive($client);
        	$file = new Google_Service_Drive_DriveFile();
        	$file->setTitle('backup_bibliomania-'. date('Y-m-d').'.sql');
        	$file->setDescription('Backup bibliomania');
        	$file->setMimeType('text/plain');

        	$parent = new Google_Service_Drive_ParentReference();
			$parent->setId("0B8y8VzpL9OuNfmRDeWFKU043ZTRSSjlzLWp2T0VjU20za0dkU0lOYkttakIwTk1nZmRvdEU");
			$file->setParents(array($parent));

        	$data = file_get_contents(trim($returnFromCommand));

	        $createdFile = $service->files->insert($file, array(
	              'data' => $data,
	              'mimeType' => 'text/plain',
	              'uploadType' => 'media'
	            ));
	        }

	$logger->info("Finished backup from database");
?>