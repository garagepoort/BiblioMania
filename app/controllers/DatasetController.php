<?php

use Bendani\PhpCommon\Utils\Ensure;
use e2e\datasetbuilders\UserCanAddAndRemoveBookFromWishlistDataSet;
use e2e\datasetbuilders\UserCanCreateBookDataSet;
use e2e\datasetbuilders\UserCanCreateFirstPrintInfoDataSet;
use e2e\datasetbuilders\UserCanLinkAndUnlinkAuthorToBookDataSet;
use e2e\datasetbuilders\UserCanLinkAndUnlinkOeuvreItemToBookDataSet;
use e2e\datasetbuilders\UserCanLinkExistingFirstPrintInfoToBookDataSet;

class DatasetController extends BaseController {

	private $datasets;

	/**
	 * DatasetController constructor.
	 */
	public function __construct()
	{
		$this->datasets = [
			'user.can.create.book' => new UserCanCreateBookDataSet(),
			'user.can.create.first.print.info' => new UserCanCreateFirstPrintInfoDataSet(),
			'user.can.link.existing.first.print.info.to.book' => new UserCanLinkExistingFirstPrintInfoToBookDataSet(),
			'user.can.link.and.unlink.author.to.book' => new UserCanLinkAndUnlinkAuthorToBookDataSet(),
			'user.can.add.and.remove.book.from.wishlist' => new UserCanAddAndRemoveBookFromWishlistDataSet(),
			'user.can.link.and.unlink.oeuvre.item.to.book' => new UserCanLinkAndUnlinkOeuvreItemToBookDataSet()
		];
	}


	public function executeDataset($datasetId){
		/** @var DataSet $dataset */
		$dataset = $this->datasets[$datasetId];
		Ensure::objectNotNull('dataset', $dataset);

		return $dataset->run();
	}

	public function resetDatabase()
	{
		$mysqli = new mysqli("localhost", $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD'], $_ENV['DATABASE_NAME']);
		$mysqli->query('SET foreign_key_checks = 0');
		if ($result = $mysqli->query("SHOW TABLES"))
		{
			while($row = $result->fetch_array(MYSQLI_NUM))
			{
				$mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
			}
		}
		$mysqli->query('SET foreign_key_checks = 1');
		$mysqli->close();

		Artisan::call('migrate', ['--path'     => "app/database/migrations"]);
		Artisan::call('db:seed');
	}

}
