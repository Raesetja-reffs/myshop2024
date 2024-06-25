<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentralUser;
use App\Traits\UtilityTrait;
use App\Http\Requests\StoreCentralUserRequest;
use App\Http\Requests\StoreCentralUserResetPasswordRequest;
use App\Http\Requests\UpdateCentralUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class CentralUserController extends Controller
{
    use UtilityTrait;

    /**
     * This function is used for show the set company permission page
     */
    public function index(Request $request)
    {
        $centralUsers = CentralUser::latest();
        if (!auth()->guard('central_api_user')->user()->isAdmin()) {
            $users = $centralUsers->where('company_id', auth()->guard('central_api_user')->user()->company_id);
        }

        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $centralUsers = $centralUsers->where(function ($query) use ($search) {
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
                $centralUsers = $centralUsers->whereIn('company_id', $selectedCompanies);
            }
        }

        $centralUsers = $centralUsers->paginate(config('custom.pagination'));

        $companies = $this->getCompaniesListForDropdown();

        return view('central-users.index', compact('centralUsers', 'companies'));
    }

    /**
     * This function is used for shwo the create user page
     */
    public function create()
    {
        $companies = $this->getCompaniesListForDropdown();

        return view('central-users.create', compact('companies'));
    }

    /**
     * This function is used for save the create user
     */
    public function store(StoreCentralUserRequest $request)
    {
        CentralUser::create($this->getRequestData($request->validated()));

        return redirect()->route('central-users.index')->with('success', 'Central User' . config('custom.flash_messages')['create']);
    }

    /**
     * This function is used for show the user details
     */
    public function show(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('view', $centralUser);

        return view('central-users.show', compact('centralUser'));
    }

    /**
     * This function is used for show the edit user page
     */
    public function edit(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('update', $centralUser);

        $companies = $this->getCompaniesListForDropdown();

        return view('central-users.edit', compact('centralUser', 'companies'));
    }

    /**
     * This function is used for save the update user
     */
    public function update(UpdateCentralUserRequest $request, CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('update', $centralUser);

        $centralUser->update($this->getRequestData($request->validated(), true));

        return redirect()->route('central-users.index')->with('success', 'Central User' . config('custom.flash_messages')['update']);
    }

    /**
     * This function is used for destroy the user
     */
    public function destroy(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('delete', $centralUser);

        $centralUser->delete();

        return redirect()->route('central-users.index')->with('success', 'Central User' . config('custom.flash_messages')['delete']);
    }

    /**
     * This function is used for get the request data
     * @param array $data
     * @param bool $isUpdate
     */
    private function getRequestData($data, $isUpdate = false)
    {
        $companyId = auth()->guard('central_api_user')->user()->company_id;
        if (auth()->guard('central_api_user')->user()->isAdmin()) {
            $companyId = $data['company_id'];
        }
        $returnData = [
            'company_id' => $companyId,
            'username' => $data['username'],
            'erp_apiurl' => $data['erp_apiurl'],
            'erp_apiusername' => $data['erp_apiusername'],
            'erp_apipassword' => $data['erp_apipassword'],
            'erp_apiauthtoken' => $data['erp_apiauthtoken'],
            'location_id' => $data['location_id'],
        ];
        if (!$isUpdate) {
            $returnData['password'] = Hash::make($data['password']);
            $returnData['internal_pass'] = encrypt($data['password']);
        }

        return $returnData;
    }

    /**
     * This function is used for reset the user password
     */
    public function resetPassword(CentralUser $centralUser)
    {
        Gate::forUser(auth('central_api_user')->user())->authorize('resetPassword', $centralUser);

        return view('central-users.reset-password', compact('centralUser'));
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

        return redirect()->route('central-users.index')->with('success', 'Central User Reset Password' . config('custom.flash_messages')['update']);
    }
}
