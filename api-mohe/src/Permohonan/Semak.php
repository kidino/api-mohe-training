<?php

namespace App\Permohonan;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use PSX\Http\Exception as StatusCode;

class Semak extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->connector->getConnection('My_company1');

        $sql = 'SELECT id, nokp, status
                  FROM permohonan
                 WHERE nokp = :nokp';

        $status = $connection->fetchAssoc($sql, [
            'nokp' => $request->getUriFragment('nokp')
        ]);

        if (empty($status)) {
            throw new StatusCode\NotFoundException('Permohonan tidak dijumpai');
        }

        return $this->response->build(200, [], $status);
    }
}
