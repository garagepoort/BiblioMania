<?php

class PersonalBookInfoToElasticMapper
{

	public function map(PersonalBookInfo $personalBookInfo){
		$giftInfo = null;
		$buyInfo = null;
		$retrieveDate = null;

		if ($personalBookInfo->gift_info) {
			$giftInfo = [
				'from' => $personalBookInfo->gift_info->from,
				'gift_date' =>$personalBookInfo->gift_info->receipt_date
			];
			$retrieveDate =$personalBookInfo->gift_info->receipt_date;
		}

		if ($personalBookInfo->buy_info) {
			$buyInfo = [];

			if($personalBookInfo->buy_info->city){
				$buyInfo['city'] = [
					'id' => intval($personalBookInfo->buy_info->city->id),
					'name' => $personalBookInfo->buy_info->city->name
				];
			}
			$buyInfo['price'] = $personalBookInfo->buy_info->price_payed;
			$buyInfo['buy_date'] = $personalBookInfo->buy_info->buy_date;
			$buyInfo['country'] = $personalBookInfo->buy_info->country_id;
			$buyInfo['city'] = $personalBookInfo->buy_info->city_id;
			$buyInfo['shop'] = $personalBookInfo->buy_info->shop;
			$retrieveDate = $personalBookInfo->buy_info->buy_date;
		}

		/** @var ReadingDate $date */
		$readingDates = array_map(function($date){
			return [
				'date' => $date->date,
				'review' => $date->review,
				'rating' => $date->rating,
			];
		}, $personalBookInfo->reading_dates->all());

		return [
			'id' => intval($personalBookInfo->id),
			'userId' => intval($personalBookInfo->user_id),
			'inCollection' => $personalBookInfo->get_owned(),
			'reasonNotInCollection' => $personalBookInfo->reasonNotInCollection,
			'giftInfo' => $giftInfo,
			'buyInfo' => $buyInfo,
			'retrieveDate' => $retrieveDate,
			'readingDates' => $readingDates
		];
	}

	/**
	 * @param $book
	 * @return PersonalBookInfo
	 */
	public function mapPersonalBookInfos($personalBookInfos)
	{
		return array_map(function ($personalBookInfo) { return $this->map($personalBookInfo); }, $personalBookInfos);
	}
}