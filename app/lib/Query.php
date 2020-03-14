<?php

namespace App\lib;

class Query {

    protected $db;
    protected $queryFactory;

    public function __construct(\Aura\SqlQuery\QueryFactory $queryFactory) {

        $this->pdo = Db::getInstance();
        $this->queryFactory = $queryFactory;
    }

    public function update($table, array $cols, $where, $value, array $values = [] ) {

        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($cols)
            ->where("{$where} = :{$where}")
            ->bindValue($where, $value)
            ->bindValues($values);
        
        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }
    public function select(array $cols, $tablename, array $orderBy=[], $where='', $selector='', $value='' ) {

        $select = $this->queryFactory->newSelect();

        $select->cols($cols)
                ->from($tablename);
                if(!empty($orderBy)) {$select->orderBy($orderBy);}
                if(!empty($where)) {$select->where($where);}
                if(!empty($value)) {$select->bindValue($selector, $value);}
                
        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());
        
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function selectJoin(array $cols, $tablename, array $join, array $join2=[], $orderBy, $where='', $where2='', array $bindValues = [], $limit = '', $offset='' ) {

        $select = $this->queryFactory->newSelect();

        $select->cols($cols)
                ->from($tablename)
                ->join($join['0'], $join['1'], $join['2'])
                ->orderBy([$orderBy]);
                if(!empty($join2)) {$select->join($join2['0'], $join2['1'], $join2['2']);}
                if(!empty($where)) {$select->where($where);}
                if(!empty($where2)) {$select->where($where2);}
                if(!empty($bindValues)) {$select->bindValues($bindValues);}
                if(!empty($limit)) {$select->limit($limit);}
                if(!empty($offset)) {$select->offset($offset);}

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function insert($table, array $cols, array $values ) {

        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($cols)
            ->bindValues($values);


        $sth = $this->pdo->prepare($insert->getStatement());
        

        $sth->execute($insert->getBindValues());

        return 1;

        
    }
    public function delete($table, $id) {

        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }
}