<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AddPekerjaFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $_POST['nik2']   = join(explode('-', $_POST['nik']));
        if (isset($_POST['domisili2'])) {
            $_POST['domisili'] = $_POST['domisili2'];
        }
        if (isset($_POST['lokasi_kerja2'])) {
            $_POST['lokasi_kerja'] = $_POST['lokasi_kerja2'];
        }
        if (isset($rawDataPost['jenis_pekerja2'])) {
            $_POST['jenis_pekerja'] = $_POST['jenis_pekerja2'];
        }
        if (isset($_POST['pekerjaan2'])) {
            $_POST['pekerjaan'] = $_POST['pekerjaan2'];
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
