<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderTranslation;
use App\Models\Service;
use App\Models\ServiceCountryDocument;
use App\Models\TrademarkDocument;
use App\Models\TrademarkServiceCountryDocument;
use App\Models\TranslationDocument;
use App\Utility\AllowedCurrencies;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;
use File;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 * @author Andrew Nady <andro.nady2015@gmail.com>
 */
class DocumentController extends Controller
{
    const STRIPE_FEES_PERCENTAGE = 3.5;

    /**
     * show required documents form
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function required_document($id)
    {
        try {
            $orderCountries = Order::where('id', $id)->with('trademark_country_order')->with('service_package')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return view('client.errors.copyof404');
        }

        $trademarkCountriesIds = [];
        foreach ($orderCountries->trademark_country_order as $trademarkCountryOrder) {
            $trademarkCountriesIds[] = $trademarkCountryOrder->trademark_country_id;
        }
        // get already added docs for all countries in order
        $addedDocuments = TrademarkDocument::whereIn('trademark_country_id', $trademarkCountriesIds)->get();
        // get ids of documents that already uploaded to exclude them from add again
        $excludeDocumentIds = [];
        foreach ($addedDocuments as $document) {
            $excludeDocumentIds[] = $document->document_id;
        }

        $countries = array();
        foreach ($orderCountries->trademark_country_order as $countryId) {
            $countries[] = $countryId->trademark_country->country->id;
        }

        $serviceId = $orderCountries->service_package->service->id;
        // if no added documents just get them all ELSE exclude documents that we don't need
        if ($addedDocuments->count() == 0) {
            $Documents = TrademarkServiceCountryDocument::where('service_id', $serviceId)->with('document')
                ->whereIn('country_id', $countries)->with('country')->get();
        } else {
            $Documents = TrademarkServiceCountryDocument::where('service_id', $serviceId)
                ->whereNotIn('document_id', $excludeDocumentIds)->with('document')
                ->whereIn('country_id', $countries)->with('country')->get();
        }
        $templateDocumentsCount = ServiceCountryDocument::where('service_id', $serviceId)
            ->whereIn('country_id', $countries)->count();
        return view('client.services.requiredDocuments', compact('id', 'Documents', 'orderCountries', 'templateDocumentsCount'));
    }

    /**
     * store documents in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRequiredDocument(Request $request)
    {
        $CountryIdConverted = json_decode($request->countryIdList, true);
        $trademarkCountryIdConverted = json_decode($request->trademarkCountryId, true);
        $validator = Validator::make($request->all(), [
            'document.*' => ['mimes:pdf','max:5096']
        ]);

        if ($validator->fails()) {
            //Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if(isset($request['document']) && count($request['document'])>0){
			foreach ($request['document'] as $key => $file) {
				$trademarkDocument = new  TrademarkDocument;
				$trademarkDocument->document_id = $request->doc_id[$key];
				foreach ($CountryIdConverted as $index => $CountryId) {
					if ($request->countryId[$key] == $CountryId) {
						$trademarkDocument->trademark_country_id = $trademarkCountryIdConverted[$index];
					}
				}
				// name incremental with 1 as index start from 0
				$fileName = $key + 1 . '_' . date('Y-m-d-H-i-s') . '_' . $file->getClientOriginalName();
				$trademarkDocument->document_file = $fileName;
				$trademarkDocument->save();
				$file->move(public_path('img/documents/'), $fileName);
			}
        Session::flash('success', 'uploaded successfully!');
        return redirect()->route('home');
		
		}else{
			return Redirect::back()->withErrors(['You should upload one file at least']);;
		}
    }

    /**
     * show Translation service form
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function translationDocuments($id)
    {
        return view('client.services.translationService', ['orderId' => $id]);
    }

    /**
     * store translation documents in DB
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function storeTranslationDocuments(Request $request)
    {
        $allServices = Service::all();
        $systemDefaultCurrencyCode = Session::get('systemDefaultCurrencyCode');
        $userCountryCurrencyCode = Session::get('userCountryCurrencyCode');
        $OrderTranslation = new OrderTranslation;
        $allowedCurrencies = new AllowedCurrencies();

        $validator = Validator::make($request->all(), [
            'Document.*' => ['mimes:doc,pdf,docx,xlsx,xls']
        ]);
        if ($validator->fails()) {
            Session::flash('error', $validator->messages());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        /*if (count($request->Document) !== intval($request->numberOfDoc)) {
            Session::flash('error', "Number of Documents must be same as the documents you trying to upload please try again");
            return Redirect::back()->withInput();
        }*/

