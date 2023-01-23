<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TransactionRequest;
use App\Repositories\TransactionRepository;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    use ApiResponser;
    
    protected $repository;

    public function __construct(
        TransactionRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function index(): JsonResponse
    {        
        $transaction = $this->repository->getAll();
        return $this->success($transaction, 'transaction fetched successfully');  
    }


    public function store(TransactionRequest $request): JsonResponse
    {        
        $transaction = $this->repository->created($request->all());

        return $this->success(TransactionResource::ResponseMapTransaction($transaction), 'transaction created successfully', 201);
    }

    public function show($id): JsonResponse
    {
        $transaction = $this->repository->getShow($id);
        return $this->success(TransactionResource::ResponseMapTransaction($transaction), 'transaction fetched successfully');
    }

    public function update(TransactionRequest $request, $id): JsonResponse
    {
        $transaction= $this->repository->updated($id, $request->all());

        return $this->success(TransactionResource::ResponseMapTransaction($transaction), 'transaction updated successfully', 201);
    }

    public function destroy($id): JsonResponse
    {
        $transaction = $this->repository->deleted($id);

        return $this->success(TransactionResource::ResponseMapTransaction($transaction), 'transaction deleted successfully');
    }

    
}
