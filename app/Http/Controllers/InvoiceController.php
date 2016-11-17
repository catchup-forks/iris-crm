<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use App\Office;
use App\Product;
use App\Quote;
use App\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the Invoice.
     */
    public function index($id)
    {

        //FIXME Les bonnes requetes vers l'organisation de l'utilisateur :)

        $office = Office::findOrFail($id);
        $invoices = $office->invoices;


        return view('pages.invoices.index')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new Invoice.
     */
    public function create($id)
    {

        //FIXME Les bonnes requetes vers l'organisation de l'utilisateur :)

        $office = Office::findOrFail($id);

        $contacts = $office->contacts;
        $quotes = $this->organization->quotes;
        $products = $this->organization->products;
        $services = $this->organization->services;

        return view('pages.invoices.create')->with(compact('office', 'contacts', 'quotes', 'services', 'products'));
    }

    /**
     * Store a newly created Invoice in storage.
     */
    public function store($id, InvoiceRequest $request)
    {

        //FIXME Les bonnes requetes vers l'organisation de l'utilisateur :)

        $input = $request->all();

        $office = Office::findOrFail($id);


        if ($invoice = Invoice::create($input)) {

            $htPrice = 0;
            $price = 0;
            $contact = Contact::findOrFail($request->contact_id);

            $invoice->office()->associate($office);

            if ($request->has('quote_id') && $request->quote_id != 0) {

                $quote = Quote::findOrFail($request->quote_id);
                $invoice->converted = true;

            } else {
                $invoice->converted = false;
            }

            // Serialize

            foreach ($request->products as $product) {

                $totalTaxes = 0;

                $product = Product::findOrFail($product->id);

                foreach ($product->taxes as $tax) {

                    if ($tax->is_active) {
                        $totalTaxes = $totalTaxes + ($product->ht_price * ($tax->value / 100));
                    }
                }

                $productHtPrice = $product->ht_price;
                $htPrice = $htPrice + $productHtPrice;

                $productPrice = $product->ht_price + $totalTaxes;
                $price = $price + $productPrice;

            }

            foreach ($request->services as $service) {

                $totalTaxes = 0;
                $service = Service::findOrFail($service->id);

                foreach ($service->taxes as $tax) {

                    if ($tax->is_active) {

                        $totalTaxes = $totalTaxes + ($service->ht_price * ($tax->value / 100));
                    }
                }

                $serviceHtPrice = $service->ht_price;
                $servicePrice = $service->ht_price + $totalTaxes;

                $htPrice = $htPrice + $serviceHtPrice;
                $price = $price + $servicePrice;

            }

            $invoice->ht_price = $htPrice;
            $invoice->ttc_price = $price;
            $invoice->save();

            Flash::success(Lang::get('app.general:create-success'));

        } else {

            Flash::error(Lang::get('app.general:create-failed'));
            return redirect(action('InvoiceController@create'));

        }

        return redirect(action('invoices.index'));
    }

    /**
     * Display the specified Invoice.
     *
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (empty($invoice)) {
            Flash::error(Lang::get('app.general:missing-model'));

            return redirect(action('InvoiceController@index'));
        }

        return view('pages.invoices.show')->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified Invoice.
     *
     */

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);

        $offices = $this->organization->offices;
        $contacts = $this->organization->contacts;
        $quotes = $this->organization->quotes;

        $products = $this->organization->products;
        $services = $this->organization->services;

        if (empty($invoice)) {
            Flash::error(Lang::get('app.general:missing-model'));

            return redirect(action('InvoiceController@index'));
        }

        return view('pages.invoices.edit')->with(compact('invoice', 'contacts', 'offices', 'quotes', 'products', 'services'));
    }

    /**
     * Update the specified Invoice in storage.
     */
    public function update($id, InvoiceRequest $request)
    {
        $input = $request->all();
        $invoice = Invoice::findOrFail($id);


        if (empty($invoice)) {

            Flash::error(Lang::get('app.general:missing-model'));
            return redirect(action('InvoiceController@index'));
        }

        if ($invoice->update($input) && $invoice->save()) {

            $htPrice = 0;
            $price = 0;

            $office = Office::findOrFail($request->office_id);
            $contact = Contact::findOrFail($request->contact_id);

            $invoice->office()->associate($office);

            if ($request->has('quote_id') && $request->quote_id != 0) {

                $quote = Quote::findOrFail($request->quote_id);
                $invoice->converted = true;


            } else {
                $invoice->converted = false;
            }


            if (!$request->has('products')) {
                $input["products"] = [];
            } else if (!$request->has('services')) {
                $input["services"] = [];
            }

            // Serialize

            foreach ($request->products as $product) {

                $totalTaxes = 0;
                $product = Product::findOrFail($product->id);

                foreach ($product->taxes as $tax) {

                    if ($tax->is_active) {
                        $totalTaxes = $totalTaxes + ($product->ht_price * ($tax->value / 100));
                    }
                }

                $productHtPrice = $product->ht_price;
                $htPrice = $htPrice + $productHtPrice;

                $productPrice = $product->ht_price + $totalTaxes;
                $price = $price + $productPrice;

            }

            foreach ($request->services as $service) {

                $totalTaxes = 0;
                $service = Service::findOrFail($service->id);

                foreach ($service->taxes as $tax) {

                    if ($tax->is_active) {
                        $totalTaxes = $totalTaxes + ($service->ht_price * ($tax->value / 100));
                    }
                }

                $serviceHtPrice = $service->ht_price;
                $servicePrice = $service->ht_price + $totalTaxes;

                $htPrice = $htPrice + $serviceHtPrice;
                $price = $price + $servicePrice;

            }

            $invoice->ht_price = $htPrice;
            $invoice->ttc_price = $price;
            $invoice->save();

            Flash::success(Lang::get('app.general:update-success'));

        } else {

            Flash::error(Lang::get('app.general:update-failed'));
            return redirect(action('InvoiceController@edit'));

        }

        return redirect(action('InvoiceController@index'));
    }

    /**
     * Remove the specified Invoice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (empty($invoice)) {
            Flash::error(Lang::get('app.general:missing-model'));

            return redirect(action('InvoiceController@index'));
        }

        $invoice->delete();

        Flash::success(Lang::get('app.general:delete-success'));

        return redirect(action('InvoiceController@index'));
    }
}
