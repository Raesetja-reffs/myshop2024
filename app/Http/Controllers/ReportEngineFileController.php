<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportEngineFile;
use App\Traits\UtilityTrait;
use App\Traits\ImageUpload;
use App\Http\Requests\StoreReportEngineFileRequest;

class ReportEngineFileController extends Controller
{
    use UtilityTrait;
    use ImageUpload;

    /**
     * This function is used for show the set company permission page
     */
    public function index(Request $request)
    {
        $reportEngineFiles = ReportEngineFile::latest();

        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $reportEngineFiles = $reportEngineFiles->where(function ($query) use ($search) {
                $query->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('erp_user_id', 'like', '%' . $search . '%')
                    ->orWhere('erp_apiusername', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('selectedCompanies')) {
            $selectedCompanies = $request->input('selectedCompanies');
            if (count($selectedCompanies) == 1 && $selectedCompanies[0] == null) {
                $selectedCompanies = [];
            }
            if ($selectedCompanies) {
                $reportEngineFiles = $reportEngineFiles->whereIn('company_id', $selectedCompanies);
            }
        }

        $reportEngineFiles = $reportEngineFiles->paginate(config('custom.pagination'));

        $companies = $this->getCompaniesListForDropdown();

        return view('report-engine-files.index', compact('reportEngineFiles', 'companies'));
    }

    /**
     * This function is used for shwo the create user page
     */
    public function create()
    {
        $companies = $this->getCompaniesListForDropdown();

        return view('report-engine-files.create', compact('companies'));
    }

    /**
     * This function is used for save the create user
     */
    public function store(StoreReportEngineFileRequest $request)
    {
        $data = $request->validated();
        $passData = $this->getRequestData($data);
        $passData['file_url'] = "https://blobdigitalappfiles.blob.core.windows.net/linxdefault/1721648428_Akash1.repx";
        if ($request->hasFile('file_url')) {
            $response = $this->uploadImageToAzureBlob($request->file('file_url'));
            if ($response['status'] == 'success') {
                $passData['file_url'] = $response['imageUrl'];
            } else {

                return redirect()->route('report-engine-files.index')->with('error', $response['message']);
            }
        }
        ReportEngineFile::create($passData);

        return redirect()->route('report-engine-files.index')->with('success', 'Report Engine File' . config('custom.flash_messages')['create']);
    }

    /**
     * This function is used for show the user details
     */
    public function show(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('view', $centralUser);

        return view('reportengine-files.show', compact('centralUser'));
    }

    /**
     * This function is used for show the edit user page
     */
    public function edit(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('update', $centralUser);

        $companies = $this->getCompaniesListForDropdown();

        return view('reportengine-files.edit', compact('centralUser', 'companies'));
    }

    /**
     * This function is used for save the update user
     */
    public function update(UpdateCentralUserRequest $request, CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('update', $centralUser);

        $centralUser->update($this->getRequestData($request->validated(), true));

        return redirect()->route('reportengine-files.index')->with('success', 'Central User' . config('custom.flash_messages')['update']);
    }

    /**
     * This function is used for destroy the user
     */
    public function destroy(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('delete', $centralUser);
        $data = [
            'CentralUserId' => $centralUser->id,
            'ErpUserId' => $centralUser->erp_user_id,
            'companyid' => $centralUser->company_id,
        ];
        $centralUser->delete();

        $this->deleteCentralDimsUser($data);

        return redirect()->route('reportengine-files.index')->with('success', 'Central User' . config('custom.flash_messages')['delete']);
    }

    /**
     * This function is used for get the request data
     * @param array $data
     * @param bool $isUpdate
     */
    private function getRequestData($data, $isUpdate = false)
    {
        $companyId = $data['company_id'];
        $companyName = $data['company_name'];
        $returnData = [
            'company_id' => $companyId,
            'company_name' => $companyName,
        ];

        return $returnData;
    }

    /**
     * This function is used for reset the user password
     */
    public function resetPassword(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('resetPassword', $centralUser);

        return view('reportengine-files.reset-password', compact('centralUser'));
    }

    /**
     * This function is used for store the reset password for user
     */
    public function storeResetPassword(StoreCentralUserResetPasswordRequest $request, CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('resetPassword', $centralUser);

        $data = $request->validated();
        $centralUser->update([
            'password' => Hash::make($data['password']),
            'internal_pass' => encrypt($data['password']),
        ]);

        return redirect()->route('reportengine-files.index')->with('success', 'Central User Reset Password' . config('custom.flash_messages')['update']);
    }
}
