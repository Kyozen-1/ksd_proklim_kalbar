<?php

namespace App\Http\Controllers\Backend\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ApiRouteService;
use App\Models\ApiPermission;

class ApiPermissionController extends Controller
{
    public function __construct(
        protected ApiRouteService $apiRouteService
    ) {
    }

    public function index()
    {
        return view('backend.pengaturan.api-permission.index');
    }

    public function datatable()
    {
        $getData = ApiPermission::query()
            ->latest()
            ->get();

        $data = [];

        foreach ($getData as $d) {

            $route = $this->apiRouteService->findByName(
                $d->route_name
            );

            $data[] = [
                'id' => Crypt::encryptString($d->id),
                'name' => $d->name,
                'route_name' => $d->route_name,
                'uri' => $route['uri'] ?? '-',
                'method' => $d->method,
                'description' => $d->description,
                'is_active' => $d->is_active,
            ];
        }

        $data = collect($data);

        return DataTables::collection($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                $id = $data['id'];
                $button_edit =
                    '<a href="' .
                    route(
                        'cms.pengaturan.api-permission.edit',
                        $id
                    ) .
                    '" class="btn btn-icon waves-effect btn-warning"
                        title="Edit API Permission">
                        <i class="fas fa-edit"></i>
                    </a>';

                if ($data['is_active']) {

                    $button_status =
                        '<button
                            type="button"
                            name="delete"
                            id="' . $id . '"
                            class="delete btn btn-icon waves-effect btn-danger"
                            title="Nonaktifkan API Permission">
                            <i class="fas fa-trash"></i>
                        </button>';

                } else {

                    $button_status =
                        '<button
                            type="button"
                            name="activate"
                            id="' . $id . '"
                            class="activate btn btn-icon waves-effect btn-success"
                            title="Aktifkan API Permission">
                            <i class="fas fa-check"></i>
                        </button>';
                }

                return $button_edit . ' ' . $button_status;
            })
            ->addColumn('status', function ($data) {
                if ($data['is_active'] == true) {
                    return '<span class="badge badge-success">
                                Aktif
                            </span>';
                }
                return '<span class="badge badge-danger">
                            Tidak Aktif
                        </span>';
            })
            ->rawColumns(['aksi','status'])
            ->make(true);
    }

    public function create()
    {
        $routes = $this->apiRouteService->availableRoutes();

        return view('backend.pengaturan.api-permission.create', [
            'routes' => $routes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:api_permissions,name',
            ],

            'route_name' => [
                'required',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /**
         * IMPORTANT:
         *
         * Never trust route_name submitted
         * by the browser.
         *
         * Verify it against the actual Laravel routes.
         */
        $route = $this->apiRouteService->findByName(
                    $validated['route_name']
                );

        if (!$route) {
            return back()
                ->withErrors([
                    'route_name' => 'Route API tidak valid.',
                ])
                ->withInput();
        }

        /**
         * One route = one permission.
         */
        $alreadyExists = ApiPermission::query()
            ->where('route_name', $route['name'])
            ->exists();

        if ($alreadyExists) {
            return back()
                ->withErrors([
                    'route_name' => 'Route API tersebut sudah memiliki permission.',
                ])
                ->withInput();
        }

        ApiPermission::create([
            'name' => $validated['name'],
            'slug' => $route['name'],
            'route_name' => $route['name'],
            'method' => $route['method'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean(
                'is_active',
                true
            ),
        ]);

        Alert::success('Berhasil', 'API Permission berhasil dibuat');
        return redirect()->route('cms.pengaturan.api-permission.index');
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $apiPermission = ApiPermission::findOrFail($id);

        $routes = $this->apiRouteService->availableRoutes();

        return view('backend.pengaturan.api-permission.edit', [
            'permission' => $apiPermission,
            'routes' => $routes,
            'idApiPermissionEncrypted' => Crypt::encryptString($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);

        $apiPermission = ApiPermission::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:api_permissions,name,' . $apiPermission->id,
            ],

            'route_name' => [
                'required',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        * Jangan percaya route_name dari browser.
        * Validasi kembali terhadap route Laravel.
        */
        $route = $this->apiRouteService->findByName(
            $validated['route_name']
        );

        if (!$route) {
            return back()
                ->withErrors([
                    'route_name' => 'Route API tidak valid.',
                ])
                ->withInput();
        }

        /*
        * Satu route hanya boleh memiliki satu permission.
        * Kecualikan permission yang sedang diedit.
        */
        $alreadyExists = ApiPermission::query()
            ->where('route_name', $route['name'])
            ->where('id', '!=', $apiPermission->id)
            ->exists();

        if ($alreadyExists) {
            return back()
                ->withErrors([
                    'route_name' => 'Route API tersebut sudah memiliki permission.',
                ])
                ->withInput();
        }

        $apiPermission->update([
            'name' => $validated['name'],
            'slug' => $route['name'],
            'route_name' => $route['name'],
            'method' => $route['method'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        Alert::success('Berhasil', 'API Permission berhasil diperbarui');
        return redirect()->route('cms.pengaturan.api-permission.index');
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);

            $apiPermission = ApiPermission::findOrFail($id);

            $apiPermission->is_active = false;
            $apiPermission->save();

            return response()->json([
                'success' => 'Berhasil menghapus API Permission'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }

    public function activate($id)
    {
        try {
            $id = Crypt::decryptString($id);

            $apiPermission = ApiPermission::findOrFail($id);

            $apiPermission->is_active = true;
            $apiPermission->save();

            return response()->json([
                'success' => 'API Permission berhasil diaktifkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ]);
        }
    }

    public function sync()
    {
        try {

            $result = $this->apiRouteService->syncPermissions();

            return response()->json([
                'success' => true,
                'message' => $result['created'] > 0
                    ? "{$result['created']} API Permission baru berhasil ditambahkan."
                    : 'Tidak ada API Permission baru.',
                'created' => $result['created'],
                'orphaned' => $result['orphaned'],
            ]);

        } catch (\Throwable $th) {

            report($th);

            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan sinkronisasi API Permission.',
            ], 500);
        }
    }
}
