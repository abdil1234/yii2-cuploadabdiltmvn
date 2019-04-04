<?php

namespace abdiltmvn\Cupload;

/**
 * This is just an example.
 */
interface UploadInterface
{
    /**
     * method for upload file as the server side
     * @return boolean
     */

    public function uploadServer();

    /**
     * method for upload file as the client side
     * @return boolean
     */

    public function uploadClient();
}
