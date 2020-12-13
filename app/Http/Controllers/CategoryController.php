<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 02/12/20
 * Time: 4:10
 */

namespace App\Http\Controllers;


use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\CategoryDto;
use App\Domain\Item\Repositories\CategoryRepository;
use App\Domain\Item\Services\CategoryService;
use App\Domain\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index(
        Request $request,
        CategoryRepository $repository
    )
    {
        $searchDto = new CategoryDto();
        $searchDto->name = $request->get('name');
        $searchDto->companyId = $request->get('companyId');
        $searchDto->isActive = !empty($request->get('isActive')) ? $request->get('isActive') : null;

        $page = $request->get('page') ?? 1;
        $searchResult = $repository->search(Category::class, $searchDto, $page);
        $arrCategory = $searchResult->getArrayData();

        return view('pages.category.index',[
            'arrCategory' => $arrCategory,
            'page' => $page,
            'totalPage' => $searchResult->total_page,
        ]);
    }

    public function create(
        Request $request,
        CategoryService $categoryService
    )
    {
        try {
            $data = $request->json()->all();
            $categoryDto = new CategoryDto();
            $categoryDto->fromArray($data);
            $categoryDto->companyId = $request->get('companyId');


            $categoryService->create($categoryDto);

            return response()->json(['message' => 'Create data success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function detail(
        int $id,
        CategoryRepository $repository
    )
    {
        try {
            Gate::authorize('view-own', $repository->find($id));
            $category = $repository->find($id);

            return response()->json($category->toArray());
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(
        int $id,
        Request $request,
        CategoryService $categoryService,
        CategoryRepository $categoryRepository
    )
    {
        try {
            Gate::authorize('update-own', $categoryRepository->find($id));

            $data = $request->json()->all();
            $categoryDto = new CategoryDto();
            $categoryDto->fromArray($data);
            $categoryDto->companyId = $request->get('companyId');


            $categoryService->update($id, $categoryDto);

            return response()->json(['message' => 'Update data success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    public function delete(
        int $id,
        CategoryService $categoryService,
        CategoryRepository $categoryRepository
    )
    {
        try {
            Gate::authorize('update-own', $categoryRepository->find($id));

            $categoryService->delete($id);
            return response()->json(['message' => 'Delete data success']);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Cannot delete data'], 500);
        }
    }
}