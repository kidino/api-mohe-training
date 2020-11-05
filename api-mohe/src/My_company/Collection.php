<?php

namespace App\My_company;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;

class Collection extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this->connector->getConnection('My_company1');

        $sql = 'SELECT id, fullname, designation
                  FROM employees 
					WHERE deleted is null
              ORDER BY id ASC';

        // $sql = $connection->getDatabasePlatform()->modifyLimitQuery($sql, 16);

        $count   = $connection->fetchColumn('SELECT COUNT(*) FROM employees');
        $entries = $connection->fetchAll($sql);

        return $this->response->build(200, [], [
            'totalResults' => $count,
            'entry' => $entries,
        ]);
    }
}
