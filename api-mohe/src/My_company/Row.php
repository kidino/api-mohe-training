<?php

namespace App\My_company;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;

class Row extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->connector->getConnection('My_company1');

        $sql = 'SELECT id, fullname, designation,
						salary, status, department
                  FROM employees
                 WHERE id = :id';

        $employee = $connection->fetchAssoc($sql, [
            'id' => $request->getUriFragment('id')
        ]);

        if (empty($employee)) {
            throw new StatusCode\NotFoundException('Employee not available');
        }

        return $this->response->build(200, [], $employee);
    }
}
