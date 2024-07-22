<?php

namespace App\Traits;

use Exception;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Common\Exceptions\InvalidArgumentTypeException;
use Illuminate\Support\Facades\Log;

trait ImageUpload
{
    /**
     * This function is used for upload the image to microsoft azure blob
     * @param obj $imageFile
     */
    public function uploadImageToAzureBlob($imageFile)
    {
        $response = [
            'status' => 'error',
            'message' => '',
            'imageUrl' => '',
        ];
        // Create a unique file name for the image
        $fileName = time() . '_' . $imageFile->getClientOriginalName();

        // Create a new instance of the Azure Blob client
        $blobClient = $this->getBloblClient();

        try {
            // Upload the image file to Azure Blob Storage
            $blobClient->createBlockBlob(
                config('azure-storage.container'),
                $fileName,
                fopen($imageFile->getPathname(), 'r'),
                new CreateBlockBlobOptions()
            );
            $imageUrl = $blobClient->getBlobUrl(config('azure-storage.container'), $fileName);
            $response = [
                'status' => 'success',
                'message' => '',
                'imageUrl' => $imageUrl,
            ];
        } catch (ServiceException $e) {
            $response['message'] = $e->getMessage();
        } catch (InvalidArgumentTypeException $e) {
            $response['message'] = $e->getMessage();
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * This function is used for remove the image to microsoft azure blob
     * @param string $fileUrl
     */
    public function removeImageToAzureBlob($fileUrl)
    {
        $filename = pathinfo($fileUrl, PATHINFO_BASENAME);
        // Create a new instance of the Azure Blob client
        $blobClient = $this->getBloblClient();
        // Delete the file from Azure Blob Storage
        try {
            $blobClient->deleteBlob(
                config('azure-storage.container'),
                $filename,
                new DeleteBlobOptions()
            );
        } catch (ServiceException $e) {
            Log::error($e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * This function is used for get the blobclient
     */
    private function getBloblClient()
    {
        $connectionString = config('azure-storage.connection-string');
        $options["http"] = ["verify" => storage_path('certificates/cacert.pem')];

        return BlobRestProxy::createBlobService($connectionString, $options);
    }

}
