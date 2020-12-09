<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 09/12/20
 * Time: 4:07
 */

namespace App\Http\Controllers;


use App\Domain\Invoice\Models\InvoiceDto;
use App\Domain\Invoice\Services\InvoiceService;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\ValidationException;
use App\Helper\CommonHelper;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create(
        Request $request,
        InvoiceService $invoiceService,
        ItemRepository $itemRepository
    )
    {
        $itemList = $itemRepository->getAllActive($request->get('companyId'));
        $arrItem = CommonHelper::getArrayFromCollection($itemList);

        return view('pages.invoice.create',[
            'arrItem' => $arrItem
        ]);
    }

    public function store(
        Request $request,
        InvoiceService $invoiceService
    )
    {
        try {
            $data = $request->json()->all();
            $invoiceDto = new InvoiceDto();
            $invoiceDto->fromArray($data);
            $invoiceDto->companyId = $request->get('companyId');

            $invoiceService->create($invoiceDto);

            return response()->json(['message' => 'Create data success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }
}