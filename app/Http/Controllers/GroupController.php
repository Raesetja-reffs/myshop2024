<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportBuilderFile;
use App\Traits\UtilityTrait;
use App\Traits\ImageUpload;
use App\Traits\GroupTrait;
use App\Http\Requests\StoreReportBuilderFileRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupController extends Controller
{
    use UtilityTrait, ImageUpload, GroupTrait;

    /**
     * This function is used for show the set company permission page
     */
    public function index(Request $request)
    {
        $this->authorizeUserIsSuperAdmin();
        $pageSize = config('custom.pagination');
        $pageNumber = 1;
        if ($request->has('page') && $request->input('page')) {
            $pageNumber = $request->input('page');
        }
        $groups = $this->apiGroupResource([
            'intGroupId' => 0,
            'StatementType' => 'Select'
        ]);
        // Manually create a LengthAwarePaginator instance
        $total = count($groups);

        // Create a LengthAwarePaginator instance
        $groups = new LengthAwarePaginator(
            $groups,
            $total,
            $pageSize,
            $pageNumber,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('groups.index', compact('groups'));
    }

    /**
     * This function is used for shwo the create user page
     */
    public function create()
    {
        $this->authorizeUserIsSuperAdmin();

        return view('groups.create');
    }

    /**
     * This function is used for save the create user
     */
    public function store(StoreReportBuilderFileRequest $request)
    {
        $this->authorizeUserIsSuperAdmin();
        $data = $request->validated();
        $passData = $this->getRequestData($data);
        if ($request->hasFile('file_url')) {
            $response = $this->uploadImageToAzureBlob($request->file('file_url'));
            if ($response['status'] == 'success') {
                $passData['file_url'] = $response['imageUrl'];
            } else {

                return redirect()->route('report-builder-files.index')->with('error', $response['message']);
            }
        }
        ReportBuilderFile::create($passData);

        return redirect()->route('report-builder-files.index')->with('success', 'Report Builder File' . config('custom.flash_messages')['create']);
    }

    /**
     * This function is used for show the user details
     */
    public function show(ReportBuilderFile $reportBuilderFile)
    {
        $this->authorizeUserIsSuperAdmin();

        return view('report-builder-files.show', compact('reportBuilderFile'));
    }

    /**
     * This function is used for show the edit user page
     */
    public function edit(ReportBuilderFile $reportBuilderFile)
    {
        $this->authorizeUserIsSuperAdmin();
        $companies = $this->getCompaniesListForDropdown();

        return view('report-builder-files.edit', compact('reportBuilderFile', 'companies'));
    }

    /**
     * This function is used for save the update user
     */
    public function update(StoreReportBuilderFileRequest $request, ReportBuilderFile $reportBuilderFile)
    {
        $this->authorizeUserIsSuperAdmin();
        $data = $request->validated();
        $passData = $this->getRequestData($data);
        if ($request->hasFile('file_url')) {
            $response = $this->uploadImageToAzureBlob($request->file('file_url'));
            if ($response['status'] == 'success') {
                $this->removeImageToAzureBlob($reportBuilderFile->file_url);
                $passData['file_url'] = $response['imageUrl'];
            } else {

                return redirect()->route('report-builder-files.index')->with('error', $response['message']);
            }
        }
        $reportBuilderFile->update($passData);

        return redirect()->route('report-builder-files.index')->with('success', 'Report Builder File' . config('custom.flash_messages')['update']);
    }

    /**
     * This function is used for destroy the report builder file
     */
    public function destroy(ReportBuilderFile $reportBuilderFile)
    {
        $this->authorizeUserIsSuperAdmin();
        $this->removeImageToAzureBlob($reportBuilderFile->file_url);
        $reportBuilderFile->delete();

        return redirect()->route('report-builder-files.index')->with('success', 'Report Builder File' . config('custom.flash_messages')['delete']);
    }

    /**
     * This function is used for get the request data
     * @param array $data
     */
    private function getRequestData($data)
    {
        return [
            'company_id' => $data['company_id'],
            'company_name' => $data['company_name'],
            'report_type' => $data['report_type'],
        ];
    }

    public function downloadSampleFile($reportType)
    {
        $this->authorizeUserIsSuperAdmin();
        $filename = 'OrderInvoice.repx';
        if ($reportType == 2) {
            $filename = 'OrderInvoiceWithoutPrice.repx';
        }
        $reportTypeFilePath = public_path('reports/' . $filename);

        return response()->download($reportTypeFilePath);
    }
}
