<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 09/12/20
 * Time: 4:07
 */

namespace App\Http\Controllers;


use App\Constant;
use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\InvoiceDto;
use App\Domain\Invoice\Models\InvoiceSearchDto;
use App\Domain\Invoice\Repositories\InvoiceRepository;
use App\Domain\Invoice\Services\InvoiceService;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\ValidationException;
use App\Helper\CommonHelper;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * @param Request $request
     * @param InvoiceRepository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(
        Request $request,
        InvoiceRepository $repository
    )
    {
        $searchDto = new InvoiceSearchDto();
        $searchDto->customerName = $request->get('customerName');
        $searchDto->issueFrom = $request->get('issueFrom');
        $searchDto->issueTo = $request->get('issueTo');
        $searchDto->dueFrom = $request->get('dueFrom');
        $searchDto->dueTo = $request->get('dueTo');

        $page = $request->get('page') ?? 1;
        $searchResult = $repository->search(Invoice::class, $searchDto, $page, Constant::DEFAULT_PAGING_SIZE,'issueDate');
        $arrInvoice = $searchResult->getArrayData();

        return view('pages.invoice.index',[
            'arrInvoice' => $arrInvoice,
            'page' => $page,
            'totalPage' => $searchResult->total_page,
        ]);
    }

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

    public function edit(
        int $id,
        Request $request,
        InvoiceService $invoiceService,
        InvoiceRepository $invoiceRepository,
        ItemRepository $itemRepository
    )
    {
        $invoice = $invoiceRepository->find($id);
        $itemList = $itemRepository->getAllActive($request->get('companyId'));
        $arrItem = CommonHelper::getArrayFromCollection($itemList);

        return view('pages.invoice.edit',[
            'invoice' => $invoice->toArray(),
            'arrItem' => $arrItem
        ]);
    }

    public function update(
        int $id,
        Request $request,
        InvoiceService $invoiceService
    )
    {
        try {
            $data = $request->json()->all();
            $invoiceDto = new InvoiceDto();
            $invoiceDto->fromArray($data);
            $invoiceDto->companyId = $request->get('companyId');

            $invoiceService->update($id, $invoiceDto);

            return response()->json(['message' => 'Update data success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function delete(
        int $id,
        InvoiceService $invoiceService
    )
    {
        try {
            $invoiceService->delete($id);
            return response()->json(['message' => 'Delete data success']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}