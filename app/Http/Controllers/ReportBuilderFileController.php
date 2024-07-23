<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportBuilderFile;
use App\Traits\UtilityTrait;
use App\Traits\ImageUpload;
use App\Http\Requests\StoreReportBuilderFileRequest;

class ReportBuilderFileController extends Controller
{
    use UtilityTrait;
    use ImageUpload;

    /**
     * This function is used for show the set company permission page
     */
    public function index(Request $request)
    {
        $reportBuilderFiles = ReportBuilderFile::latest();

        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $reportBuilderFiles = $reportBuilderFiles->where(function ($query) use ($search) {
                $query->orWhere('company_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('selectedCompanies')) {
            $selectedCompanies = $request->input('selectedCompanies');
            if (count($selectedCompanies) == 1 && $selectedCompanies[0] == null) {
                $selectedCompanies = [];
            }
            if ($selectedCompanies) {
                $reportBuilderFiles = $reportBuilderFiles->whereIn('company_id', $selectedCompanies);
            }
        }

        $reportBuilderFiles = $reportBuilderFiles->paginate(config('custom.pagination'));

        $companies = $this->getCompaniesListForDropdown();

        return view('report-builder-files.index', compact('reportBuilderFiles', 'companies'));
    }

    /**
     * This function is used for shwo the create user page
     */
    public function create()
    {
        $companies = $this->getCompaniesListForDropdown();

        return view('report-builder-files.create', compact('companies'));
    }

    /**
     * This function is used for save the create user
     */
    public function store(StoreReportBuilderFileRequest $request)
    {
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
        return view('report-builder-files.show', compact('reportBuilderFile'));
    }

    /**
     * This function is used for show the edit user page
     */
    public function edit(ReportBuilderFile $reportBuilderFile)
    {
        $companies = $this->getCompaniesListForDropdown();

        return view('report-builder-files.edit', compact('reportBuilderFile', 'companies'));
    }

    /**
     * This function is used for save the update user
     */
    public function update(StoreReportBuilderFileRequest $request, ReportBuilderFile $reportBuilderFile)
    {
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
        $filename = 'OrderInvoice.repx';
        if ($reportType == 2) {
            $filename = 'OrderInvoiceWithoutPrice.repx';
        }
        $reportTypeFilePath = public_path('reports/' . $filename);

        return response()->download($reportTypeFilePath);
    }
}
