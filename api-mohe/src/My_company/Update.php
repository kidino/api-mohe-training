<?php

namespace App\My_company;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;

class Update extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->connector->getConnection('My_company1');

		$id = $request->getUriFragment('id');
        $body = $request->getBody();

		// id, fullname, designation
		
        if (empty($body->fullname)) {
            throw new StatusCode\BadRequestException('No fullname provided');
        }

        if (empty($body->designation)) {
            throw new StatusCode\BadRequestException('No designation provided');
        }
		
        $connection->update('employees', [
            'fullname' => $body->fullname,
            'designation' => $body->designation,
            'status' => $body->status,
            'department' => $body->department,
            'salary' => $body->salary
			],
			[ 'id' => $id]
		);

        return $this->response->build(200, [], [
            'success' => true,
            'message' => 'Update successful',
        ]);
    }
}
