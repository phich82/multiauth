<?php

namespace App\Http\Controllers;

use App\Services\CSV;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    /**
     * download csv file
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|null
     */
    public function downloadCSV(Request $request, CSV $csv)
    {
        // get params
        $params = [
            'unit'         => $request->get('unit', null),
            'sortAP'       => $request->get('sortActivityPurchase'),
            'activityArea' => $request->get('activityArea', null),
            'activityDate' => $request->get('activityDate', null),
            'purchaseDate' => $request->get('purchaseDate', null)
        ];

        // get promotions
        $promotions = $this->getAllPromotions($params, $this->mileType);

        // error restful api
        if (empty($promotions)) {
            return null;
        }

        // replace the default values in promotions
        $replaces = [
            'rate_type' => [
                \Constant::UNIT_AREA     => $this->configPrivate['rate_type']['UNIT_AREA'],
                \Constant::UNIT_ACTIVITY => $this->configPrivate['rate_type']['UNIT_ACTIVITY']
            ]
        ];

        // set the required fields & titles in csv file
        $titles = [
            'unit_name'           => $this->configPrivate['csv_title']['unit_name'],
            'promotion_name'      => $this->configPrivate['csv_title']['promotion_name'],
            'activity_start_date' => $this->configPrivate['csv_title']['activity_start_date'],
            'activity_end_date'   => $this->configPrivate['csv_title']['activity_end_date'],
            'purchase_start_date' => $this->configPrivate['csv_title']['purchase_start_date'],
            'purchase_end_date'   => $this->configPrivate['csv_title']['purchase_end_date'],
            'rate_type'           => $this->configPrivate['csv_title']['rate_type'],
            'amount'              => $this->configPrivate['csv_title']['amount'],
        ];

        // csv filename
        $filename = 'promotionlist_'.date('Ymdis');

        return $csv->filename($filename)
                   ->replaces($replaces)
                   ->titles($titles)
                   ->contents($promotions->toArray())
                   ->sendStream(true);
    }
}
