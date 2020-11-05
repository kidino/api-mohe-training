<?php

namespace App\My_company;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;

class Delete extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->connector->getConnection('My_company1');

        $affected = $connection->update('employees', [
            'deleted' => 1,
        ], [
            'id' => $request->getUriFragment('id')
        ]);

        if (empty($affected)) {
            throw new StatusCode\NotFoundException('Entry not available');
        }

        return $this->response->build(200, [], [
            'success' => true,
            'message' => 'Delete successful',
        ]);
    }
}