        $OrderTranslation->order_id = $request->orderId;
        $OrderTranslation->page_no = $request->numberOfPages;
        //$OrderTranslation->document_no = $request->numberOfDoc;
        //$OrderTranslation->notes = $request->note;
        $totalFees = $request->numberOfPages * 20;
        // add 3.5 from here to all calculation process
        $totalFees = $totalFees + round(($totalFees * self::STRIPE_FEES_PERCENTAGE) / 100, 2);
        $OrderTranslation->total_price = $totalFees;
        if ($userCountryCurrencyCode !== $systemDefaultCurrencyCode) {
            $OrderTranslation->total_price_currency =
                $allowedCurrencies->convertCurrency($totalFees, $systemDefaultCurrencyCode, $userCountryCurrencyCode);
        } else {
            $OrderTranslation->total_price_currency = $totalFees;
        }
        $OrderTranslation->currency_type = $userCountryCurrencyCode;
        $OrderTranslation->save();

        foreach ($request['Document'] as $key => $file) {
            $TranslationDocument = new TranslationDocument;
            $TranslationDocument->order_translation_id = $OrderTranslation->id;
            $fileName = null;
            // name incremental with 1 as index start from 0
            $fileName = $key + 1 . '_' . date('Y-m-d-H-i-s') . '_' . $file->getClientOriginalName();
            $TranslationDocument->document_file = $fileName;
            $file->move(public_path('img/document_translation/'), $fileName);
            $TranslationDocument->save();
        }

        $orderTranslationId = $OrderTranslation->id;
        $orderTranslation = OrderTranslation::find($orderTranslationId);
        $order = Order::find($request->orderId);
        if ($orderTranslationId) {
           //return redirect()->route('stripe.create', ['id' => $orderTranslationId, 'isTranslationService' => true]);
		   return redirect('selectpayment/'.$orderTranslationId.'/false/1');
        } else {
           // return view('client.payment.stripe', compact('order', 'allServices', 'orderTranslationId', 'orderTranslation'))->with('isDocument', true);
              return redirect()->back();
		}
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadCountryDocument($id)
    {
        $orderCountries = Order::where('id', $id)->with('trademark_country_order')->with('service_package')->first();
        $countries = [];
        foreach ($orderCountries->trademark_country_order as $trademarkCountryOrder) {
            $countryId = $trademarkCountryOrder->trademark_country->country_id;
            $countries[$countryId] = $trademarkCountryOrder->trademark_country->country->country_name;
        }
        $serviceId = $orderCountries->service_package->service->id;
        $mainDirectoryName = 'document_templates'.time().rand();
        $mainDocumentTemplateDirectoryPath = public_path('/').$mainDirectoryName;
        File::makeDirectory($mainDocumentTemplateDirectoryPath);
        $filesCounter = 0;
        foreach ($countries as $countryId => $countryName) {
            $countryDocuments = ServiceCountryDocument::where('country_id', $countryId)
                ->where('service_id', $serviceId)->with('document')->get();
            if ($countryDocuments->count() > 0) {
                $filesCounter += $countryDocuments->count();
                $file = public_path("/$mainDirectoryName/$countryName");
                File::makeDirectory($file);

                
                foreach ($countryDocuments as $countryDocument) {
                    $currentFile = public_path()."/resource_center/document_template/".$countryDocument->document->doc_file;
                    $ext = pathinfo($currentFile, PATHINFO_EXTENSION);
                    $docName = str_replace(' ', '', $countryDocument->document->doc_title).".".$ext;
                    //return $docName;

                    $sourceFilePath = public_path()."/resource_center/document_template/".$countryDocument->document->doc_file;
                    $destinationPath = public_path()."/$mainDirectoryName/$countryName/".$docName;
                    File::copy($sourceFilePath, $destinationPath);
                }
            }
        }
         if ($filesCounter == 0) {
             File::deleteDirectory(public_path($mainDirectoryName));
             return abort(404);
         }

        $rootPath = realpath($mainDocumentTemplateDirectoryPath);

        $zip = new ZipArchive();
        $fileName = 'suggested_templates.zip';
        $zip->open(public_path($fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Is this a directory?
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        File::deleteDirectory(public_path($mainDirectoryName));
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }
}
