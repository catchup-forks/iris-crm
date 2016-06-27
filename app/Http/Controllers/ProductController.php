<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProductController extends InfyOmBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productRepository->pushCriteria(new RequestCriteria($request));
        $products = $this->productRepository->all();

        return view('pages.products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $contacts = Contact::lists('firstname' . 'lastname', 'id');
        $taxes = Tax::lists('name' . ' : ' . 'value' . ' %', 'id');

        return view('pages.products.create')->with(compact('contacts', 'taxes'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        if ($product = $this->productRepository->create($input)) {

            $contact = Contact::findOrFail($request->manutention_officer_id);

            $product->taxes()->sync($input["taxes"] ?: []);
            $product->contact()->associate($contact);

            $product->save();

            Flash::success(Lang::get('app.general:create-success'));

        } else {

            Flash::error(Lang::get('app.general:create-failed'));
            return redirect(route('products.create'));

        }

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('pages.products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findWithoutFail($id);
        $contacts = Contact::lists('firstname' . 'lastname', 'id');
        $taxes = Tax::lists('name' . ' : ' . 'value' . ' %', 'id');

        if (empty($product)) {

            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        return view('pages.products.edit')->with(compact('product', 'contacts', 'taxes'));
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->findWithoutFail($id);
        $input = $request->all();

        $contact = Contact::findOrFail($request->manutention_officer_id);

        if (empty($product)) {
            Flash::error(trans('app.general:undefined'));

            return redirect(route('products.index'));
        }

        if ($product = $this->productRepository->update($request->all(), $id)) {

            $product->taxes()->sync($input["taxes"] ?: []);
            $product->contact()->associate($contact);
            $product->save();
            Flash::success(Lang::get('app.organization:update-success'));

        } else {
            Flash::error(Lang::get('app.organization:update-failed'));
            return redirect(route('products.edit'));

        }


        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('Product not found');

            return redirect(route('products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success('Product deleted successfully.');

        return redirect(route('products.index'));
    }
}