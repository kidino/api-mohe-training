<?php

namespace App\My_company;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;

class Insert extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->connector->getConnection('My_company1');

        $body = $request->getBody();

		// id, fullname, designation
		
        if (empty($body->fullname)) {
            throw new StatusCode\BadRequestException('No fullname provided');
        }

        if (empty($body->designation)) {
            throw new StatusCode\BadRequestException('No designation provided');
        }
		
        $connection->insert('employees', [
            'fullname' => $body->fullname,
            'designation' => $body->designation,
            'status' => $body->status,
            'department' => $body->department,
            'salary' => $body->salary
        ]);

        return $this->response->build(201, [], [
            'success' => true,
            'message' => 'Insert successful',
        ]);
    }
}
