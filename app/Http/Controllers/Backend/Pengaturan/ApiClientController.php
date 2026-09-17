<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Services\ApiClientService;
use App\Services\ApiRouteService;
use App\Models\ApiClient;
use App\Models\ApiPermission;

class ApiClientController extends Controller
{
    public function __construct(
        protected ApiRouteService $apiRouteService
    ) {
    }

    public function index()
    {
        return view('backend.pengaturan.api-client.index');
    }

    public function datatable()
    {
        $getData = ApiClient::query()
                    ->withCount('permissions')
                    ->latest()
                    ->get();
        $data = [];
        foreach ($getData as $d) {
            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'name' => $d->name,
                'permissions_count' => $d->permissions_count,
                'is_active' => $d->is_active
            ];
        }
        $data = collect($data);
        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_show = '<button type="button" name="regenarate" data-id="'.$id.'" class="regenarate btn btn-icon waves-effect btn-success" title="Regenarate Client Secret"><i class="fas fa-sync-alt"></i></button>';
                $button_permission = '<a href="'.route('cms.pengaturan.api-client.permissions', ['id' => $id]).'" class="btn btn-icon waves-effect btn-primary" title="Atur API Permission"><i class="fas fa-solid fa-user-shield"></i></a>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_show. ' ' . $button_permission .' ' . $button_delete;
                return $button;
            })
            ->addColumn('status', function($data){
                if($data['is_active'] == true)
                {
                    return '<span class="badge badge-success">Aktif</span>';
                } else {
                    return '<span class="badge badge-danger">Tidak Aktif</span>';
                }
            })
            ->rawColumns(['aksi', 'status'])
        ->make(true);
    }

    public function store(Request $request, ApiClientService $service)
    {
        $errors = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $clientId = $service->generateClientId();
            $clientSecret = $service->generateClientSecret();

            $apiClient = new ApiClient;
            $apiClient->name = $request->name;
            $apiClient->client_id = $clientId;
            $apiClient->client_secret_hash = $service->hashSecret($clientSecret);
            $apiClient->is_active = true;
            $apiClient->expires_at = null;
            $apiClient->save();

            return response()->json([
                'success' => 'Berhasil menambahkan Client',
                'data' => [
                    'name' => $apiClient->name,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function regenerate(Request $request, ApiClientService $service)
    {
        try {
            $id = Crypt::decryptString($request->id);
            $clientSecret = $service->generateClientSecret();

            $apiClient = ApiClient::find($id);
            $apiClient->client_secret_hash = $service->hashSecret($clientSecret);
            $apiClient->save();

            return response()->json([
                'success' => 'Berhasil regenarate ulang client secret',
                'data' => [
                    'name' => $apiClient->name,
                    'client_id' => $apiClient->client_id,
                    'client_secret' => $clientSecret,
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $apiClient = ApiClient::find($id);
            $apiClient->is_active = 0;
            $apiClient->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function permissions($id)
    {
        $id = Crypt::decryptString($id);

        $apiClient = ApiClient::findOrFail($id);

        $permissions = ApiPermission::query()
                        ->where('is_active', true)
                        ->get()
                        ->map(function ($permission) {
                            $route = $this->apiRouteService->findByName(
                                $permission->route_name
                            );

                            $permission->route_exists = $route !== null;

                            $permission->route_method_matches = $route !== null
                                && $route['method'] === $permission->method;

                            return $permission;
                        })
                        ->sortBy(function ($permission) {
                            $methodOrder = [
                                'GET' => 1,
                                'POST' => 2,
                                'PUT' => 3,
                                'PATCH' => 4,
                                'DELETE' => 5,
                            ];
                            $parts = explode('.', $permission->route_name);
                            $group = $parts[1] ?? 'other';
                            return sprintf(
                                '%s-%d-%s',
                                $group,
                                $methodOrder[$permission->method] ?? 99,
                                $permission->route_name
                            );
                        })
                        ->groupBy(function ($permission) {
                            $parts = explode('.', $permission->route_name);
                            return $parts[1] ?? 'other';
                        });

        $assignedPermissionIds = $apiClient
            ->permissions()
            ->pluck('api_permissions.id')
            ->toArray();

        return view('backend.pengaturan.api-client.permissions', [
            'apiClient' => $apiClient,
            'permissions' => $permissions,
            'assignedPermissionIds' => $assignedPermissionIds,
            'idApiClientEncrypted' => Crypt::encryptString($apiClient->id)
        ]);
    }

    public function updatePermissions(Request $request, $id)
    {
        try {
            $id = Crypt::decryptString($id);

            $apiClient = ApiClient::findOrFail($id);

            $validated = $request->validate([
                'permissions' => ['nullable', 'array'],
                'permissions.*' => [
                    'integer',
                    'distinct',
                    'exists:api_permissions,id',
                ],
            ]);

            $permissionIds = $validated['permissions'] ?? [];

            $activePermissionIds = ApiPermission::query()
                ->where('is_active', true)
                ->whereIn('id', $permissionIds)
                ->pluck('id')
                ->all();

            $apiClient->permissions()->sync($activePermissionIds);

            return response()->json([
                'success' => true,
                'message' => 'API Permission berhasil diperbarui.',
            ]);

        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {

            return response()->json([
                'success' => false,
                'message' => 'API Client tidak valid.',
            ], 404);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'API Client tidak ditemukan.',
            ], 404);

        } catch (\Throwable $th) {

            report($th);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui API Permission.',
            ], 500);
        }
    }
}
