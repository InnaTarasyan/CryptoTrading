<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoCompare\CryptoCompareMarkets;
use App\Models\CryptoCompare\CryptoCompareNews;
use App\Models\CryptoCompare\CryptoCompareExchanges;
use App\Models\CryptoCompare\CryptoCompareCoins;
use App\Models\CryptoCompare\CryptoCompareTopPairs;

class CryptoCompareApiController extends Controller
{
	public function markets(Request $request)
	{
		$query = CryptoCompareMarkets::query();
		$perPage = min((int) $request->get('per_page', 50), 100);
		$data = $query->paginate($perPage);
		return response()->json([
			'status' => 'success',
			'data' => $data->items(),
			'pagination' => [
				'current_page' => $data->currentPage(),
				'last_page' => $data->lastPage(),
				'per_page' => $data->perPage(),
				'total' => $data->total(),
			],
		]);
	}

	public function news(Request $request)
	{
		$query = CryptoCompareNews::query();
		$perPage = min((int) $request->get('per_page', 50), 100);
		$data = $query->paginate($perPage);
		return response()->json([
			'status' => 'success',
			'data' => $data->items(),
			'pagination' => [
				'current_page' => $data->currentPage(),
				'last_page' => $data->lastPage(),
				'per_page' => $data->perPage(),
				'total' => $data->total(),
			],
		]);
	}

	public function exchanges(Request $request)
	{
		$query = CryptoCompareExchanges::query();
		$perPage = min((int) $request->get('per_page', 50), 100);
		$data = $query->paginate($perPage);
		return response()->json([
			'status' => 'success',
			'data' => $data->items(),
			'pagination' => [
				'current_page' => $data->currentPage(),
				'last_page' => $data->lastPage(),
				'per_page' => $data->perPage(),
				'total' => $data->total(),
			],
		]);
	}

	public function coins(Request $request)
	{
		$query = CryptoCompareCoins::query();
		$perPage = min((int) $request->get('per_page', 50), 100);
		$data = $query->paginate($perPage);
		return response()->json([
			'status' => 'success',
			'data' => $data->items(),
			'pagination' => [
				'current_page' => $data->currentPage(),
				'last_page' => $data->lastPage(),
				'per_page' => $data->perPage(),
				'total' => $data->total(),
			],
		]);
	}

	public function topPairs(Request $request)
	{
		$query = CryptoCompareTopPairs::query();
		$perPage = min((int) $request->get('per_page', 50), 100);
		$data = $query->paginate($perPage);
		return response()->json([
			'status' => 'success',
			'data' => $data->items(),
			'pagination' => [
				'current_page' => $data->currentPage(),
				'last_page' => $data->lastPage(),
				'per_page' => $data->perPage(),
				'total' => $data->total(),
			],
		]);
	}
} 