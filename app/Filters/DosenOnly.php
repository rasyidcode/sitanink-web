<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Shared\Models\UserModel;

class DosenOnly implements FilterInterface
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
        $username = $request->getVar()->username ?? null;
        if (is_null($username)) {
            throw new ApiAccessErrorException(
                message: 'Request tidak valid!',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        if (!(new UserModel())->isMahasiswa($request->getVar()->username)) {
            throw new ApiAccessErrorException(
                message: 'Hanya mahasiswa yang dapat mengakses request ini!',
                statusCode: ResponseInterface::HTTP_FORBIDDEN
            );
        }

        return $request;
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
