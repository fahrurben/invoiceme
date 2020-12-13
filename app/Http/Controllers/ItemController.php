<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 08/12/20
 * Time: 3:41
 */

namespace App\Http\Controllers;


use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;
use App\Domain\Item\Repositories\CategoryRepository;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\Item\Services\ItemService;
use App\Domain\ValidationException;
use App\Helper\CommonHelper;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @param Request $request
     * @param ItemRepository $repository
     * @param CategoryRepository $categoryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(
        Request $request,
        ItemRepository $repository,
        CategoryRepository $categoryRepository
    )
    {
        $searchDto = new ItemDto();
        $searchDto->name = $request->get('name');
        $searchDto->companyId = $request->get('companyId');
        $searchDto->categoryId = !empty($request->get('category')) ? $request->get('category') : null;
        $searchDto->type = !empty($request->get('type')) ? $request->get('type') : null;
        $searchDto->isActive = !empty($request->get('isActive')) ? $request->get('isActive') : null;

        $page = $request->get('page') ?? 1;
        $searchResult = $repository->search(Item::class, $searchDto, $page);
        $categoryList = $categoryRepository->getAllActive($request->get('companyId'));
        $arrCategory = CommonHelper::getArrayFromCollection($categoryList);

        $arrItem = $searchResult->getArrayData();

        return view('pages.item.index',[
            'arrItem' => $arrItem,
            'arrCategory' => $arrCategory,
            'page' => $page,
            'totalPage' => $searchResult->total_page,
        ]);
    }

    /**
     * @param Request $request
     * @param ItemService $itemService
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(
        Request $request,
        ItemService $itemService
    )
    {
        try {
            $data = $request->json()->all();
            $itemDto = new ItemDto();
            $itemDto->fromArray($data);
            $itemDto->companyId = $request->get('companyId');

            $itemService->create($itemDto);

            return response()->json(['message' => 'Create data success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }


    public function detail(
        int $id,
        ItemRepository $repository
    )
    {
        try {
            Gate::authorize('view-own', $repository->find($id));
            $item = $repository->find($id);

            return response()->json($item->toArray());
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


    public function update(
        int $id,
        Request $request,
        ItemService $itemService,
        ItemRepository $itemRepository
    )
    {
        try {
            Gate::authorize('update-own', $itemRepository->find($id));

            $data = $request->json()->all();
            $itemDto = new ItemDto();
            $itemDto->fromArray($data);
            $itemDto->companyId = $request->get('companyId');


            $itemService->update($id, $itemDto);

            return response()->json(['message' => 'Update data success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function delete(
        int $id,
        ItemService $itemService,
        ItemRepository $itemRepository
    )
    {
        try {
            Gate::authorize('update-own', $itemRepository->find($id));

            $itemService->delete($id);
            return response()->json(['message' => 'Delete data success']);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Cannot delete data'], 500);
        }
    }
}